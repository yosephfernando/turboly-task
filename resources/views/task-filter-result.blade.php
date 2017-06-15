@foreach($filterResultTasksData as $task)
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
                <em>due date : {{$task->task_due_date}}</em><br />
                <em>priority : {{$task->task_prior}}</em>
            </p>
          </div>
      </div>
 </div>
 <script>
    $("#x{{$task->task_id}}").click(function(){
      $.post( "/tasks-update-status/",  {'task_id' : '{{$task->task_id}}', 'task_status': 'deleted', '_token' : '{{csrf_token()}}' })
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
      $.post( "/tasks-update-status/",  {'task_id' : '{{$task->task_id}}', 'task_status': 'done', '_token' : '{{csrf_token()}}' })
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
