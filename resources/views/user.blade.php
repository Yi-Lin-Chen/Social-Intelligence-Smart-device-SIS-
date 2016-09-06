@extends('layouts.app')

@section('styles')
<style media="screen">
    .table td,
    .table th {
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
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
                <div class="panel-heading">Create User</div>
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
