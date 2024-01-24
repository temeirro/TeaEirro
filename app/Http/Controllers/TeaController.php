<?php

namespace App\Http\Controllers;

use App\Models\Tea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $tea = Tea::with('tea_type', 'tea_origin', 'tea_images')->find($id);

        if (!$tea) {
            // Return a 404 response if the tea is not found
            return response()->json(['error' => 'Tea not found'], 404);
        }

        // Return the tea as JSON response
        return response()->json($tea)
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
}
