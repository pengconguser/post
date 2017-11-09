<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	protected $fillable = [
		'name',
		'description',
	];

	public function topic() {
		return $this->belongsToMany(Category::class);
	}
}
