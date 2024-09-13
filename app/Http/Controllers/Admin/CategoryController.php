<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $data['categories'] = Category::get();
        return view('admin.categories.index',$data);
    }

    public function create(){
        return view('admin.categories.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'category_type' => 'required',
            'name' => 'required'
        ]);
        Category::create($validated);
        session()->flash('success','Category Added!');
        return redirect(route('categories.index'));
    }

    public function edit($id){
        $data['category'] = Category::findOrFail($id);
        return view('admin.categories.edit',$data);
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'category_type' => 'required',
            'name' => 'required'
        ]);
        Category::findOrFail($id)->update($validated);
        session()->flash('success','Category Updated!');
        return redirect(route('categories.index'));
    }

    public function destroy($id){
        Category::findOrFail($id)->delete();
        session()->flash('success','Category Deleted!');
        return redirect(route('categories.index'));
    }
}
