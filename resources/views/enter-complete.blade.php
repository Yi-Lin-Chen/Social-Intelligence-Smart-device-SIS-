@extends('layouts.app')

@section('title', 'Enter Complete')

@section('styles')
<style media="screen">
.panel {
    text-align: center;
    margin-top: 30px;
    margin-bottom: 60px;
}
</style>
@endsection

@section('scripts')

@endsection

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if( $status == false || $data == null )
                <div class="alert alert-danger">You have no active access, please <a href="/request">request</a> for a access first.</div>
            @else
                @foreach($data as $access)
                    @if( !$access->isExpired() )
                    <div class="panel panel-default">
                        <div class="panel-heading">Access will expire at
                            @if( $access->getActualExpireTime() == null )
                            (Never)
                            @else
                            {{ $access->getActualExpireTime() }}
                            @endif
                        </div>
                        <div class="panel-body">
                            <img src="{{ $access->qr_code('300') }}" alt="QR" />
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

</div>
@endsection
