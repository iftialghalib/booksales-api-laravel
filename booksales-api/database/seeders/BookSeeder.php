<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Harry Potter and the Sorcerers Stone',
            'description' => 'The first book in the Harry Potter series.',
            'price' => 50000.00,
            'stock' => 50,
            'cover' => 'harry_potter.jpg',
            'genre_id' => 1,
            'author_id' => 1
        ]);

        Book::create([
            'title' => 'The Lord of the Rings',
            'description' => 'A classic fantasy novel by J.R.R. Tolkien.',
            'price' => 60000.00,
            'stock' => 30,
            'cover' => 'the_lord_of_the_rings.jpg',
            'genre_id' => 1,
            'author_id' => 2
        ]);

        Book::create([
            'title' => '1984',
            'description' => 'A dystopian novel by George Orwell.',
            'price' => 40000.00,
            'stock' => 40,
            'cover' => '1984.jpg',
            'genre_id' => 2,
            'author_id' => 3
        ]);

        Book::create([
            'title' => 'Murder on the Orient Express',
            'description' => 'Detective Hercule Poirot solves a murder on a train.',
            'price' => 48000.00,
            'stock' => 35,
            'cover' => 'orient_express.jpg',
            'genre_id' => 3,
            'author_id' => 4
        ]);

        Book::create([
            'title' => 'The Da Vinci Code',
            'description' => 'A symbologist uncovers a conspiracy in a religious mystery.',
            'price' => 58000.00,
            'stock' => 40,
            'cover' => 'da_vinci_code.jpg',
            'genre_id' => 2,
            'author_id' => 5  
        ]);

    }
}
