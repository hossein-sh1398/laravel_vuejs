<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function store(Request $request)
    {
    	$data = $request->validate([
    		'title' => 'required',
    		'author' => 'required'
    	]);

    	Book::create($data);

    	return back();
    }

    public function update(Request $request, Book $book)
    {
    	$data = $request->validate([
    		'title' => 'required',
    		'author' => 'required'
    	]);

    	$book->update($data);  	

    	return back();
    }

    public function destroy(Book $book)
    {
    	$book->delete();

    	return redirect('books');
    }

    public function index()
    {
        $books = Book::get();

        return [ 'books' => $books ];
    }
}
