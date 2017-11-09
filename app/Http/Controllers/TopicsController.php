<?php

namespace App\Http\Controllers;

use App\Category;
use App\Handlers\ImageUploadHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Topic;
use Auth;

class TopicsController extends Controller {
	public function __construct() {
		$this->middleware('auth', ['except' => ['index', 'show']]);
	}

	public function index() {
		$user = Auth::user();
		$topics = Topic::with('user', 'category')->paginate(30);
		return view('topics.index', compact('topics'))->withUser($user);
	}

	public function show(Topic $topic) {
		return view('topics.show', compact('topic'));
	}

	public function create(Topic $topic) {
		$user = Auth::user();
		$categories = Category::all();
		return view('topics.create_and_edit')
			->withUser($user)
			->withCategories($categories)
			->withTopic($topic);
	}

	public function store(TopicRequest $request, Topic $topic) {
		$topic->fill($request->all());
		$topic->user_id = Auth::id();
		$topic->excerpt = str_limit($topic->body, 200);
		$topic->save();
		return redirect()->route('topics.show', $topic->id)->with('message', '新建成功！.');
	}

	public function edit(Topic $topic) {
		$this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic) {
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic) {
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}
	public function upload_image(Request $request, ImageUploadHandler $uploader) {
		// 初始化返回数据，默认是失败的
		$data = [
			'success' => false,
			'msg' => '上传失败!',
			'file_path' => '',
		];
		// 判断是否有上传文件，并赋值给 $file
		if ($file = $request->upload_file) {
			// 保存图片到本地
			$result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
			// 图片保存成功的话
			if ($result) {
				$data['file_path'] = $result['path'];
				$data['msg'] = "上传成功!";
				$data['success'] = true;
			}
		}
		return $data;
	}
}