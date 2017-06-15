<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
Use App\User;
Use App\tasks;
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
        $allTasksData = tasks::orderBy('created_at')
                                ->where('task_status', '!=', 'deleted')
                                ->where('id', Auth::user()->id)
                                ->get();
        return view('tasks',
          [
            'allTasksData' => $allTasksData
          ]
      );
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
      $updated = tasks::where('task_id', $idTask)
                ->update([
                      'task_status' => $request->task_status,
                      'updated_at' => \Carbon\Carbon::now(),
                 ]);

      return "success";
    }

    public function deleteTasks(Request $request){
      $idTask = $request->task_id;
      $deleted = tasks::where('task_id', $idTask)
                       ->delete();

      return Redirect::back()->with('status', 'Task deleted');
    }
}
