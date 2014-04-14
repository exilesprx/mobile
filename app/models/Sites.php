<?php
class Sites extends Eloquent {
	public $table = 'sites';

	public function navigation() {
		return $this->hasMany('Navigation', 'site_id');
	}

	public function page() {
		return $this->hasMany('Pages', 'site_id');
	}

	public function footer() {
		return $this->hasOne('Footer', 'site_id');
	}

	public function header() {
		return $this->hasOne('Header', 'site_id');
	}

	public function user() {
		return $this->hasMany('Users', 'site_id');
	}
}
?>