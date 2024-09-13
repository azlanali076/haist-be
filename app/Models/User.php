<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = ['password', 'remember_token','otp','mobile_device_id'];

    protected $casts = ['email_verified_at' => 'datetime'];
    protected $appends = ['full_name','full_name_with_verification'];
    protected $dates = ['dob'];

    public function routeNotificationForFcm()
    {
        return $this->mobile_device_id;
    }

    public function role(): HasOne
    {
        return $this->hasOne(Role::class,'id','role_id');
    }

    public function getFullNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }

    public function getFullNameWithVerificationAttribute(){
        return $this->first_name.' '.$this->last_name.' ('.($this->hasVerifiedEmail() ? 'Verified' : 'Unverified').')';
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class,'facility_id','id');
    }

    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id','id');
    }

    public function getAssociatedFacilityIdsAttribute(){
        if($this->role->name === config('constants.roles.admin')) {
            return FacilityAdmin::where(['admin_id' => $this->id])->get()->pluck('facility_id')->toArray();
        }
        return [];
    }

    public function scopeByFacilityId($query){
        return $query->where('facility_id',request()->user()->facility_id);
    }

    public function scopeIsDoctor($query){
        $role = Role::where(['name' => config('constants.roles.doctor')])->firstOrFail();
        return $query->where(['role_id' => $role->id]);
    }

    public function scopeIsPatient($query){
        $role = Role::where(['name' => config('constants.roles.patient')])->firstOrFail();
        return $query->where(['role_id' => $role->id]);
    }

    /**
     * @return array|Collection
     */
    public function facilitiesIfAdmin(): array|Collection
    {
        if($this->role->name === config('constants.roles.admin')){
            return FacilityAdmin::where(['admin_id' => $this->id])->with(['facility'])->get()->pluck('facility')->values();
        }
        else{
            return [];
        }
    }
}
