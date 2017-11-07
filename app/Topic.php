<?php

namespace App;

class Topic extends Model {
	protected $fillable = [
		'title',
		'body',
		'user_id',
		'category_id',
		'reply_count',
		'view_count',
		'last_reply_user_id',
		'order',
		'excerpt',
		'slug',
	];
}
