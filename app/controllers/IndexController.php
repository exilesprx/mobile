<?php

class IndexController extends BaseController {

	protected $page;
	
	public function __construct() {
		$this->initialize();
	}

	public function initialize() {
		parent::initialize();
		$this->page = $this->site->page()->where('page_url', '=', Request::segment(1, 'index'))->first();
		
		if(View::exists($this->site->view_folder . '.layout')) {
			$this->layout = View::make($this->site->view_folder . '.layout');
		}
		else {
			$this->layout = View::make('default.layout');
		}

		$footer = $this->site->footer()->where('content', '!=', '')->first();
		if($footer) {
			$this->layout->footer = $footer->content;
		}
		else {
			if(View::exists($this->site->view_folder . '.footer')) {
				$this->layout->footer = View::make($this->site->view_folder . '.footer');
			}
			else {
				$this->layout->footer = View::make('default.footer');
			}
		}

		$header = $this->site->header()->where('content', '!=', '')->first();
		if($header) {
			$this->layout->htmlhead = $header->content;
		}
		else {
			if(View::exists($this->site->view_folder . '.header')) {
				$this->layout->htmlhead = View::make($this->site->view_folder . '.header');
			}
			else {
				$this->layout->htmlhead = View::make('default.header');
				$this->layout->htmlhead->site = $this->site;
			}
		}

		$this->layout->site = $this->site;
	}
	
	public function index() {
		if(!$this->page) {
			return Redirect::to('/');
		}

		$widgets = $this->page->widgets()->get();

		if(View::exists($this->site->view_folder . '.' . Request::segment(1, 'index'))) {
			$this->layout->page = View::make($this->site->view_folder . '.' . Request::segment(1, 'index'));

			foreach($widgets as $widget) {
				Section::inject($widget->name, $widget->content);
			}
		}
		else {
			$this->layout->page = View::make('default.index');

			foreach($widgets as $widget) {
				$pattern = '@yield(\'' . $widget->name . '\')';
				$this->page->page_content = str_replace($pattern, $widget->content, $this->page->page_content);
			}
		}
		
		$this->layout->page->navigation = $this->site->navigation()->with('page')->orderBy('position')->get();
		$this->layout->page->page = $this->page;
	}

	public function page() {

		if(!$this->page) {
			return Redirect::to('/');
		}

		$widgets = $this->page->widgets()->get();

		if(View::exists($this->site->view_folder . '.' . Request::segment(1, 'index'))) {
			$this->layout->page = View::make($this->site->view_folder . '.' . Request::segment(1, 'index'));
			
			foreach($widgets as $widget) {
				Section::inject($widget->name, $widget->content);
			}
		}
		else {
			$this->layout->page = View::make('default.page');

			foreach($widgets as $widget) {
				$pattern = '@yield(\'' . $widget->name . '\')';
				$this->page->page_content = str_replace($pattern, $widget->content, $this->page->page_content);
			}
		}
		$this->layout->page->page = $this->page;
	}
}