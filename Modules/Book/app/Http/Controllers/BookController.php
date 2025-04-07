<?php

namespace Modules\Book\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Book\app\Http\Requests\PostBookRequest;
use Modules\Book\app\Http\Requests\UpdateBookRequest;
use Modules\Book\app\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(Book::all());
    }

    public function store(PostBookRequest $request)
    {
        $book = Book::create($request->validated());
        return response()->json($book, 201);
    }

    public function show(Book $book)
    {
        return response()->json($book);
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Book deleted']);
    }
}
