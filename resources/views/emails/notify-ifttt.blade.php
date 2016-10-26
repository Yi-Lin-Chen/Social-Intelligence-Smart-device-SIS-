Dear {{ $user->name }},<br/>
<br/>
Your IFTTT Condition IF {{ $ifttt->if }} {{ $ifttt->opr }} {{ $ifttt->value }} on device {{ $ifttt->uuid }} has invoked.<br/>
<br/>
<br/>
{{ $time }}<br/>
{{ config('app.name') }}<br/>
{{ config('app.url') }}
