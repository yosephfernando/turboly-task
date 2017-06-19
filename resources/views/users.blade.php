@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>

                <div class="panel-body">
                    <div class="col-md-12 table-responsive" id="table">
                      @if(session('status'))
                          <h4>{{ session('status') }}</h4>
                      @endif
                          <table class="table table-striped table-bordered table-hover" id="users-table">
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
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        var table = $("#users-table").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
              url: '{{route('users-data')}}',
              method: 'GET'
            },

            columns: [
              { data: 'id' },
              {data: 'name', name: 'name'},
              { data: 'email', name: 'email' },
              { data: 'role', name: 'email' },
              { data: 'updated_at' },
              {data: 'action', name: 'action', orderable: false, searchable: false}
             ]
        });
    });
</script>
@endsection
