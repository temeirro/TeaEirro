<?php

namespace App\Http\Controllers;

use App\Models\Tea;
use App\Models\TeaImage;
use App\Models\TeaOrigin;
use App\Models\TeaType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
class TeaController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Tea"},
     *     path="/api/getAllTea",
     *     @OA\Response(response="200", description="Tea List.")
     * )
     */
    public function getAll()
    {
        $data = Tea::with('tea_type','tea_origin','tea_images')->get();
        return response()->json($data)
            ->header('Content-Type', 'application/json; charset=utf-8');

    }

    /**
     * @OA\Get(
     *     tags={"Tea"},
     *     path="/api/getBlackTea",
     *     @OA\Response(response="200", description="Black Tea List.")
     * )
     */
    public function getBlackTea()
    {
        // Get only black teas (Tea Type ID = 1)
        $data = Tea::with('tea_type','tea_origin','tea_images')->where('type_id', 1)->get();

        // Return the black teas as JSON response
        return response()->json($data)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * @OA\Get(
     *     tags={"Tea"},
     *     path="/api/getTea/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the tea",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Tea by ID."),
     *     @OA\Response(response="404", description="Tea not found.")
     * )
     */
    public function getTeaById($id)
    {
        // Validate that the ID is a positive integer
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }

        // Find the tea by ID with relationships
        $data = Tea::with('tea_type', 'tea_origin', 'tea_images')->find($id);

        if (!$data) {
            // Return a 404 response if the tea is not found
            return response()->json(['error' => 'Tea not found'], 404);
        }

        // Return the tea as JSON response
        return response()->json($data)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * @OA\Get(
     *     tags={"Tea"},
     *     path="/api/getGreenTea",
     *     @OA\Response(response="200", description="Green Tea List.")
     * )
     */
    public function getGreenTea()
    {
        // Get only green teas (Tea Type ID = 2)
        $data = Tea::with('tea_type','tea_origin','tea_images')->where('type_id', 2)->get();

        // Return the green teas as JSON response
        return response()->json($data)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * @OA\Get(
     *     tags={"Tea"},
     *     path="/api/getYellowTea",
     *     @OA\Response(response="200", description="Yellow Tea List.")
     * )
     */
    public function getYellowTea()
    {
        // Get only yellow teas (Tea Type ID = 3)
        $data = Tea::with('tea_type','tea_origin','tea_images')->where('type_id', 3)->get();

        // Return the yellow teas as JSON response
        return response()->json($data)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * @OA\Get(
     *     tags={"Tea"},
     *     path="/api/getOolongTea",
     *     @OA\Response(response="200", description="Oolong Tea List.")
     * )
     */
    public function getOolongTea()
    {
        // Get only yellow teas (Tea Type ID = 3)
        $data = Tea::with('tea_type','tea_origin','tea_images')->where('type_id', 4)->get();

        // Return the yellow teas as JSON response
        return response()->json($data)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * @OA\Get(
     *     tags={"Tea"},
     *     path="/api/getWhiteTea",
     *     @OA\Response(response="200", description="White Tea List.")
     * )
     */
    public function getWhiteTea()
    {
        // Get only yellow teas (Tea Type ID = 3)
        $data = Tea::with('tea_type','tea_origin','tea_images')->where('type_id', 5)->get();

        // Return the yellow teas as JSON response
        return response()->json($data)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * @OA\Get(
     *     tags={"Tea"},
     *     path="/api/getPuerhTea",
     *     @OA\Response(response="200", description="Puerh Tea List.")
     * )
     */
    public function getPuerhTea()
    {
        // Get only yellow teas (Tea Type ID = 3)
        $data = Tea::with('tea_type','tea_origin','tea_images')->where('type_id', 6)->get();

        // Return the yellow teas as JSON response
        return response()->json($data)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * @OA\Get(
     *     tags={"Tea"},
     *     path="/api/getMatchaTea",
     *     @OA\Response(response="200", description="Matcha Tea List.")
     * )
     */
    public function getMatchaTea()
    {
        // Get only matcha teas (Tea Type ID = 8)
        $data = Tea::with('tea_type','tea_origin','tea_images')->where('type_id', 7)->get();

        // Return the matcha teas as JSON response
        return response()->json($data)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * @OA\Get(
     *     tags={"Tea"},
     *     path="/api/getAllTeaTypes",
     *     @OA\Response(response="200", description="All Tea Types List.")
     * )
     */
    public function getAllTeaTypes()
    {
        // Retrieve all tea types
        $data = TeaType::all(); // Assuming you have a model for TeaType

        // Return the tea types as JSON response
        return response()->json($data)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * @OA\Get(
     *     tags={"Tea"},
     *     path="/api/getAllTeaOrigins",
     *     @OA\Response(response="200", description="All Tea Origins List.")
     * )
     */
    public function getAllTeaOrigins()
    {
        // Retrieve all tea types
        $data = TeaOrigin::all(); // Assuming you have a model for TeaType

        // Return the tea types as JSON response
        return response()->json($data)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * @OA\Post(
     *     tags={"Tea"},
     *     path="/api/addTea",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name","price","description","type_id","origin_id","ingredients","images[]"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="type_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="origin_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="ingredients",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="images[]",
     *                     type="array",
     *                     @OA\Items(type="string", format="binary")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Add Tea.")
     * )
     */
    public function addTea(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'type_id' => 'required|exists:tea_types,id',
            'origin_id' => 'required|exists:tea_origins,id',
            'ingredients' => 'required|string',
            'images' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $images = $request->file('images');
        $tea = Tea::create($input);

        // Create image manager with desired driver
        $manager = new ImageManager(new Driver());

        if ($request->hasFile('images')) {
            foreach ($images as $image) {
                $imageName = uniqid() . '.webp';
                $imageRead = $manager->read($image);
                $path = public_path('upload/' . $imageName);
                $imageRead->toWebp()->save($path);

                TeaImage::create([
                    'tea_id' => $tea->id,
                    'name' => $imageName,
                ]);
            }
        }

        $tea->load('tea_images');

        return response()->json($tea, 200, [
            'Content-Type' => 'application/json;charset=UTF-8',
            'Charset' => 'utf-8'
        ], JSON_UNESCAPED_UNICODE);
    }


    /**
     * @OA\Delete(
     *     tags={"Tea"},
     *     path="/api/deleteTea/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the tea to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(response="204", description="Tea and images deleted successfully."),
     *     @OA\Response(response="404", description="Tea not found."),
     *     @OA\Response(response="500", description="Error deleting tea.")
     * )
     */

    public function deleteTea($id)
    {
        $tea = Tea::find($id);

        if (!$tea) {
            return response()->json(['error' => 'Tea not found.'], 404);
        }

        try {
            // Delete associated images from the upload folder
            foreach ($tea->tea_images as $image) {
                $imagePath = public_path('upload/' . $image->name);
                if (!empty($imagePath) && file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete associated images from the database
            TeaImage::where('tea_id', $tea->id)->delete();

            // Delete tea
            $tea->delete();

            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting tea.'], 500);
        }
    }

    /**
     * @OA\Post(
     *     tags={"Tea"},
     *     path="/api/editTea/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the tea to edit",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name","price","description","type_id","origin_id","ingredients","images[]"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="type_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="origin_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="ingredients",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="images[]",
     *                     type="array",
     *                     @OA\Items(type="string", format="binary")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Tea edited successfully."),
     *     @OA\Response(response="404", description="Tea not found."),
     *     @OA\Response(response="400", description="Validation error."),
     *     @OA\Response(response="500", description="Error editing tea.")
     * )
     */
    public function editTea(Request $request, $id)
    {
        $input = $request->all();

        // Validate the input
        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'type_id' => 'required|exists:tea_types,id',
            'origin_id' => 'required|exists:tea_origins,id',
            'ingredients' => 'required|string',
            'images' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Find the tea by ID
        $tea = Tea::find($id);

        if (!$tea) {
            return response()->json(['error' => 'Tea not found.'], 404);
        }

        try {
            // Update tea details
            $tea->update($input);

            // Delete existing images
            foreach ($tea->tea_images as $image) {
                $imagePath = public_path('upload/' . $image->name);
                if (!empty($imagePath) && file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete associated images from the database
            TeaImage::where('tea_id', $tea->id)->delete();

            // Upload new images
            $images = $request->file('images');
            $manager = new ImageManager(new Driver());

            foreach ($images as $image) {
                $imageName = uniqid() . '.webp';
                $imageRead = $manager->read($image);
                $path = public_path('upload/' . $imageName);
                $imageRead->toWebp()->save($path);

                TeaImage::create([
                    'tea_id' => $tea->id,
                    'name' => $imageName,
                ]);
            }

            // Load tea images
            $tea->load('tea_images');

            return response()->json($tea, 200, [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Charset' => 'utf-8'
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error editing tea.'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     tags={"Tea"},
     *     path="/api/deleteTeaImage/{teaId}/{imageName}",
     *     @OA\Parameter(
     *         name="teaId",
     *         in="path",
     *         description="ID of the tea",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="imageName",
     *         in="path",
     *         description="Name of the image to delete",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="204", description="Tea image deleted successfully."),
     *     @OA\Response(response="404", description="Tea or image not found."),
     *     @OA\Response(response="500", description="Error deleting tea image.")
     * )
     */
    public function deleteTeaImage($teaId, $imageName)
    {
        // Find the tea by ID
        $tea = Tea::find($teaId);

        if (!$tea) {
            return response()->json(['error' => 'Tea not found.'], 404);
        }

        // Find the tea image by name
        $image = TeaImage::where('tea_id', $teaId)->where('name', $imageName)->first();

        if (!$image) {
            return response()->json(['error' => 'Tea image not found.'], 404);
        }

        try {
            // Delete the image from the upload folder
            $imagePath = public_path('upload/' . $image->name);
            if (!empty($imagePath) && file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete the image from the database
            $image->delete();

            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting tea image.'], 500);
        }
    }


    /**
     * @OA\Post(
     *     tags={"Tea"},
     *     path="/api/addTeaImage/{teaId}",
     *     @OA\Parameter(
     *         name="teaId",
     *         in="path",
     *         description="ID of the tea to add an image to",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"image"},
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="201", description="Tea image added successfully."),
     *     @OA\Response(response="404", description="Tea not found."),
     *     @OA\Response(response="400", description="Validation error."),
     *     @OA\Response(response="500", description="Error adding tea image.")
     * )
     */
    public function addTeaImage(Request $request, $teaId)
    {
        // Find the tea by ID
        $tea = Tea::find($teaId);

        if (!$tea) {
            return response()->json(['error' => 'Tea not found.'], 404);
        }

        // Validate the input
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // Adjust the validation rules as needed
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            // Upload and save the new image
            $image = $request->file('image');
            $imageName = uniqid() . '.webp'; // Adjust the image name generation as needed
            $manager = new ImageManager(new Driver());
            $imageRead = $manager->read($image);
            $path = public_path('upload/' . $imageName);
            $imageRead->toWebp()->save($path);

            TeaImage::create([
                'tea_id' => $tea->id,
                'name' => $imageName,
            ]);

            return response()->json(['message' => 'Tea image added successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error adding tea image.'], 500);
        }
    }

    /**
     * @OA\Post(
     *     tags={"Tea"},
     *     path="/api/editTeaWithoutImages/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the tea to edit",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name","price","description","type_id","origin_id","ingredients"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="type_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="origin_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="ingredients",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Tea edited successfully."),
     *     @OA\Response(response="404", description="Tea not found."),
     *     @OA\Response(response="400", description="Validation error."),
     *     @OA\Response(response="500", description="Error editing tea.")
     * )
     */
    public function editTeaWithoutImages(Request $request, $id)
    {
        $input = $request->all();

        // Validate the input
        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'type_id' => 'required|exists:tea_types,id',
            'origin_id' => 'required|exists:tea_origins,id',
            'ingredients' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Find the tea by ID
        $tea = Tea::find($id);

        if (!$tea) {
            return response()->json(['error' => 'Tea not found.'], 404);
        }

        try {
            // Update tea details
            $tea->update($input);

            // Load tea images
            $tea->load('tea_images');

            return response()->json($tea, 200, [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Charset' => 'utf-8'
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error editing tea.'], 500);
        }
    }
}
