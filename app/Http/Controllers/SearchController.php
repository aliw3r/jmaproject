<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SearchController extends Controller
{
   public function search(Request $request)
{
    $query = $request->input('q');
    
    $songs = Song::query()
        ->where('name', 'LIKE', "%{\$query}%")
        ->orWhere('artist', 'LIKE', "%{\$query}%")
        ->paginate(12);

    return view('search', compact('songs', 'query'));
}
}
