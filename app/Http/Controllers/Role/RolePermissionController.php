<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;
use App\Traits\General;

class RolePermissionController extends Controller
{

    use General;
    public function index()
    {
        $data['title'] = 'Manage Roles';
        $data['roles'] = Role::paginate(25);
        $data['navUserParentActiveClass'] = 'active';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserRoleActiveClass'] = 'mm-active';
        return view('pages.role.index', $data);
    }


    public function create()
    {
        $data['title'] = 'Add Role';
        $data['roles'] = Role::all();
        $data['permissions'] = Permission::all();
        $data['navUserParentActiveClass'] = 'active';
        $data['leftUserParentActiveClass'] = 'inactive';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserRoleActiveClass'] = 'mm-active';
        return view('pages.role.create', $data);
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        foreach($request->permissions as $single_permission){
            $permission[] = Permission::find($single_permission);
        }
        $role->givePermissionTo($permission);
        $this->showToastrMessage('success', 'Role has been created !');
        return $this->controlRedirection($request, 'role', 'Role');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Role';
        $data['role'] = Role::find($id);
        $data['permissions'] = Permission::all();
        $data['selected_permissions'] = DB::table('role_has_permissions')->where('role_id', $id)->select('permission_id')->pluck('permission_id')->toArray();
        $data['navUserParentActiveClass'] = 'mm-active';
        $data['leftUserParentActiveClass'] = 'inactive';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserRoleActiveClass'] = 'mm-active';
        return view('pages.role.edit', $data);

    }

    public function update(RoleRequest $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        DB::table('role_has_permissions')->where('role_id', $id)->delete();
        foreach($request->permissions as $single_permission){
            $permission[] = Permission::find($single_permission);
        }
        $role->givePermissionTo($permission);
        Artisan::call('cache:clear');
        $this->showToastrMessage('success', 'Role has been updated !');
        return $this->controlRedirection($request, 'role', 'Role');
    }
    public function delete($id)
    {
        $role = Role::find($id);
        DB::table('role_has_permissions')->where('role_id', $id)->delete();
        $role->delete();
        $this->showToastrMessage('error', 'Role has been deleted');
        return redirect()->back();
    }

}
