<?php
class Navigation extends Eloquent {
	public $table = 'navigation';

	public function page() {
		return $this->belongsTo('Pages', 'page_id');
	}
}
?>