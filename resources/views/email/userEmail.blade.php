@component('mail::message')
<h2>Hello ,{{$body['name']}}</h2>
<p>Your Email:<b> {{$body['email']}}</b>
<br>Code : <b> {{$body['code']}}</b>
<br>Your password: <b> {{$body['password']}}</b>
</p>
 
Thanks,<br>
{{ config('app.name') }}<br>
Mahalaxmi Finance.
@endcomponent