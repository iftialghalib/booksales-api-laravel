<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();

        // return view('genres', ['genres'=> $genres]);

        if ($genres->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resouces data not found!"
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get all resources",
            "data" => $genres
        ], 200);
    }

    public function store(Request $request)
    {
        // 1. validator 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
        ]);

        // 2. check validator error 
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. insert data 
        $genre = Genre::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // 4. response 
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully!',
            'data' => $genre
        ], 201);
    }

    public function show(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                "success" => false,
                "message" => "resources not found"
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Get resources detail",
            "data" => $genre
        ], 200);
    }

    public function update(string $id, Request $request)
    {

        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                "success" => false,
                "message" => "resources not found"
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        $genre->update($data);

        return response()->json([
            "success" => true,
            "message" => "resources updated",
            "data" => $genre
        ], 200);
    }

    public function destroy(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                "success" => false,
                "message" => "resources not found"
            ], 404);
        }

        $genre->delete();

        return response()->json([
            "success" => true,
            "message" => "resources deleted",
        ], 204);
    }
}
