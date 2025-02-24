<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
   public function user($id, $name){
    return 'Hallo user ke '.$id. 'dengan username '.$name;
   }
}
