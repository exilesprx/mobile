<?php
namespace Admin;
use Controller;
use Config;
use Session;
use View;
use Request;
use Redirect;
use Sites;
use Auth;

class IndexController extends Controller {
	protected $site;
	protected $pages;
	public $layout;

	public function __construct() {
		Config::set('application.asset_Request', '');

		if(Session::has('site.id')) {
			$this->site = Sites::where('id', '=', Session::get('site.id'))->first();
		}
		else {
			$validDomains = array();
			$validDomains[] = preg_replace(array('/http:\/\//', '/http:\/\/www\./'), 'http://www.', Request::root());
			$validDomains[] = preg_replace(array('/http:\/\//', '/http:\/\/www\./'), 'http://', Request::root());
			$this->site = Sites::whereIn('domain', $validDomains)->first();
			Session::put('site.id', $this->site->id);
		}

		if($this->site) {
			$this->pages = $this->site->page()->get();
		}

		$this->layout = View::make('admin.layout');
		$this->layout->site = $this->site;
		$this->layout->topnav = View::make('admin.topnav');
		$this->layout->topnav->site = $this->site;
	}
	
	public function index() {
		
		if(Auth::check()) {
			return Redirect::to('admin/welcome');
		}
		$this->layout->page = View::make('admin.index');
		$this->layout->page->error = Session::get('loginError');
	}

	public function welcome() {
		$navigation = $this->site->navigation()->orderBy('position')->get();
		if(!$navigation) {
			$navigation = null;
		}

		$this->layout->page = View::make('admin.welcome');

		$user = Auth::user();
		if($user && $user->has_role('superadmin')) {
			$this->layout->page->siteSelect = View::make('admin.sections.siteselect');
			$this->layout->page->siteSelect->sites = Sites::lists('title', 'id');
		}
	}
}