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
    public function listTasks()
    {
      return view('tasks');
    }

    public function listTasksData()
    {
        $allTasksData = tasks::select(['task_id', 'task_title', 'task_desc', 'task_due_date','task_prior', 'task_status'])
                                ->where('task_status', '!=', 'deleted')
                                ->where('id', Auth::user()->id);

        return Datatables::of($allTasksData)->addColumn('action', function ($task) {
                return '<form role="form" method="post" action="'.route('tasks-status-update').'">
                  '.csrf_field().'
                  <input type="hidden" name="task_id" value="'.$task->task_id.'" />
                  <input class="btn btn-xs btn-success" type="submit" name="done" value="done" />
                  <input class="btn btn-xs btn-danger" type="submit" name="cancel" value="cancel" />
               </form>';
            })
            ->make(true);
    }

    public function listTasksSearch($keyword)
    {

        $searcResultTasksData = tasks::orderBy('created_at')
                             ->where('task_title', 'like', '%'.$keyword.'%')
                             ->orWhere('task_desc', 'like', '%'.$keyword.'%')
                             ->where('task_status', '!=', 'deleted')
                             ->where('id', Auth::user()->id)
                             ->get();

         return view('task-filter-result',
           [
             'filterResultTasksData' => $searcResultTasksData,
           ]
       );
    }

    public function listTasksFilter($date, $prior)
    {
      if($date != "" && $prior == "null" ){
        $filterResultTasksData = tasks::orderBy('created_at')
                             ->where('task_due_date', $date)
                             ->where('task_status', '!=', 'deleted')
                             ->where('id', Auth::user()->id)
                             ->get();
      }else if($date == "null" && $prior != ""){
        $filterResultTasksData = tasks::orderBy('created_at')
                             ->where('task_prior', $prior)
                             ->where('id', Auth::user()->id)
                             ->get();
      }else if($date != "" && $prior != "" ){
        $filterResultTasksData = tasks::orderBy('created_at')
                             ->where('task_due_date', $date)
                             ->where('task_prior', $prior)
                             ->where('task_status', '!=', 'deleted')
                             ->where('id', Auth::user()->id)
                             ->get();
      }

        return view('task-filter-result',
          [
            'filterResultTasksData' => $filterResultTasksData,
          ]
      );
    }

    public function addTasksAction(Request $request){
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

    public function updateTasks(Request $request, $idTasks){
          $tasksUpdateData = User::tasks('task_id', $idTasks)->first();
         return view('tasks-update',
           [
             'idTasks' => $idTasks,
             'tasksUpdateData' => $tasksUpdateData
           ]
       );
    }

    public function updateTasksDesc(Request $request){
      $idTask = $request->task_id;
      $updated = tasks::where('task_id', $idTask)
                ->update([
                      'task_desc' => $request->task_desc,
                      'updated_at' => \Carbon\Carbon::now(),
                 ]);

      return "success";
    }

    public function updateTasksStatus(Request $request){
      $idTask = $request->task_id;
      if($request->task_status == "done"){
        $updated = tasks::where('task_id', $idTask)
                  ->update([
                        'task_status' => 'done',
                        'updated_at' => \Carbon\Carbon::now(),
                   ]);
      }else{
        $updated = tasks::where('task_id', $idTask)
                  ->update([
                        'task_status' => 'deleted',
                        'updated_at' => \Carbon\Carbon::now(),
                   ]);
      }


      return "success";
    }

    public function deleteTasks(Request $request){
      $idTask = $request->task_id;
      $deleted = tasks::where('task_id', $idTask)
                       ->delete();

      return Redirect::back()->with('status', 'Task deleted');
    }
}
