<?php
if(!function_exists('returnAvatar')){
    function returnAvatar(\App\Models\User $user){
        if($user->avatar){
            if(str_contains($user->avatar,'http')){
                return $user->avatar;
            }
            else{
                return public_path('uploaded_data/'.$user->avatar);
            }
        }
        else{
            return 'https://ui-avatars.com/api?name='.$user->full_name.'&background=random&size=512&rounded=true';
        }
    }
}

if(!function_exists('returnAvatarFromArray')){
    function returnAvatarFromArray($user){
        if($user['avatar']){
            if(str_contains($user['avatar'],'http')){
                return $user['avatar'];
            }
            else{
                return public_path('uploaded_data/'.$user['avatar']);
            }
        }
        else{
            return 'https://ui-avatars.com/api?name='.$user['full_name'].'&background=random&size=512&rounded=true';
        }
    }
}

if(!function_exists('calculateHoursFromSeconds')){
    function calculateHoursFromSeconds($seconds): string
    {
        return number_format($seconds / 60 / 60);
    }
}

if(!function_exists('calculateMinutesFromSeconds')){
    function calculateMinutesFromSeconds($seconds): string
    {
        return number_format($seconds / 60 % 60);
    }
}

if(!function_exists('calculateSecondsFromSeconds')){
    function calculateSecondsFromSeconds($seconds): string
    {
        return number_format($seconds % 60);
    }
}

if(!function_exists('getSymptomName')){
    function getSymptomName($symptom_id): string
    {
        return \App\Models\Symptom::find($symptom_id)->name;
    }
}

if(!function_exists('getDiagnoseName')){
    function getDiagnoseName($diagnose_id): string
    {
        return \App\Models\Diagnose::find($diagnose_id)->name;
    }
}

if(!function_exists('getPatientName')){
    function getPatientName($assessmentId): string
    {
        $assessment = \App\Models\Assessment::find($assessmentId);
        if (!empty($assessment)){
            $user = \App\Models\User::find($assessment->patient_id);
            if (!empty($user)){
                return $user->first_name.' '.$user->last_name;
            }
        }
        return '-- --';
    }
}
