<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $date = date('d.m.Y H:i:s');
            Storage::append('ownLog.log', "[HomePageEnter] $date {$user->name} зашел на страницу home");
        }
        
        $categories = Category::paginate(9);

        $data = [
            'categories' => $categories,
            'title' => 'Список категорий',
            'showTitle' => true,
            'user'=>$user
        ];
        
        return view('home', $data);
    }

  

    public function profile (Request $request)
    {
        $user = Auth::user();
        $addresses = Address::where('user_id', $user->id)->get();
        return view('profile', compact('user', 'addresses'));
    }

    public function profileUpdate (Request $request)
    {
        $request->validate([
            'picture' => 'mimes:jpg,bmp,png',
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password'=>'nullable|confirmed|min:8'
        ]);

        

        $user = Auth::user();

        $file = $request->file('picture');
        $input = $request->all();

        if ($input['password']){
            $current_password = $input['current_password'];
            if(!Hash::check($current_password, request()->user()->password)){
                session()->flash('currentPasswordError');
                return back();
            }
            else {
                $user->password = Hash::make($input['password']);
            }   
        }
        
        
        
        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $fileName = time() . rand(1000, 9999) . '.' . $ext;
            $file->storeAs('public/image/users', $fileName);
            $user->picture = $fileName;
        }
        
        if (isset($input['main_address'])){
            $address = Address::find($input['main_address']);
            $address->main = 1;
            $address->save();
            Address::where('user_id', $user->id)->where('id', '!=', $input['main_address'])->update(['main'=> 0]);
        }

        if ($input['new_address']) {
            
            if (isset($input['isMain'])){
                Address::where('user_id', $user->id)->update(['main'=> 0]);
                $mainAddress = true; 
            }
            else {
                $mainAddress = !$user->addresses->contains(function($address){
                    return $address->main == true;
                });
            }
           
                               
            $address = new Address();
            $address->user_id = $user->id;
            $address->address = $input['new_address'];
            $address->main = $mainAddress;         
            $address->save();
        

        }

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->save();
        session()->flash('profileUpdated');
        return back();
    }
}