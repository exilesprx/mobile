<?php
namespace Admin;
use View;
class HelpController extends IndexController {

	public function __construct() {
		parent::__construct();
	}

	public function help() {
		$this->layout->page = View::make('admin.help');
	}
}