<?php

namespace Modules\Book\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Book\Database\Factories\BookFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'description'];


    // protected static function newFactory(): BookFactory
    // {
    //     // return BookFactory::new();
    // }
}
