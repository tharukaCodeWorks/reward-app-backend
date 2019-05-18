@component('mail::message')

You have successfully registered with SriRewards. Please verify your email address. <br>
Copy and paste following code on SriReward app email confirmation screen.

@component('mail::button', ['url' => "#")])
{{ $user->verification_token }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
