<?php
namespace Admin;
use View;
use Session;
use Validator;
use Redirect;
use Input;
use Path;
use Filesystem;
use Pages;
use URL;

class PageController extends IndexController {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->layout->page = View::make('admin.pages.view');
		$this->layout->page->pages = $this->pages;
	}

	public function editView($pageId) {
		$this->layout->page = View::make('admin.pages.edit');
		$this->layout->page->pages = $this->pages;
		$this->layout->page->current_page = $this->site->page()->where('id', '=', $pageId)->first();
		$this->layout->page->required = Session::get('errors');
	}

	public function addView() {
		$this->layout->page = View::make('admin.pages.add');
		$this->layout->page->required = Session::get('errors');
	}

	public function deleteView($pageId) {
		$this->layout->page = View::make('admin.pages.delete');
		$this->layout->page->current_page =  $this->site->page()->with('navigation')->where('id', '=', $pageId)->first();
	}

	public function create() {
		$rules = array(
			'page_url' => 'required',
			'page_name' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails()) {
			return Redirect::to('/admin/page/add')->with('errors', $validation->messages());
		}
		
		if($this->site->page()->where('page_url', '=', Input::get('page_url'))->first()) {
			$errors[] = "A page with the URL of '" . Input::get('page_url') . "'' has already been created. Please specify a unique URL.";
		}
		else {
			$page = new Pages();
			$page->site_id = $this->site->id;
			$this->savePage($page);

			$message = 'You have successfully created a new page: <strong>' . $page->page_name . '</strong>.<br/>';
			$message.= 'The new page can be found at URL: ' . URL::to($page->page_url) . '';
			return Redirect::to('admin/page')->with('statusMessage', $message);
		}
	}

	public function update($pageId) {
		$rules = array(
			'page_url' => 'required',
			'page_name' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails()) {
			return Redirect::to('/admin/page/edit/' . $pageId)->with('errors', $validation->messages());
		}
		
		$page = $this->site->page()->with('navigation')->where('id', '=', $pageId)->first();
		$this->savePage($page);
		
		$message = 'You have successfully saved your revisions to the <strong>' . $page->page_name . '</strong> page.<br/>';
		$message.= 'The page you just created is locationed at this URL: ' . $this->site->domain . '/' . $page->page_url . '';

		return Redirect::to('admin/page')->with('statusMessage', $message);
	}

	public function delete($pageId) {
		$rules = array(
			'delete' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		$page = $this->site->page()->with('navigation')->where('id', '=', $pageId)->first();

		if($validation->fails() && !$page) {
			return Redirect::to('admin/page/edit/'.$page->id)->with('statusMessage', 'The page ' . $pageName . ' was not deleted.');
		}

		$navigation = $this->site->navigation()->where('page_id', '=', $page->id)->first();
		if($navigation) {
			$navigation->delete();
		}
		$pageName = $page->page_name;
		$page->delete();
		unset($page);
		return Redirect::to('admin/page')->with('statusMessage', 'You have successfully deleted the page: ' . $pageName);
	}

	private function savePage($page) {
		$rules = array(
			'page_image' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);
		
		if($validation->passes()) {
			$image = Input::file('page_image');
			$imageName = $image->getClientOriginalName();
			if(!is_dir(base_path() . '/public/' . $this->site->home_folder . '/images')) {
				mkdir(base_path() . '/public/' . $this->site->home_folder . '/images', 775, true);

			}
			$image->move(base_path() . '/public/' . $this->site->home_folder . '/images', $imageName);
			$page->page_image = 'images/' . $imageName;
		}
		else if(Input::has('old_image') && Input::get('old_image') === '{remove}') {
			$page->page_image = '';
		}

		$page->page_content = Input::get('page_content');
		$page->page_url = str_replace(' ', '', Input::get('page_url'));
		$page->page_name = Input::get('page_name');
		$page->save();
	}
}