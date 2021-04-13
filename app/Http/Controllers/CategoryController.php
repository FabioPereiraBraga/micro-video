<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

   private $rules = [
    'name' => 'required',
    'description' => 'nullable',
    'is_active' => 'required|boolean',
   ];
  
    public function index()
    {
        return Category::all();
    }


    public function store(Request $request)
    {
       $validated = $request->validate($this->rules);

       $model = Category::create($validated);
       return $model;
    }

    public function show(Category $category)
    {
        return $category;
    }


    public function update(Request $request, Category $category)
    {
        $validated = $request->validate($this->rules);
        $category->update($validated);
        $category->refresh();
        return $category;
    }

    
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();  
    }
}
