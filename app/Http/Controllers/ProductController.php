<?php

namespace App\Http\Controllers;

use App\Jobs\ExportProducts;
use App\Jobs\ImportProducts;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function products ()
    {
        $products = Product::orderby('created_at', 'desc' )->paginate(9);
        $user = Auth::user();
        $categories = Category::get();
        $data = [
            'products' => $products,
            'user'=>$user,
            'categories'=>$categories
            
        ];
        return view('admin.products', $data);
    }
 
    public function index ()
    {   
        $products = Product::orderby('created_at', 'desc')->paginate(9);
        $user = Auth::user();
        $data = [
            'products' => $products,
            'user'=>$user,
            
        ];
        
        return view('category', $data);
    }
    public function newProduct (Request $request)
    {   
        $request->validate([
            'picture' => 'mimes:jpg,bmp,png',
            'name' => 'required|max:255',
            'description' => 'required',
            'price'=>'required|numeric',
            'category_id'=>'required'
        
        ]);
        $input = $request->all();
        
        $product = new Product();

        $file = $request->file('picture');
        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $fileName = time() . rand(1000, 9999) . '.' . $ext;
            $file->storeAs('public/image/products', $fileName);
            $product->picture = $fileName;
        }

        $product->name = $input['name'];
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product->category_id= $input['category_id'];
        
        
        $product->save();
        session()->flash('newProduct');
        return back();
    }
    public function exportProducts()
    {
        ExportProducts::dispatch();
        session()->flash('exportQueued');
        return back();
    }
    public function importProducts(Request $request)
    {
        $request->validate(['uploadProducts' => 'required|mimes:csv,txt']);
        $file = $request->file('uploadProducts');
        
        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $fileName = time() . rand(1000, 9999) . '.' . $ext;
            $file->storeAs('public/temp', $fileName);
        }
        
            ImportProducts::dispatch($fileName);
            session()->flash('importQueued');
            return back();
    }

}    
