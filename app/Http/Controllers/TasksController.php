<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
Use App\User;
Use App\tasks;
use Yajra\Datatables\Datatables;
class TasksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('tasks');
    }

    public function listTasksData(Request $request)
    {
        $allTasksData = tasks::select(['task_id', 'task_title', 'task_desc', 'task_due_date','task_prior', 'task_status'])
                                ->where('task_status', '!=', 'deleted')
                                ->where('id', Auth::user()->id);

        if ($request->has('prior') && $request->get('prior') != "null") {
            $allTasksData->where('task_prior', $request->get('prior'));
        }

        if ($request->has('date') && $request->get('date') != "") {
            $allTasksData->where('task_due_date', $request->get('date'));
        }
        return Datatables::of($allTasksData)
             ->addColumn('action', function ($task) {
                return '<form role="form" method="post" action="/tasks/'.$task->task_id.'">
                  '.csrf_field().'
                  '.method_field("PUT").'
                  <input type="hidden" name="task_id" value="'.$task->task_id.'" />
                  <input class="btn btn-xs btn-success" type="submit" name="done" value="done" />
                  <input class="btn btn-xs btn-danger" type="submit" name="cancel" value="cancel" />
               </form>
               <a href="#'.$task->task_id.'" data-target="#taskDelete'.$task->task_id.'" data-toggle="modal"  class="btn btn-xs btn-danger">Delete</a>

               <!--Modal delete-->
                 <div id="taskDelete'.$task->task_id.'" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" aria-hidden="true" class="modal fade">
                     <div class="modal-dialog">
                       <form role="form" method="POST" action="/tasks/'.$task->task_id.'">
                         '.csrf_field().'
                         '.method_field("DELETE").'
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                 <h4 id="modal-responsive-label" class="modal-title">Delete task '.$task->task_title.'</h4></div>
                             <div class="modal-body">
                                 <div class="row">
                                       <h3 style="text-align:center">Are you sure want to delete this task ?</h3>
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

               ';
            })
            ->make(true);
    }

    public function store(Request $request){
      $add = new tasks();
      $add->id = Auth::user()->id;
      $add->task_title = $request->task_title;
      $add->task_desc = $request->task_desc;
      $add->task_prior = $request->task_prioroty;
      $add->task_due_date = $request->task_due_date;
      $add->task_status = "ongoing";
      $add->save();

      return Redirect::back()->with('status', 'Task added');
    }

    public function show($idTasks){
          $tasksUpdateData = User::tasks('task_id', $idTasks)->first();
         return view('tasks-update',
           [
             'idTasks' => $idTasks,
             'tasksUpdateData' => $tasksUpdateData
           ]
       );
    }

    public function update(Request $request, $idTask){
      if($request->has('done') && $request->done != ""){
        $updated = tasks::where('task_id', $idTask)
                  ->update([
                        'task_status' => 'done',
                        'updated_at' => \Carbon\Carbon::now(),
                   ]);
      }else{
        $updated = tasks::where('task_id', $idTask)
                  ->update([
                        'task_status' => 'pending',
                        'updated_at' => \Carbon\Carbon::now(),
                   ]);
      }

      return Redirect::back()->with('status', 'Task updated');
    }

    public function destroy($idTask){
      $deleted = tasks::where('task_id', $idTask)
                       ->delete();

      return Redirect::back()->with('status', 'Task deleted');
    }
}
