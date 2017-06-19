<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
Use App\User;
use Yajra\Datatables\Datatables;
class UsersController extends Controller
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

     public function listUsers()
     {
           return view('users');
     }

    public function listUsersData()
    {
      return Datatables::of(User::query())->addColumn('action', function ($user) {
                return '
                <a href="/users-update/'.$user->id.'" class="btn btn-xs btn-warning">Edit</a>
                <a href="#'.$user->id.'" data-target="#userDelete'.$user->id.'" data-toggle="modal"  class="btn btn-xs btn-danger">Delete</a>

                <!--Modal delete-->
                  <div id="userDelete'.$user->id.'" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" aria-hidden="true" class="modal fade">
                      <div class="modal-dialog">
                        <form role="form" method="post" action="'.route("users-delete").'">
                          '.csrf_field().'
                          <input type="hidden" name="id" value="'.$user->id.'">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                  <h4 id="modal-responsive-label" class="modal-title">Delete user '.$user->email.'</h4></div>
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

                ';
            })
            ->make(true);
    }

    public function listUsersSearch($keyword)
    {
        $searchResultUserData = User::orderBy('created_at')
                             ->where('name', 'LIKE' ,'%'.$keyword.'%')
                             ->orWhere('email','LIKE', '%'.$keyword.'%')
                             ->get();

        return view('users-search-result',
          [
            'searchResultUserData' => $searchResultUserData,
            'keyword' => $keyword
          ]
      );
    }

    public function updateUser(Request $request, $idUser){
          $userUpdateData = User::where('id', $idUser)->first();
         return view('users-update',
           [
             'idUser' => $idUser,
             'userUpdateData' => $userUpdateData
           ]
       );
    }

    public function updateUserAction(Request $request){
      $idUser = $request->id;
      $updated = User::where('id', $idUser)
                ->update([
                      'name' => $request->name,
                      'email' => $request->email,
                      'role' => $request->role,
                      'updated_at' => \Carbon\Carbon::now(),
                 ]);

      return Redirect::back()->with('status', 'User updated');
    }

    public function deleteUser(Request $request){
      $idUser = $request->id;
      $deleted = User::where('id', $idUser)
                       ->delete();

      return Redirect::back()->with('status', 'User deleted');
    }

    public function performLogout(Request $request) {
      $addNotif = User::where('id', Auth::user()->id)
                          ->update(['notif' => 1]);

       Auth::logout();
       return redirect('login');
     }
}
