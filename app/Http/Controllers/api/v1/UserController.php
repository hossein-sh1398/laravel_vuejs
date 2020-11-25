<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
class UserController extends Controller
{
	public function index(Request $request) 
	{
	    $users = User::query();

	    if (! in_array($request->q, ['', null, 'null']) ) 
	    {
	    	
	    	$users = $users->where('email', 'LIKE', '%' . $request->q . '%');
	    }
	    $users = $users->orderBy('id', 'DESC')->paginate(6)->appends(request()->query());

	    return $users;
	}

	public function create(Request $request)
	{
		$v = Validator::make($request->all(),[
			'name' => 'required',
			'email' => 'required',
			'password' => 'required'
		]);

		if ($v->fails()) {

			return response([
				'messages' => $v->messages(),
				'status' => 'error'
			], 422);
		}

		User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => \Hash::make($request->password)
		]);

		return [
			'status' => 'success'
		];
	}

	public function destroy(Request $request)
	{
		$user = User::find($request->id);
		$user->delete();
		return [
			'status' => 'success'
		];
	}

	public function edit(User $user)
	{
		return response()->json([
			'data' => $user
		]);
	}

	public function update(User $user, Request $request)
	{
		$user->update([
			'name' => $request->name,
			'email' => $request->email
		]);

		return response()->json([
			'data' => 'ok',
			'status' => 'success',
			'message' => 'the update successfully'
		]);
	}
}
