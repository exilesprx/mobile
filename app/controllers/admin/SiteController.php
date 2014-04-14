<?php
namespace Admin;
use Sites;
use View;
use Header;
use Session;
use Validator;
use Input;
use Redirect;
use Footer;

class SiteController extends IndexController {

	public function __construct() {
		parent::__construct();
	}

	public function addView() {
		$this->layout->page = View::make('admin.site.add');
		$this->layout->page->required = Session::get('errors');
	}

	public function editView($siteId) {
		$this->layout->page = View::make('admin.site.edit');
		$this->layout->page->site = Sites::find($siteId);
		$this->layout->page->required = Session::get('errors');
	}

	public function indexView() {
		$this->layout->page = View::make('admin.site.view');
		$this->layout->page->sites = Sites::all();
	}

	public function deleteView($siteId) {
		$this->layout->page = View::make('admin.site.delete');
		$this->layout->page->site = Sites::find($siteId);
	}

	public function headerEditView() {
		$this->layout->page = View::make('admin.header.edit');
		$this->layout->page->required = Session::get('errors');
		$this->layout->page->header = Header::where('site_id', '=', $this->site->id)->first();
	}

	public function footerEditView() {
		$this->layout->page = View::make('admin.footer.edit');
		$this->layout->page->required = Session::get('errors');
		$this->layout->page->footer = Footer::where('site_id', '=', $this->site->id)->first();
	}

	public function change() {
		$rules = array(
			'site' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if($validation->passes()) {
			$siteId = Input::get('site');
			Session::put('site.id', $siteId);
			$site = Sites::find($siteId);
			return Redirect::to('admin/welcome')->with('statusMessage', 'You have successfully changed the site to ' . $site->title);
		}
		else {
			return Redirect::to('admin/welcome')->with('statusMessage', 'You have select an invalid site.');
		}
	}

	public function create() {
		$rules = array(
			'domain' => 'required|unique:sites,domain',
			'title' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if($validation->passes()) {
			$site = new Sites();
			$site->home_folder = $this->sanitizeHomeFolder(Input::get('domain'));
			$site->domain = $this->sanitizeDomain(Input::get('domain'));
			$site->title = Input::get('title');
			$site->description = Input::get('description');
			$site->keywords = Input::get('keywords');
			$site->view_folder = $this->sanitizeViewFolder($site->home_folder);
			
			if(file_exists(path('app') . '/views/' . $site->view_folder)) {
				mkdir(path('public') . '/' . $site->home_folder);
			}
			else {
				mkdir(path('app') . '/views/' . $site->view_folder);
				mkdir(path('public') . '/' . $site->home_folder);
			}

			if(Input::has_file('logo')) {
				$newLogo = Input::file('logo');
				Input::upload('logo', path('public') . '/' . $site->home_folder . '/images/', $newLogo['name']);
				$site->logo = 'images/' . $newLogo['name'];
			}
			else if(Input::has('old_logo') && Input::get('old_logo') === '{remove}') {
				$site->logo = '';
			}
			$site->save();
			Session::put('site.id', $site->id);

			$essentials = $this->createEssentials($site);

			return Redirect::to('/admin/page/edit/' . $essentials['page']->id)->with('statusMessage', 'Please setup up your home page.');
		}
		else {
			return Redirect::to('/admin/sites/add')->with('errors', $validation->errors->all())->with_input();
		}
	}

	public function update($siteId) {
		$rules = array(
			'domain' => 'required|unique:sites,domain',
			'title' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if($validation->passes()) {
			$site = Sites::find($siteId);
			$site->title = Input::get('title');
			$site->description = Input::get('description');
			$site->keywords = Input::get('keywords');
			$site->domain = Input::get('domain');

			if(Input::has_file('logo')) {
				$newLogo = Input::file('logo');
				Input::upload('logo', path('public') . '/' . $this->site->home_folder . '/images/', $newLogo['name']);
				$site->logo = 'images/' . $newLogo['name'];
			}
			else if(Input::has('old_logo') && Input::get('old_logo') === '{remove}') {
				$site->logo = '';
			}

			$site->save();
			return Redirect::to('/admin/welcome')->with('statusMessage', 'Your settings have been successfully updated.');
		}
		else {
			return Redirect::to('/admin/sites/edit/' . $siteId)->with('errors', $validation->errors->all());
		}
	}

	public function delete($siteId) {
		$site = Sites::find($siteId);

		$rules = array(
			'delete' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if($validation->passes() && $site) {
			$site->page()->delete();
			$site->navigation()->delete();
			$site->footer()->delete();
			$site->header()->delete();
			$site->user()->delete();
			$site->delete();

			//need to switch the session site here incase the site we delete was the current site. Otherwise, we will need to wait for our session to expire...
			$site = Sites::where('domain', '=', Request::root())->first();
			if($site) {
				Session::put('site.id', $site->id);
			}
			else {
				Session::put('site_id', 1);
			}

			return Redirect::to('admin/sites')->with('statusMessage', 'You have successfully deleted the site: ' . $site->title);
		}
		else {
			return Redirect::to('admin/sites')->with('statusMessage', 'The site ' . $site->title . ' was not deleted.');
		}
	}

	public function headerUpdate() {
		$header = Header::where('site_id', '=', Session::get('site.id'))->first();
		$header->content = trim(Input::get('header_content'));
		$header->save();
		return Redirect::to('/admin/page')->with('statusMessage', 'You have successfully updated the header.');
	}

	public function footerUpdate() {
		$footer = Footer::where('site_id', '=', Session::get('site.id'))->first();
		$footer->content = trim(Input::get('footer_content'));
		$footer->save();
		return Redirect::to('/admin/page')->with('statusMessage', 'You have successfully updated the footer.');
	}

	private function createEssentials($site) {
		$page = new Pages();
		$page->site_id = $site->id;
		$page->page_url = 'index';
		$page->page_name = 'Home Page';
		$page->save();

		$footer = new Footer();
		$footer->site_id = $site->id;
		$footer->save();

		$header = new Header();
		$header->site_id = $site->id;
		$header->save();

		return array('page' => $page, 'header' => $header, 'footer' => $footer);
	}

	private function sanitizeViewFolder($folder) {
		$folder = preg_replace(array('/.com/', '/.local/', '/.dev/', '/.net/'), '', $folder);
		$folder = preg_replace(array('/\./'), '_', $folder);
		return $folder;
	}

	private function sanitizeHomeFolder($domain) {
		return preg_replace(array('/http:\/\//', '/www./'), '', $domain);
	}

	private function sanitizeDomain($domain) {
		return 'http://' . preg_replace(array('/http:\/\//', '/www./'), '', $domain);
	}
}