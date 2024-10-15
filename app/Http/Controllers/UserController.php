<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function roles()
    {
        if (in_array("roles", Auth::user()->permissions())) {
            return view('backend.roles.role_list');
        }
        abort(403);
    }
    public function get_roles_list()
    {
        if(Auth::user()->role_id == 1){
            $data = Role::orderBy('id',"DESC")->get();
        }else{
            $data = Role::where('id','!=',1)->orderBy('id',"DESC")->get();
        }
        return response()->json(['data'=>$data]);
    }
    public function add_role()
    {
        if (in_array("roles", Auth::user()->permissions())) {
            return view('backend.roles.add_role');
        }
        abort(403);
    }
    public function edit_role($id)
    {
        if (in_array("roles", Auth::user()->permissions())) {
            $data = Role::find($id);
            return view('backend.roles.edit_role',['data'=>$data]);
        }
        abort(403);
    }
    public function delete_role(Request $request)
    {
        $data = Role::where('id','!=',1)->where('id',$request->id)->delete();
        return "Deleted";
    }
    public function create_role(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/|unique:roles,name',
        ]);
        if(!$request->permission){
            return redirect()->back()->with('error','To create a role, at least one permission must be selected.');
        }
        $data = new Role();
        $data->name = $request->name;
        $data->permission = json_encode($request->permission);
        $data->save();

        return redirect('roles')->with('success','The role created successfully.');
    }
    public function update_role(Request $request)
    {
        
        $request->validate([
            'name' => 'required|max:255|unique:roles,name,'.$request->id,
        ]);

        if(!$request->permission){
            return redirect()->back()->with('error','To update a role, at least one permission must be selected.');
        }

        $data = Role::where('id',$request->id)->first();

        if($data){
            $data->permission = json_encode([]);
            $data->update();

            $data->name = $request->name;
            $data->permission = json_encode($request->permission);
            $data->update();
    
            return redirect('roles')->with('success','The role updated successfully.');
        }else{
            return redirect()->back()->with('error','Data not found.');
        }
    }
    public function users()
    {
        if (in_array("users", Auth::user()->permissions())) {
            return view('backend.users.user_list');
        }
        abort(403);
    }
    public function get_users_list()
    {   
        if(Auth::user()->role_id == 1){
            $data = User::with('role')->orderBy('id',"DESC")->get();
        }else{
            $data = User::where('role_id','!=',1)->with('role')->orderBy('id',"DESC")->get();
        }
        return response()->json(['data'=>$data]);
    }
    public function add_user()
    {
        if (in_array("users", Auth::user()->permissions())) {
            $roles = Role::where('id','!=',1)->orderBy('name','asc')->get();
            return view('backend.users.add_user',['roles' => $roles]);
        }
        abort(403);
    }
    public function edit_user($id)
    {
        if (in_array("users", Auth::user()->permissions())) {
            $data = User::find($id);
            $roles = Role::where('id','!=',1)->orderBy('name','asc')->get();
            return view('backend.users.edit_user',['data'=>$data,'roles' => $roles]);
        }
        abort(403);
    }
    public function delete_user(Request $request)
    {
        $data = User::where('role_id','!=',1)->where('id',$request->id)->delete();
        return "Deleted";
    }
    public function create_user(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'type' => 'required',
            'password' => 'required|min:8',
            'c_password' => 'required|min:8',
        ],[
            'c_password.required' => 'The confirm password field is required.'
        ]);

        if($request->password != $request->c_password){
            return redirect()->back()->with('error','The password & confirm password does not match.');
        }

        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->role_id = $request->role;
        $data->type = $request->type;
        $data->password = Hash::make($request->password);
        $data->save();
        return redirect('users')->with('success','The User Added Successfully');
    }
    public function update_user(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$request->id,
            'role' => 'required',
            'type' => 'required',
        ]);
        $data = User::where('role_id','!=',1)->where('id',$request->id)->first();
        if($data){
            $data->name = $request->name;
            $data->email = $request->email;
            $data->role_id = $request->role;
            $data->type = $request->type;
            $data->update();
    
            return redirect()->back()->with('success','The User Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
}
