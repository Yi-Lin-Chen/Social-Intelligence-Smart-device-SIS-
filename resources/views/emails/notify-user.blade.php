Dear {{ $user->name }},<br/>
<br/>
You have been granted access for
@if( $access->expire_day != 0 )
{{ $access->expire_day }}
@else
(Unlimited)
@endif
day, please present the following QR Code to the scanner.<br/>
<br/>
<img src="{{ $access->qr_code('400') }}" alt="QR Code" />
<br/>
{{ $time }}<br/>
{{ config('app.name') }}
{{ config('app.url') }}
