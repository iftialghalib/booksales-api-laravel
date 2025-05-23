<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        // return view('books', ['books'=> $books]);

        if ($books->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resouces data not found!"
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get all resources",
            "data" => $books
        ], 200);
    }

    public function store(Request $request)
    {
        // 1. validator 
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'cover' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id'
        ]);

        // 2. check validator error 
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. upload image 
        $image = $request->file('cover');
        $image->store('books', 'public');

        // 4. insert data 
        $book = Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'cover' => $image->hashName(),
            'genre_id' => $request->genre_id,
            'author_id' => $request->author_id,
        ]);

        // 5. response 
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully!',
            'data' => $book
        ], 201);
    }

    public function show(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                "success" => false,
                "message" => "resources not found"
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Get resources detail",
            "data" => $book
        ], 200);
    }

    public function update(string $id, Request $request){

        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                "success" => false,
                "message" => "resources not found"
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'genre_id' => $request->genre_id,
            'author_id' => $request->author_id,
        ];

        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $image->store('books', 'public');

            if ($book->cover) {
                Storage::disk('public')->delete('books/' . $book->cover);
            }

            $data['cover'] = $image->hashName();
        }

        $book->update($data);

        return response()->json([
            "success" => true,
            "message" => "resources updated",
            "data" => $book
        ], 200);
    }

    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                "success" => false,
                "message" => "resources not found"
            ], 404);
        }

        if ($book->cover) {
            Storage::disk('public')->delete('books/' . $book->cover);
        }

        $book->delete();

        return response()->json([
            "success" => true,
            "message" => "resources deleted",
        ], 204);
    }
}
