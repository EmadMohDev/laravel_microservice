<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function random()
    {
       $user =  User::inRandomOrder()->first();
       return response([ "id" => $user->id], Response::HTTP_OK) ;

     ;

    }
}
