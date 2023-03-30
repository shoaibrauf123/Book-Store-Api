<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;

class AuthController extends Controller
{
    public function register(Request $request){
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => \Hash::make($request->password),
            
        ]);

        $token = $user->createToken('Token')->accessToken;
        return response()->json(["status"=>TRUE,"message"=>"Success","token"=>$token]);
    }
    public function login(Request $request){

        $data = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        if(auth()->attempt($data)){
            $token = auth()->user()->createToken('Token')->accessToken;
             return response()->json(["status"=>TRUE,"message"=>"Success","token"=>$token]);
        }else{
            return response()->json(["status"=>FALSE,"message"=>"NOT Success"]);
        }
    }
    public function get_all_books(){
        $user = auth()->user();
        if($user){
            $getAllBooks = Book::all();
            return response()->json(["data"=>$getAllBooks,"message"=>"success"]); 
        }else{
            return response()->json(["message"=>"Anauthrizod"]);
        }
    }
    public function get_spacific_book($id){
        $user = auth()->user();
        if($user){
            $getSpacificBook = Book::where("id",$id)->first();
            return response()->json(["data"=>$getSpacificBook,"message"=>"success"]); 
        }else{
            return response()->json(["message"=>"Anauthrizod"]);
        }
    }
    public function book_search(Request $request){
        $user = auth()->user();
        if($user){
            $search = $request->search;
            $search_book = Book::where('book_title','LIKE',"%$search%")
            ->orWhere('book_author','LIKE',"%$search%")
            ->orWhere("book_isbn",'LIKE',"%$search%")->get();
                
            return response()->json(["data"=>$search_book,"message"=>"success"]); 
        }else{
            return response()->json(["message"=>"Anauthrizod"]);
        }
    }
    public function loggout(Request $request){
        
        $user = auth()->user()->token();
        $user->revoke();
        return response()->json(["message"=>"successfully Loggout"]);      
    }
}
        