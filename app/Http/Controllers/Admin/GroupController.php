<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'group_name' => 'required',
            'facility_ids' => 'required|array|min:1',
            'facility_ids.*' => 'exists:facilities,id'
        ]);
        Group::create([
            'name' => $request->group_name,
            'facility_ids' => $request->facility_ids,
            'admin_id' => $request->user()->id
        ]);
        session()->flash('success','Group Added!');
        return redirect(route('home.compare-facilities'));
    }
}
