<x-mail::message>
# Forgot Password

Hello {{$user->full_name}},
We have received request to Reset password on your account. The OTP to reset password is.
    <x-mail::panel>{{$otp}}</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
