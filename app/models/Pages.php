<?php
class Pages extends Eloquent {
	public $table = 'pages';

	public function navigation() {
		return $this->hasOne('Navigation', 'page_id');
	}

	public function widgets() {
		return $this->hasMany('Widgets', 'page_id');
	}
}
?>