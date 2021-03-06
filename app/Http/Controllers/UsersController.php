<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\User;
use Auth;
use Illuminate\Http\Request;

class UsersController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function __construct() {
		$this->middleware('auth', ['except' => ['show']]);
	}
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$user = User::findOrFail($id);
		return view('users.show')->withUser($user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit() {
		$user = Auth::user();
		return view('users.edit')->withUser($user);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserRequest $request, ImageUploadHandler $uploader, $id) {
		$user = User::findOrFail($id);
		$data = $request->all();

		if ($request->avatar) {
			$result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
			if ($result) {
				$data['avatar'] = $result['path'];
			}
		}
		$user->avatar = $data['avatar'];
		$user->update($request->all());
		session()->flash('success', '个人资料更新成功');
		return redirect()->to(route('users.show', $user->id));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}
}
