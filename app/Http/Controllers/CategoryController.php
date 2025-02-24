<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function foodBeverage(){
        return "1. Nasi goreng <br> 2. Ultra milk";
    }
    public function beautyHealth(){
        return "1. Life buoy <br> 2. Detol ";
    }
    public function homeCare(){
        return "1. Wipol <br> 2. Pembersih porselen";
    }
    public function babyKid(){
        return "1. Pampers <br> 2. Mami poko";
    }
}
