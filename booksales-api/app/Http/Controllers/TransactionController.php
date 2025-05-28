<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user', 'book')->get();

        // return view('genres', ['genres'=> $genres]);

        if ($transactions->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resouces data not found!"
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get all resources",
            "data" => $transactions
        ], 200);
    }

    public function store(Request $request)
    {
        // 1. validator 
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // 2. check validator error 
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $uniqcode = "ORD-" . strtoupper(uniqid());

        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'unautorized!'
            ], 401);
        }

        $book = Book::find($request->book_id);

        if ($book->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'stok tidak cukup!'
            ], 400);
        }

        $totalAmount = $book->price * $request->quantity;

        $book->stock -= $request->quantity;
        $book->save();

        // 3. insert data 
        $transactions = Transaction::create([
            'order_number' => $uniqcode,
            'customer_id' => $user->id,
            'book_id' => $request->book_id,
            'total_amount' => $totalAmount,
        ]);

        // 4. response 
        return response()->json([
            'success' => true,
            'message' => 'transactions added successfully!',
            'data' => $transactions
        ], 201);
    }

    public function show(string $id)
    {
        $transactions = Transaction::find($id);

        if (!$transactions) {
            return response()->json([
                "success" => false,
                "message" => "resources not found"
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Get resources detail",
            "data" => $transactions
        ], 200);
    }

    public function update(string $id, Request $request)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                "success" => false,
                "message" => "resources not found"
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // Ambil data buku lama dan baru
        $oldBook = Book::find($transaction->book_id);
        $newBook = Book::find($request->book_id);

        // Kembalikan stok dari transaksi sebelumnya
        $oldBook->stock += $transaction->quantity;
        $oldBook->save();

        // Cek apakah stok cukup untuk transaksi baru
        if ($newBook->stock < $request->quantity) {
            // Balikkan pengurangan jika tidak cukup
            $oldBook->stock -= $transaction->quantity;
            $oldBook->save();

            return response()->json([
                'success' => false,
                'message' => 'stok tidak cukup untuk update!'
            ], 400);
        }

        // Kurangi stok buku baru
        $newBook->stock -= $request->quantity;
        $newBook->save();

        // Hitung total baru
        $totalAmount = $newBook->price * $request->quantity;

        // Update transaksi
        $transaction->update([
            'book_id' => $request->book_id,
            'total_amount' => $totalAmount,
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            "success" => true,
            "message" => "resources updated",
            "data" => $transaction
        ], 200);
    }

    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                "success" => false,
                "message" => "resources not found"
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            "success" => true,
            "message" => "resources deleted",
        ], 204);
    }
}
