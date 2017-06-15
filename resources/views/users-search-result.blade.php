<h3>Search result of '{{$keyword}}'</h3>
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
    @foreach($searchResultUserData as $resultData)
        <tr>
          <td>{{$i}}</td>
          <td>{{$resultData->name}}</td>
          <td>{{$resultData->email}}</td>
          <td>{{$resultData->role}}</td>
          <td>{{$resultData->created_at}}</td>
          <td>
            <input type="button" class="btn btn-danger" value="delete" data-target="#userDelete{{$resultData->id}}" data-toggle="modal"/>
            <a href="{{route('users-update', ['idUser' => $resultData->id ])}}"><input type="button" class="btn btn-warning" value="update" /></a>
         </td>
        </tr>

        <!--Modal delete-->
        <div id="userDelete{{$resultData->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" aria-hidden="true" class="modal fade">
            <div class="modal-dialog">
              <form role="form" method="post" action="{{ route('users-delete') }}">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$resultData->id}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                        <h4 id="modal-responsive-label" class="modal-title">Delete user {{$resultData->email}}</h4></div>
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
