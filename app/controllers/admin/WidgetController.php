<?php
namespace Admin;
use Auth;
use View;
use Asset;
use Redirect;
use Session;
use Input;
use Validator;
use Widgets;

class WidgetController extends IndexController {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$pages = $this->site->page()->with('widgets')->get();
		$this->layout->page = View::make('admin.widgets.view');
		$this->layout->page->pages = $pages;
	}

	public function addView($pageId) {
		if(Auth::user()->has_role('user') && !Auth::user()->has_rule('widget.create')) {
			return Redirect::to('/admin/widgets');
		}

		$this->layout->page = View::make('admin.widgets.add');
		$this->layout->page->current_page = $this->site->page()->find($pageId);
		$this->layout->page->required = Session::get('errors');
	}

	public function editView($widgetId) {
		if(Auth::user()->has_role('user') && !Auth::user()->has_rule('widget.edit')) {
			return Redirect::to('/admin/widgets');
		}

		Asset::container('header')->add('jQuery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
		Asset::container('header')->bundle('admin')->add('CK Editor', 'ckeditor/ckeditor.js');
		Asset::container('header')->bundle('admin')->add('main', 'js/main.js');

		$this->layout->page = View::make('admin.widgets.edit');
		$this->layout->page->current_widget = Widgets::find($widgetId);
		$this->layout->page->required = Session::get('errors');
	}

	public function deleteView($widgetId) {
		if(Auth::user()->has_role('user') && !Auth::user()->has_rule('widget.delete')) {
			return Redirect::to('/admin/widgets');
		}

		$this->layout->page = View::make('admin.widgets.delete');
		$this->layout->page->current_widget = Widgets::find($widgetId);
		$this->layout->page->required = Session::get('errors');
	}

	public function update($widgetId) {
		$rules = array(
			'widget_name' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if($validation->passes()) {

			$widget = Widgets::find($widgetId);
			if($widget) {
				$widget->name = Input::get('widget_name');
				$widget->content = Input::get('widget_content');
				$widget->save();

				$message = 'You have successfully created a new widget.<br/>';
				$message.= 'Please contact your site administrator and have them paste the following code into your page: <br/><br/>';
				$message.= '@yeild("'. Input::get('widget_name') . '")';
				return Redirect::to('admin/widgets')->with('statusMessage', $message);
			}
			else {
				return Redirect::to('/admin/widgets')->with('statusMessage', 'The widget you attempted to edit does not exist');
			}
		}
		else {
			return Redirect::to('admin/widgets/edit/'.$widgetId)->with('errors', array("You must specify a widget name."));
		}
	}

	public function create($pageId) {
		$rules = array(
			'widget_name' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if($validation->passes()) {
			//$page = $this->site->page()->find($pageId);
			$page = $this->site->page()->with(array('widgets' => function($query) {
				$query->where('name', '=', Input::get('widget_name'));
			}))->where('id', '=', $pageId)->first();

			if(!$page->widgets) {
				$widget = new Widgets();
				$widget->name = Input::get('widget_name');
				$widget->content = Input::get('widget_content');
				$page->widgets()->save($widget);

				$message = 'You have successfully created a new widget.<br/>';
				$message.= 'Please contact your site administrator and have them paste the following code into your page: <br/><br/>';
				$message.= '@yeild("'. Input::get('widget_name') . '")';
				return Redirect::to('admin/widgets')->with('statusMessage', $message);
			}
			else {
				$errors[] = "A widget with the same name already exists for this page.";
			}
		}
		else {
			$errors[] = "You must specify a widget name.";
		}
		return Redirect::to('admin/widgets/add/'.$pageId)->with('errors', $validation->errors->all());
	}

	public function delete($widgetId) {
		$rules = array(
			'delete' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if($validation->passes()) {

			$widget = Widgets::find($widgetId);
			if($widget) {
				$widget->delete();
				return Redirect::to('admin/widgets')->with('statusMessage', 'The widget ' . $widget->name . ' has been deleted.');
			}
			else {
				return Redirect::to('/admin/widgets')->with('statusMessage', 'The widget you attempted to edit does not exist');
			}
		}
		else {
			return Redirect::to('/admin/widgets')->with('statusMessage', 'The widget ' . $widget->name . ' was not deleted.');
		}
	}
}