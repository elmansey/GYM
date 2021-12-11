@component('mail::message')
# chenge your password


<p>geexar team</p>


@component('mail::button', ['url' =>  env('MIX_RUN_URL').'resetPassword/'.$email.'/'.$token])
reset password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
