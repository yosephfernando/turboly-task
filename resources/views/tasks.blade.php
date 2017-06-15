@extends('layouts.app')

@section('content')
<style>
.datepicker{z-index:1151 !important;}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Tasks
                </div>

                <div class="panel-body">
                    <div class="col-md-3">
                        <input type="text" class="form-control dp" placeholder="date" id="date"  />
                        <div class="clear" style="height:15px"></div>
                    </div>
                    <div class="col-md-2">
                        <select id="prior" class="form-control">
                            <option value="null">--all --</option>
                            <option value="high">HIGH</option>
                            <option value="medium">MEDIUM</option>
                            <option value="low">LOW</option>
                        </select>
                        <div class="clear" style="height:15px"></div>
                    </div>
                    <div class="col-md-1">
                        <input id="filter" type="button" class="btn btn-warning" value="filter"/>
                        <div class="clear" style="height:15px"></div>
                    </div>
                    <div class="col-md-4 col-md-offset-2">
                      <div class="input-group">
                        <input id="keyword" type="text" class="form-control" placeholder="Search tasks" />
                        <span class="input-group-addon" id="gosrc" style="cursor:pointer">
                            go
                        </span>
                      </div>
                      <script>
                          $("#gosrc").click(function(){
                            var keyword = $("#keyword").val();
                            $.get( "/tasks-search/"+keyword)
                              .done(function( data ) {
                                  $("#tasks").empty();
                                  $("#tasks").html(data);
                              });
                          });

                          $("#filter").click(function(){
                            var date = $("#date").val();
                            var prior = $("#prior").val();
                            if(date == ""){date = "null"}
                            $.get( "/tasks-filter/"+date+"/"+prior)
                              .done(function( data ) {
                                  $("#tasks").empty();
                                  $("#tasks").html(data);
                              });
                          });
                      </script>
                      <div class="clear" style="height:10px"></div>
                    </div>
                    <div class="col-md-12">
                      <div class="col-md-6 row">
                          <input type="button" class="btn btn-success" value="new task" data-target="#addTask" data-toggle="modal" />
                          <div class="clear" style="height:15px"></div>
                      </div>

                      <!--Modal add-->
                      <div id="addTask" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" aria-hidden="true" class="modal fade">
                          <div class="modal-dialog">
                            <form role="form" method="post" action="{{ route('tasks-add') }}">
                              {{csrf_field()}}
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                      <h4 id="modal-responsive-label" class="modal-title">Add task</h4></div>
                                      <div class="modal-body">
                                          <div class="row">
                                                <div class="col-md-12">
                                                    <label>Title</label>
                                                    <input type="text" name="task_title" class="form-control" required/>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Description</label>
                                                    <textarea name="task_desc" class="form-control" required></textarea>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Priority</label>
                                                    <select name="task_prioroty" class="form-control" required>
                                                        <option value="high">HIGH</option>
                                                        <option value="medium">MEDIUM</option>
                                                        <option value="low">LOW</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Due date</label>
                                                    <input type="text" name="task_due_date" class="form-control dp" required/>
                                                </div>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" data-dismiss="modal" class="btn btn-danger">cancel</button>
                                          <button type="submit" class="btn btn-success">add</button>
                                      </div>
                              </div>
                            </form>
                          </div>
                      </div>
                      @if(session('status'))
                          <h4>{{ session('status') }}</h4>
                      @endif
                      <div id="tasks" class="col-md-12 row">
                            @foreach($allTasksData as $task)
                             <div class="col-md-3">
                                @if($task->task_prior == 'high' && $task->task_status != 'done')
                                  <div class="panel panel-danger">
                                @elseif($task->task_prior == 'medium' && $task->task_status != 'done')
                                  <div class="panel panel-warning">
                                @elseif($task->task_prior == 'low' && $task->task_status != 'done')
                                  <div class="panel panel-default">
                                @elseif($task->task_status == 'done')
                                  <div class="panel panel-success">
                                @endif

                                      <div class="panel-heading">{{$task->task_title}}
                                        <div class="btn-group pull-right">
                                         @if($task->task_status == 'done')
                                            <button id="x{{$task->task_id}}" class="btn btn-danger btn-xs">X</button>
                                         @else
                                            <button id="x{{$task->task_id}}" class="btn btn-danger btn-xs">X</button>
                                            <button id="v{{$task->task_id}}" class="btn btn-success btn-xs">V</button>
                                         @endif

                                        </div>
                                      </div>
                                      <div class="panel-body">
                                        <p>{{$task->task_desc}}</p>

                                        <p>
                                           @if($task->task_status != 'done')
                                           <em>due date : {{date('d M Y', strtotime($task->task_due_date))}}</em><br />
                                           <em>priority : {{$task->task_prior}}</em>
                                           @else
                                            <em>done date : {{date('d M Y', strtotime($task->updated_at))}}</em><br />
                                            <em>priority : {{$task->task_prior}}</em>
                                           @endif
                                        </p>
                                      </div>
                                  </div>
                             </div>
                             <script>
                                $("#x{{$task->task_id}}").click(function(){
                                  $.post( "/tasks-update-status",  {'task_id' : {{$task->task_id}}, 'task_status': 'deleted', '_token' : '{{csrf_token()}}' })
                                       .done(function( data ) {
                                         if(data == "success"){
                                            location.reload();
                                         }else{
                                            alert(data);
                                         }
                                         console.log( "Data Loaded: " + data );
                                       });
                                });

                                $("#v{{$task->task_id}}").click(function(){
                                  $.post( "/tasks-update-status",  {'task_id' : {{$task->task_id}}, 'task_status': 'done', '_token' : '{{csrf_token()}}' })
                                       .done(function( data ) {
                                         if(data == "success"){
                                            location.reload();
                                         }else{
                                            alert(data);
                                         }
                                         console.log( "Data Loaded: " + data );
                                       });
                                });
                             </script>
                            @endforeach
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.dp').datepicker({
      format: 'yyyy-mm-dd',
      todayHighlight: true,
    })
</script>
@endsection
