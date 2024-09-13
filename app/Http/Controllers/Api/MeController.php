<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HandWash;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function update(Request $request){
        $validated = $request->validate([
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'gender' => 'nullable',
            'dob' => 'nullable|date',
            'avatar' => 'nullable|file|image',
            'phone' => 'nullable',
        ]);
        unset($validated['avatar']);
        if($request->avatar and $request->hasFile('avatar')) {
            $fileName = time().'_'.$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('uploaded_data'),$fileName);
            $validated['avatar'] = $fileName;
        }
        $request->user()->update($validated);
        return $this->success('Profile Updated!',$request->user());
    }

    public function stats(){
        $data['counter'] = HandWash::firstOrCreate(['user_id' => request()->user()->id,'date_at' => now()->format('Y-m-d')]);
        $data['unread_notification'] = request()->user()->unreadNotifications()->count();
        return $this->success('Stats',$data);
    }

    public function counter(){
        $counter = HandWash::firstOrCreate(['user_id' => request()->user()->id,'date_at' => now()->format('Y-m-d')]);
        return $this->success('Hand Wash Counter',$counter);
    }

    public function updateCounter(Request $request){
        $validated = $request->validate([
            'hand_wash_counter' => 'nullable',
            'screen_wash_counter' => 'nullable',
        ]);
        $counter = HandWash::firstOrCreate(['user_id' => request()->user()->id,'date_at' => now()->format('Y-m-d')]);
        $counter->update($validated);
        return $this->success('Counter Updated!',$counter);
    }

    public function updateMobileToken(Request $request) {
        $validated = $request->validate([
            'mobile_device_id' => 'required'
        ]);
        $request->user()->update($validated);
        return $this->success('Device Id Updated!');
    }
}
