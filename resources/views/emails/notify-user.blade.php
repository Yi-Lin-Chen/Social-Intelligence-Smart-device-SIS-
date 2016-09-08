Dear {{ $user->name }},<br/>
<br/>
You have been granted access for {{ $access->expire_day }} day, please present the following QR Code to the scanner.<br/>
<br/>
<img src="{{ $access->qr_code() }}" alt="QR Code" />
<br/>
{{ $time }}<br/>
{{ config('app.name') }}
{{ config('app.url') }}
