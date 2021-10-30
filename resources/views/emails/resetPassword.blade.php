@component('mail::message')
# chenge your password


<p>geexar team</p>


@component('mail::button', ['url' => 'http://localhost:3000/resetPassword/'.$email.'/'.$token.'/'.$guard])
reset password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
