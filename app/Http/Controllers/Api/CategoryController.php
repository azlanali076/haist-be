<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        request()->validate([
            'category_type' => 'nullable|in:Symptom,Diagnosis'
        ]);
        $categories = [];
        if(request()->category_type) {
            $categories = Category::where(['category_type' => request()->category_type])->get();
        }
        else{
            $categories = Category::get();
        }
        return $this->success('Got Categories',$categories);
    }

    public function show($id){
        $category = Category::with(['symptoms'])->findOrFail($id);
        return $this->success('Category Found',$category);
    }
}
