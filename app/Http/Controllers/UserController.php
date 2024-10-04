<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Traits\General;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use General;

    public function index()
    {

        $data['title'] = 'All Users';
        $data['users'] = User::orderBy('id','DESC')->get();
        $data['navUserParentActiveClass'] = 'inactive';
        $data['leftUserParentActiveClass'] = 'active';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserActiveClass'] = 'mm-active';
        return view('pages.user.index', $data);
    }

    public function create()
    {

        $data['title'] = 'Add User';
        $data['navUserParentActiveClass'] = 'inactive';
        $data['leftUserParentActiveClass'] = 'active';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserCreateActiveClass'] = 'mm-active';
        $data['roles'] = Role::all();
        return view('pages.user.create', $data);
    }


    public function store(UserRequest $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->role = 1;
        $user->assignRole($request->role_name);
        $user->email_verified_at = Carbon::now()->format("Y-m-d H:i:s");
        $user->save();
        return $this->controlRedirection($request, 'user', 'User');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit User';
        $data['navUserParentActiveClass'] = 'active';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserActiveClass'] = 'mm-active';
        $data['roles'] = Role::all();
        $data['user'] = User::find($id);
        return view('pages.user.edit', $data);
    }

    public function update(EditUserRequest $request, $id)
    {
        if (User::whereEmail($request->email)->where('id', '!=', $id)->count() > 0) {
            $this->showToastrMessage('warning', 'Email already exist');
            return redirect()->back();
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        if ($request->role_name) {
            DB::table('model_has_roles')->where('role_id', $user->roles->first()->id)->where('model_id', $id)->delete();
        }
        $user->assignRole($request->role_name);
        $user->save();
        return $this->controlRedirection($request, 'user', 'User');
    }

    public function delete($id)
    {

        User::whereId($id)->delete();

        $this->showToastrMessage('error', 'User has been deleted');
        return redirect()->back();
    }
}
