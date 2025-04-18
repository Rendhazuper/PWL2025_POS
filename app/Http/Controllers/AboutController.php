<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function nama($nama){
        return  ('helllo'. ' ' . $nama); 
    }
}
