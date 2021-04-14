<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
   
    private $rules = [
      'name'=>'required',
      'is_active'=>'required|boolean'
    ];

    public function index()
    {
      return Genre::all();
    }


   
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules);
        $model = Genre::create($validated);


        
        return $model;
    }

 
    public function show(Genre $genre)
    {
        return $genre;
    }

   

    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate($this->rules);
        $genre->update($validated);
        $genre->refresh();
        return $genre;
    }

    public function destroy(Genre $genre)
    {
      $genre->delete();
      return response()->noContent();   
    }
}
