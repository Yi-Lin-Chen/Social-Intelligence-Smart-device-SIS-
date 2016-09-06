@extends('layouts.app')

@section('styles')
<style media="screen">
    .table td,
    .table th {
        text-align: center;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
$(function() {
    $(document).on('click', '.qr_button', function() {
        //console.log('.qr_button click');
        bootbox.alert('<img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&choe=UTF-8&chl=' + $(this).data('code') +  '\">');
    });
});
</script>
@endsection

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Access List</div>
                <div class="panel-body">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Access ID</th>
                                <th>Belong To</th>
                                <th>Expire Day</th>
                                <th>Actual Time</th>
                                <th>Created At</th>
                                <th>Last Update</th>
                                <th>View QR</th>
                                <th>Notify User</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $access_array as $access )
                                <tr>
                                    <td>{{ $access->id }}</td>
                                    <td>{{ $access->user_id }}</td>
                                    <td>{{ $access->expire_day }}</td>
                                    <td>{{ $access->getActualExpireTime() }}</td>
                                    <td>{{ $access->created_at }}</td>
                                    <td>{{ $access->updated_at }}</td>
                                    <td>
                                        <button data-code="{{ $access->qr_code }}" class="btn btn-default btn-xs qr_button">QR</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-inbox"></span></button>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span></button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Grant Access To User</div>
                <div class="panel-body">

                    @if( isset($errors) && count($errors) > 0 )
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post" action="/user">
                        {{ csrf_field() }}

                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="name">Name</label>
                                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ Request::old('name') }}">
                              </div>
                              <div class="form-group">
                                <label for="level">Level</label>
                                <select name="level" id="level" class="form-control">
                                    <option value="0">User</option>
                                    <option value="1">Manager</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ Request::old('email') }}">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone (EX: 0912000111)" value="{{ Request::old('phone') }}">
                              </div>
                              <div class="form-group">
                                  <label for="password">Password</label>
                                  <input type="password" class="form-control" name="password" id="password" placeholder="Name">
                              </div>
                              <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="text" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Email">
                              </div>

                          </div>
                      </div>
                      <hr>
                      <button type="submit" class="btn btn-default">Create</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
