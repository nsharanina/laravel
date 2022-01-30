<?php

namespace App\Http\Controllers;

use App\Jobs\ExportCategories;
use App\Jobs\ImportCategories;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index ()
    {
        $user = Auth::user();
        $categories = Category::get();

        $data = [
            'categories' => $categories,
            'title' => 'Список категорий',
            'showTitle' => true,
            'user'=>$user
        ];
        
        return view('home', $data);
    }

    public function category (Category $category)
    {
        $user = Auth::user();
        return view('category', compact('category', 'user'));
    }

    public function addCategory (Request $request)
    {

        $request->validate([
            'picture' => 'mimes:jpg,bmp,png',
            'name' => 'required|max:255',
            'description' => 'required'
        
        ]);
        $input = $request->all();
        

        $category = new Category();

        $file = $request->file('picture');
        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $fileName = time() . rand(1000, 9999) . '.' . $ext;
            $file->storeAs('public/image/categories', $fileName);
            $category->picture = $fileName;
        }

        $category->name = $input['name'];
        $category->description = $input['description'];
        $category->save();
        session()->flash('categoryAdded');
        return back();
    }

    public function exportCategories()
    {
        ExportCategories::dispatch();
        session()->flash('exportQueued');
        return back();
    }
    public function importCategories(Request $request)
    {
        $request->validate(['uploadCategories' => 'required|mimes:csv,txt']);
        $file = $request->file('uploadCategories');
        
        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $fileName = time() . rand(1000, 9999) . '.' . $ext;
            $file->storeAs('public/temp', $fileName);
        }
        
            ImportCategories::dispatch($fileName);
            session()->flash('importQueued');
            return back();
    }
    

}
