@extends('layouts.app')

@section('title', 'User')

@section('styles')

@endsection


@section('script')
<script>
$(function() {

    $(document).on('click' , '.btn-delete' , function(){

        var id = $(this).data('id');
        console.log('btn-delete click, id = ' + id);

        bootbox.confirm('Do you really want to delete user #' + id + '?', function(ret) {
            if(ret) {
                $.ajax({
                    url: '/user/' + id,
                    type: 'post',
                    data: {
                        _method:"DELETE" ,
                        _token: window.Laravel.csrfToken
                    }
                }).done(function(resp) {
                    console.log(resp);
                    location.href = '/user';
                }).fail(function(resp) {
                    bootbox.alert('Delete user fail!');
                    console.error(resp);
                });
            }
        });
        //console.log('post succee');
    });

    $(document).on('click' , '.btn-update' , function(){

        var user =$(this).data('user');
        console.log('btn-update click, user data = ' + user);
        setTimeout(function() {
            $('#level-update option[value="' + user.level + '"]').attr('selected', 'selected');
        }, 200);

        bootbox.dialog({
                    title: "You are updating " + user.name,
                    message:
                    '<div class="row">  ' +
                        '<div class="col-md-12"> ' +
                            '<form class="form-horizontal" id="form" method="post" action="/user/update/' + user.id + '">' +
                            '{{ csrf_field() }}' +
                                '<div class="col-md-6 update-from" style="padding-right: 30px;">' +
                                    '<div class="form-group"> ' +
                                        '<label for="name">Name</label> ' +
                                                '<input id="name" name="name" type="text" placeholder="Name" class="form-control input-md" value="' + user.name + '"> ' +
                                    '</div> ' +
                                    '<div class="form-group"> ' +
                                        '<label for="level">Level</label> ' +
                                            '<select name="level" id="level-update" class="form-control">' +
                                                '<option value="0">User</option>' +
                                                '<option value="1">Manager</option>' +
                                            '</select>' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                        '<label for="email">Email address</label>' +
                                        '<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="' + user.email + '" disabled>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-md-6 update-from" style="padding-left: 30px;">' +
                                    '<div class="form-group"> ' +
                                        '<label for="phone">Phone</label> ' +
                                        '<input id="phone" name="phone" type="text" placeholder="Phone (EX: 0912000111)" class="form-control input-md" value="' + user.phone + '">' +
                                    '</div> ' +
                                    '<div class="form-group"> ' +
                                        '<label for="password">New password</label> ' +
                                        '<input type="password" class="form-control" name="password" id="password" placeholder="New Password">' +
                                    '</div>' +
                                    '<div class="form-group"> ' +
                                        '<label for="password_confirmation">New Password</label> ' +
                                        '<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm New Password">' +
                                    '</div>' +
                                '</div>' +

                                '<button type="submit" class="btn btn-default">Update</button>' +
                            '</form>' +
                        '</div>' +
                    '</div>'
                }
        );
    });
});
</script>
@endsection

@section('content')
<div class="container">

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

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">User List</div>
                <div class="panel-body">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>
                                    User ID
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Phone
                                </th>
                                <th>
                                    Level
                                </th>
                                <th>
                                    Created At
                                </th>
                                <th>
                                    Last Update
                                </th>
                                <th>
                                    Update
                                </th>
                                <th>
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $users as $user )

                                @if( $user->is_deleted == true )

                                @else
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            @if( $user->level == 1 )
                                                Manager
                                            @else
                                                User
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->updated_at }}</td>
                                        <td>
                                            <button data-user="{{ $user }}" class="btn btn-primary btn-xs btn-update"><span class="glyphicon glyphicon-edit"></span></button>
                                        </td>
                                        <td>
                                            <button data-id="{{ $user->id }}" class="btn btn-danger btn-xs btn-delete"><span class="glyphicon glyphicon-remove"></span></button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create User</div>
                <div class="panel-body">



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
                                    <option value="null">Please select</option>
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
                                  <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                              </div>
                              <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
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
