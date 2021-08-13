<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\User;

class UserController extends Controller
{
    public function index_view ()
    {
        return view('pages.user.user-data', [
            'user' => User::class
        ]);
    }

    public function dashboard_view (){

        // return view('dashboard', [
        //     'user' => User::class
        // ]);

        $posts = Http::get('https://jsonplaceholder.typicode.com/posts')->object();

        return view('dashboard', compact('posts'));
    }

    public function test_api(){
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        return $response->json();
    }
}
