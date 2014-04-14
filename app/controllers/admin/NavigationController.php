<?php
namespace Admin;
use View;
use Input;
use Redirect;

class NavigationController extends IndexController {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$navigation = $this->site->navigation()->orderBy('position', 'ASC')->get();
		if(!$navigation) {
			$navigation = array();
		}

		$navigationIds = $this->site->navigation()->lists('page_id');
		$pages = $this->site->page()->whereNotIn('id', $navigationIds ? $navigationIds : array(0))->where('page_url', '!=' , 'index')->get();
		
		$this->layout->page = View::make('admin.navigation');
		$this->layout->page->navigation = $navigation;
		$this->layout->page->pages = $pages;
	}

	public function update() {
		
		foreach(Input::get() as $key => $val) {
			if(!is_numeric($key)) continue;

			$nav = $this->site->navigation()->where('page_id', '=', $val)->first();
			if(!$nav) {
				$page = $this->site->page()->where('id', '=', $val)->first();
				$nav = new Navigation();
				$nav->site_id = $this->site->id;
				$nav->name = $page->page_name;
				$nav->page_id = $page->id;
			}
			$nav->position = $key + 1;
			$nav->save();
		}
		$this->site->navigation()->whereNotIn('page_id', Input::get())->delete();
		
		return Redirect::to('admin/navigation')->with('statusMessage', 'Your navigation has successfully been updated.');
	}
}