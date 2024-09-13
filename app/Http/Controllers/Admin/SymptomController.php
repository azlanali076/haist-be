<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Symptom;
use Illuminate\Http\Request;

class SymptomController extends Controller
{
    public function index(){
        $data['symptoms'] = Symptom::get();
        return view('admin.symptoms.index',$data);
    }

    public function create(){
        $data['categories'] = Category::where(['category_type' => Category::SYMPTOM_TYPE])->get();
        return view('admin.symptoms.create',$data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required'
        ]);
        Symptom::create($validated);
        session()->flash('success','Symptom Added!');
        return redirect(route('symptoms.index'));
    }

    public function edit($id){
        $data['categories'] = Category::where(['category_type' => Category::SYMPTOM_TYPE])->get();
        $data['symptom'] = Symptom::findOrFail($id);
        return view('admin.symptoms.edit',$data);
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required'
        ]);
        Symptom::findOrFail($id)->update($validated);
        session()->flash('success','Symptom Updated!');
        return redirect(route('symptoms.index'));
    }

    public function destroy($id){
        Symptom::findOrFail($id)->delete();
        session()->flash('success','Symptom Deleted!');
        return redirect(route('symptoms.index'));
    }
}
