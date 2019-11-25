<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;

class UserController extends Controller
{
        public function index()
    {
    	$user = User::all();
    	return view('users.index', ['users' => $user]);
    }

    public function create()
    {
    	return view('users.create');
    }
 
    public function store(Request $request)
    {
    	$this->validate($request,[
    		'name' => 'required',
    		'username' => 'required',
    		'email' => 'required|email',
    		'role_id' => 'required'
    	]);
 
        User::create([
    		'name' => $request->name,
    		'username' => $request->username,
    		'email' => $request->email,
    		'role_id' => $request->role_id,
    		'active' => 1
    	]);
 
    	return redirect('/users');
    }
    
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', ['users' => $user]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request,[
           	'name' => 'required',
           	'username' => 'required',
			'email' => 'required|email',
			'role_id' => 'required'
        ]);
     
        $user = User::find($id);
        $user->name = $request->name;
		$user->username = $request->username;
		$user->email = $request->email;
		$user->role_id = $request->role_id;
        $user->save();
        return redirect('/users');
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/users');
    }
}