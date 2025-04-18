<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class CategoryController extends Controller
{
    public function category(){
        return view('category.category');
    }
    public function foodBaverage(){
        return view('category.food-baverage');
    }
    public function beautyHealth(){
        return view('category.beauty-health');
    }
    public function homeCare(){
        return view('category.home-care');
    }
    public function babyCare(){
        return view('category.baby-care');
    }
}
