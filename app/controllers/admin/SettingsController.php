<?php
namespace Admin;
use View;
use Input;
use Redirect;

class SettingsController extends IndexController {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		//Asset::container('header')->add('jQuery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
		//Asset::container('header')->bundle('admin')->add('main', 'js/main.js');

		if(!$this->site) {
			$this->site = new Sites();
		}

		$this->layout->page = View::make('admin.settings');
		$this->layout->page->site = $this->site;
	}

	public function update() {
		$this->site->title = Input::get('title');
		$this->site->description = Input::get('description');
		$this->site->keywords = Input::get('keywords');
		$this->site->domain = URL::base();
		$this->site->home_folder = preg_replace(array('/http:\/\//', '/www./'), '', URL::base());

		if(Input::has_file('logo')) {
			$newLogo = Input::file('logo');
			Input::upload('logo', path('public') . '/' . $this->site->home_folder . '/images/', $newLogo['name']);
			$this->site->logo = 'images/' . $newLogo['name'];
		}
		else if(Input::has('old_logo') && Input::get('old_logo') === '{remove}') {
			$this->site->logo = '';
		}
		
		$this->site->save();
		return Redirect::to('admin/welcome')->with('statusMessage', 'Your settings have been successfully updated.');
	}
}