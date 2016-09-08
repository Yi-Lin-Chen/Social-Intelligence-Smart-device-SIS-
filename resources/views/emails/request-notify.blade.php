Dear Manager,

{{ $name }} has requested for access to your room, please proceed to the following url to approve or deny this request, thank you.

{{ config('app.url') }}/approval/{{ $req_id }}

{{ $time }}
{{ config('app.name') }}
