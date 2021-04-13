<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
   
    private $rules = [
      'name'=>'required',
      'is_active'=>'required|boolean'
    ];

    public function index()
    {
      return Gender::all();
    }


   
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules);
        $model = Gender::create($validated);


        
        return $model;
    }

 
    public function show(Gender $genre)
    {
        return $genre;
    }

   

    public function update(Request $request, Gender $genre)
    {
        $validated = $request->validate($this->rules);
        $genre->update($validated);
        $genre->refresh();
        return $genre;
    }

    public function destroy(Gender $genre)
    {
      $genre->delete();
      return response()->noContent();   
    }
}
