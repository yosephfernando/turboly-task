@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>

                <div class="panel-body">
                    <div class="col-md-4 col-md-offset-8 row">
                      <div class="input-group">
                        <input id="keyword" type="text" class="form-control" placeholder="Search user" />
                        <span class="input-group-addon" id="gosrc" style="cursor:pointer">
                            go
                        </span>
                      </div>
                      <script>
                          $("#gosrc").click(function(){
                            var keyword = $("#keyword").val();
                            $.get( "/users-search/"+keyword)
                              .done(function( data ) {
                                  $("#table").empty();
                                  $("#table").html(data);
                              });
                          });
                      </script>
                      <div class="clear" style="height:10px"></div>
                    </div>
                    <div class="col-md-12 table-responsive" id="table">
                      @if(session('status'))
                          <h4>{{ session('status') }}</h4>
                      @endif
                          <table class="table table-striped table-bordered table-hover">
                           <tr>
                            <thead>
                              <th>#</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Role</th>
                              <th>Regiter date</th>
                              <th>Action</th>
                            </thead>
                          </tr>
                         <?php $i = 1 ?>
                          @foreach($allUserData as $userData)
                              <tr>
                                <td>{{$i}}</td>
                                <td>{{$userData->name}}</td>
                                <td>{{$userData->email}}</td>
                                <td>{{$userData->role}}</td>
                                <td>{{$userData->created_at}}</td>
                                <td>
                                  <input type="button" class="btn btn-danger" value="delete" data-target="#userDelete{{$userData->id}}" data-toggle="modal" />
                                  <a href="{{route('users-update', ['idUser' => $userData->id ])}}"><input type="button" class="btn btn-warning" value="update" /></a>
                               </td>
                              </tr>

                              <!--Modal delete-->
                              <div id="userDelete{{$userData->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" aria-hidden="true" class="modal fade">
                                  <div class="modal-dialog">
                                    <form role="form" method="post" action="{{ route('users-delete') }}">
                                      {{csrf_field()}}
                                      <input type="hidden" name="id" value="{{$userData->id}}">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                              <h4 id="modal-responsive-label" class="modal-title">Delete user {{$userData->email}}</h4></div>
                                          <div class="modal-body">
                                              <div class="row">
                                                    <h3 style="text-align:center">Are you sure want to delete this user ?</h3>
                                              </div>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
                                              <button type="submit" class="btn btn-success">Yes</button>
                                          </div>
                                      </div>
                                    </form>
                                  </div>
                              </div>

                            <?php $i++; ?>
                          @endforeach
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
