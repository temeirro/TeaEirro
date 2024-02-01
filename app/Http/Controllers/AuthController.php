<?php
namespace App\Http\Controllers;

use App\Models\GoogleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/login",
     *   tags={"Auth"},
     *   summary="Login",
     *   operationId="login",
     *   @OA\RequestBody(
     *     required=true,
     *     description="User login data",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         required={"email", "password"},
     *         @OA\Property(property="email", type="string"),
     *         @OA\Property(property="password", type="string"),
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\MediaType(
     *       mediaType="application/json"
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Bad Request"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Not Found"
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Forbidden"
     *   )
     * )
     */
    public function login(Request $request) {
        $validation = Validator::make($request->all(),[
            'email'=> 'required|email',
            'password'=> 'required|string|min:6'
        ], [
            'email.required' => 'Пошта є обов\'язковим полем.',
            'email.email' => 'Пошта є невалідною.',
            'password.required' => 'Пароль не може бути порожнім.',
            'password.min' => 'Довжина пароля складає мінімум 6 символів.',
        ]);
        if($validation->fails()) {
            return response()->json($validation->errors(), Response::HTTP_BAD_REQUEST);
        }
        if(!$token = auth()->attempt($validation->validated())) {
            return response()->json(['error'=>'Дані вказано не вірно'], Response::HTTP_UNAUTHORIZED);
        }
        return response()->json(['token'=>$token], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *   path="/api/loginGoogle",
     *   tags={"Auth"},
     *   summary="Login",
     *   operationId="login",
     *   @OA\RequestBody(
     *     required=true,
     *     description="User login data",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         required={"email", "googleId"},
     *         @OA\Property(property="email", type="string"),
     *         @OA\Property(property="googleId", type="string"),
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\MediaType(
     *       mediaType="application/json"
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Bad Request"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Not Found"
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Forbidden"
     *   )
     * )
     */
    public function loginGoogle(Request $request) {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'googleId' => 'required|string',
        ], [
            'email.required' => 'Пошта є обов\'язковим полем.',
            'email.email' => 'Пошта є невалідною.',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), Response::HTTP_BAD_REQUEST);
        }

        $userGoogle = GoogleUser::where('googleId', $validation->validated()['googleId'])->first();

        if (!$userGoogle) {
            return response()->json(['error' => 'Користувача з таким Google ID не знайдено'], Response::HTTP_UNAUTHORIZED);
        }

        // If the user exists, attempt to log in
        if (!$token = auth()->login($userGoogle)) {
            return response()->json(['error' => 'Дані вказано не вірно'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['token' => $token], Response::HTTP_OK);
    }


    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "lastName", "image", "phone", "email", "role", "password"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="lastName", type="string"),
     *             @OA\Property(property="image", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="role", type="string"),
     *             @OA\Property(property="password", type="string", format="password", minLength=6),
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", description="Authentication token"),
     *         )
     *     ),
     *     @OA\Response(response="400", description="Bad request, validation error"),
     * )
     */
    public function register(Request $request) {

        $validation = Validator::make($request->all(),[
            'name'=> 'required|string',
            'lastName'=> 'required|string',
            'image'=> 'required|string',
            'phone'=> 'required|string',
            'email'=> 'required|string',
            'role'=> 'required|string',
            'password'=> 'required|string|min:6',
        ]);

        if($validation->fails()) {
            return response()->json($validation->errors(), Response::HTTP_BAD_REQUEST);
        }

        $input = $request->all();
        $imageName = uniqid().".webp";
        // create image manager with desired driver
        $manager = new ImageManager(new Driver());
        $imageRead = $manager->read($input["image"]);
        $path=public_path('upload/'.$imageName);
        $imageRead->toWebp()->save($path);

        $user = User::create(array_merge(
            $validation->validated(),
            ['password' => bcrypt($request->password), 'image'=> $imageName]
        ));
        return response()->json(['token'=>$user], Response::HTTP_OK);
    }

    public function getUserImageNameByEmail(Request $request) {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // If user not found in the 'users' table, check in 'users_google' table
            $googleUser = GoogleUser::where('email', $request->email)->first();

            if (!$googleUser) {
                return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['image_name' => $googleUser->image], Response::HTTP_OK);
        }

        return response()->json(['image_name' => $user->image], Response::HTTP_OK);
    }



    /**
     * @OA\Post(
     *     path="/api/registerGoogle",
     *     summary="Register a new google user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "lastName", "image", "email", "role", "googleId"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="lastName", type="string"),
     *             @OA\Property(property="image", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="role", type="string"),
     *             @OA\Property(property="googleId", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", description="Authentication token"),
     *         )
     *     ),
     *     @OA\Response(response="400", description="Bad request, validation error"),
     * )
     */
    public function registerGoogle(Request $request) {

        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'lastName' => 'required|string',
            'googleId' => 'required|string',
            'image' => 'required|url', // Ensure that the image is a valid URL
            'email' => 'required|string|email', // Added email validation
            'role' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), Response::HTTP_BAD_REQUEST);
        }

        // Check if the email already exists in either 'users' or 'users_google' table
        if (User::where('email', $request->email)->exists() || GoogleUser::where('email', $request->email)->exists()) {
            return response()->json(['error' => 'Email already exists'], Response::HTTP_BAD_REQUEST);
        }

        $input = $validation->validated();
        $imageName = uniqid() . ".webp";

        // Download the image from the URL
        $imageResponse = Http::get($input['image']);

        if ($imageResponse->failed()) {
            return response()->json(['error' => 'Failed to fetch image from URL'], Response::HTTP_BAD_REQUEST);
        }

        // Save the image using Intervention Image
        $manager = new ImageManager(new Driver());
        $imageRead = $manager->read($imageResponse->body());
        $path = public_path('upload/' . $imageName);
        $imageRead->save($path);

        // Create a new GoogleUser
        $user = GoogleUser::create(array_merge(
            $input,
            ['image' => $imageName]
        ));

        return response()->json(['token' => $user], Response::HTTP_OK);
    }




}
