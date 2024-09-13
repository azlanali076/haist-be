<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiseaseTest;
use Illuminate\Http\Request;

class DiseaseTestController extends Controller
{
    public function index(){
        $data['tests'] = DiseaseTest::get();
        return view('admin.tests.index',$data);
    }

    public function create(){
        return view('admin.tests.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);
        DiseaseTest::create($validated);
        session()->flash('success',__('Disease Test Added!'));
        return redirect(route('tests.index'));
    }

    public function edit($id){
        $data['test'] = DiseaseTest::findOrFail($id);
        return view('admin.tests.edit',$data);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);
        DiseaseTest::findOrFail($id)->update($validated);
        session()->flash('success',__('Disease Test Updated!'));
        return redirect(route('tests.index'));
    }

    public function destroy($id){
        DiseaseTest::findOrFail($id)->delete();
        session()->flash('success',__('Disease Test Deleted!'));
        return redirect(route('tests.index'));
    }
}
