<?php
namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use Request;
Use App\User;
Use App\tasks;
trait alert {

  public static function alertDeadline(){
    if(Auth::user()){
        $todayTask = tasks::where('task_due_date', date('Y-m-d'))
                    ->where('id', Auth::user()->id)
                     ->where('task_status', '!=', 'done')
                     ->get();

        $notif = User::select('notif')
                        ->where('id', Auth::user()->id)
                        ->get();

        if(Auth::user()->role = 'User' && $notif[0]->notif == 1){
                echo '<!--Modal add-->
                <div id="alert" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                <h4 id="modal-responsive-label" class="modal-title">Today deadline</h4></div>
                                <div class="modal-body">
                                    <div class="row">';
                                     if($todayTask->isEmpty()){
                                        echo "<p class='text-center'>No deadline !</p>";
                                     }else{
                                        foreach($todayTask as $task){
                                            echo '<ul>';
                                              echo '<li>Title : '.$task->task_title."<br />Priority : ".$task->task_prior.'</li>';
                                            echo '</ul>';
                                        }
                                     }
                                    echo '</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-success">Ok</button>
                                </div>
                        </div>
                      </form>
                    </div>
                </div>' ;
                echo '<script>
                    $("#alert").modal("show");
                </script>';

                $clearNotif = User::where('id', Auth::user()->id)
                                    ->update(['notif' => 0]);
        }
      }
    }
}
