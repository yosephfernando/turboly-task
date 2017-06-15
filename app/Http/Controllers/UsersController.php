<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
Use App\User;
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
        $allUserData = User::orderBy('created_at')->get();
        return view('users',
          [
            'allUserData' => $allUserData
          ]
      );
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
