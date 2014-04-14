<?php
class AccountLockouts extends Eloquent {
	public $table = 'account_lockouts';

	public function user() {
		return $this->belongsTo('Users', 'id');
	}
}
?>