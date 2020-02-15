<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;

class CategoriesController extends Controller
{
    public function get()
    {
        return Category::get();
    }

    public function getSingle($id)
    {
        return Category::where('id', $id)->first();
    }

    public function create(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|max:255'
        ]);

        $category = \DB::transaction(function () use ($input){
            $category = (new Category)->fill($input);

            $category->save();

            return $category;
        });

        return response()->json(['success' => true, 'category' => $category], 200);
    }

    public function delete($id)
    {
        $category = Category::where('id', $id)->first();
        if (!$category) {
            return response()->json(['message' => 'Essa categoria não existe.'], 404);
        }
        $category->delete();

        return response()->json(['message' => 'Categoria excluída com sucesso'], 200);
    }
}
