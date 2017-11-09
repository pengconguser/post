<?php

namespace App\Http\Controllers;

use App\Category;
use App\Topic;

class CategoriesController extends Controller {
	public function show($id) {
		$topics = Topic::where('category_id', $id)->with('category', 'user')->paginate(20);
		$category = Category::where('id', $id)->first();
		return view('topics.index')
			->withCategory($category)
			->withTopics($topics);
	}
}
