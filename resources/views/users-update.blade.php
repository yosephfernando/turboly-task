@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update user {{$userUpdateData->email}}</div>

                <div class="panel-body">
                    <div class="col-md-12">
                      @if(session('status'))
                          <h4>{{ session('status') }}</h4>
                      @endif
                      <form class="form-group" method="post" action="{{route('users-update-action')}}">
                          {{csrf_field()}}
                          <input type="hidden" name="id" value="{{$userUpdateData->id}}" />
                          <div class="col-md-6">
                             <label>Name</label>
                             <input type="text" name="name" class="form-control" value="{{$userUpdateData->name}}" />
                          </div>
                          <div class="col-md-6">
                             <label>Email</label>
                             <input type="email" name="email" class="form-control" value="{{$userUpdateData->email}}"/>
                          </div>
                          <div class="col-md-12">
                             <label>Role</label>
                             <select name="role" class="form-control">
                               <option value="{{$userUpdateData->role}}" selected>{{$userUpdateData->role}}</option>
                               <option value="user">User</option>
                               <option value="admin">Admin</option>
                             </select>
                          </div>
                          <div class="col-md-12">
                             <div class="clear" style="height:10px"></div>
                             <input type="submit" class="btn btn-success" value="update"/>
                             <a href="{{route('users')}}"><input type="button" class="btn btn-danger" value="cancel"/></a>
                          </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
