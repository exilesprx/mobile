<?php
namespace Admin;
use View;
use Session;
use Sites;
use Users;
use PasswordTokens;
use AccountLockouts;
use Input;
use Request;
use Redirect;
use Auth;
use Validator;
use URL;
use App;
use Mail;
use Hash;

class UserController extends IndexController {
	private $maxLoginAttempts = 3;
	private $accountLockoutTime = '+1 hour';

	public function __construct() {
		parent::__construct();
	}

	public function indexView() {
		$this->layout->page = View::make('admin.user.view');
		$this->layout->page->users = Users::all();
	}

	public function addView() {
		$this->layout->page = View::make('admin.user.add');
		$this->layout->page->required = Session::get('errors');
		$this->layout->page->sites = Sites::lists('title', 'id');
	}

	public function editView($userId) {
		$this->layout->page = View::make('admin.user.edit');
		$this->layout->page->currentUser = Users::find($userId);
		$this->layout->page->required = Session::get('errors');
		$this->layout->page->sites = Sites::lists('title', 'id');
	}

	public function deleteView($userId) {
		$this->layout->page = View::make('admin.user.delete');
		$this->layout->page->currentUser = Users::find($userId);
		$this->layout->page->required = Session::get('errors');
	}

	public function rulesView($userId) {
		$this->layout->page = View::make('admin.user.rules');
		$this->layout->page->currentUser = Users::find($userId);
		$this->layout->page->required = Session::get('errors');
	}

	public function login() {
		$user = Users::where('username', '=', Input::get('username'))->first();

		if(!$user) {
			return Redirect::to('/admin');
		}
		
		if(!$user->has_role('superadmin')) {

			$site = Sites::where('domain', '=', Request::root())->first();
			if(!$site) {
				return Redirect::to('admin');
			}

			$user = $site->user()->where('username', '=', Input::get('username'))->first();
			if(!$user) {
				return Redirect::to('admin')->with('loginError', 'Invalid Username or Password!');
			}
			
		}

		sleep(5);

		if($accountLockout = AccountLockouts::where('user_id', '=', $user->id)->where('ip', '=', Request::server('REMOTE_ADDR'))->first()) {

			$lockoutDate = date('Y-m-d H:i:s', strtotime($this->accountLockoutTime, strtotime($accountLockout->created_at)));
			
			//if the attempts are more than 3 and the locked out date has not passed, display an error message to the user.
			if($accountLockout->attempts >= $this->maxLoginAttempts && date('Y-m-d H:i:s') <= $lockoutDate) {

				//increase attempts even when locked at to determine is a bot keeps hitting the form
				$accountLockout->attempts+= 1;
				$accountLockout->save();
				return Redirect::to('admin')->with('loginError', 'Sorry, you\'ve attempted to login to many times with invalid information. Please retry later.');
			}
			//if the attempts are more than 3 and the locked out date has passed, delete the record and create a new one.
			else if($accountLockout->attempts >= $this->maxLoginAttempts && date('Y-m-d H:i:s') >= $lockoutDate) {

				$accountLockout->delete();
				$accountLockout = new AccountLockouts();
				$accountLockout->user_id = $user->id;
				//$accountLockout->created_at = 'NOW'; //date('c');
				$accountLockout->ip = Request::server('REMOTE_ADDR');
			}
		}
		else {
			$accountLockout = new AccountLockouts();
			$accountLockout->user_id = $user->id;
			//$accountLockout->created_at = 'NOW'; //date('c');
			$accountLockout->ip = Request::server('REMOTE_ADDR');
		}

		$userdata = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		);
		
		if(Auth::attempt($userdata, true)) {
			$user = Auth::user();
			$user->last_login = date('c');
			$user->save();

			$accountLockout->delete();

			return Redirect::intended('admin/welcome');
		}
		else {
			$accountLockout->attempts+= 1;
			$accountLockout->save();
			return Redirect::to('admin')->with('loginError', 'Invalid Login');
		}
	}

	public function logout() {
		if(Auth::check()) {
			Auth::logout();
		}
		return Redirect::to('admin');
	}

	

	public function create() {
		$rules = array(
			'username' => 'required|unique:users,username',
			'user_email' => 'required|email|unique:users,email',
			'password' => 'required',
			'site' => 'required'
		);

		$validation = Validator::make(Input::all(), $rules);

		if($validation->passes()) {
			$site = Sites::find(Input::get('site'));
			$user = new Users();
			$user->username = Input::get('username');
			$user->email = Input::get('user_email');
			$user->password = Hash::make(Input::get('user_password'));
			$user->save();

			$roleIds = Role::whereIn('name', Input::get('role'))->lists('id');
			$user->roles()->sync($roleIds);
			$site->user()->insert($user);

			if($user->has_role('user')) {
				return Redirect::to('/admin/users/edit/' . $user->id)->with('statusMessage', 'Please update the users wigets rules.');
			}
			else {
				return Redirect::to('/admin/welcome')->with('statusMessage', 'You have successfully created a new user.');
			}
		}
		else {
			return Redirect::to('/admin/users/add')->with('errors', $validation->errors->all());
		}
	}

	public function update($userId) {

		$rules = array(
			'username' => 'required|unique:users,username',
			'user_email' => 'required',
			'site' => 'required'
		);

		$validation = Validator::make(Input::all(), $rules);

		if($validation->passes()) {
			$user = Users::find($userId);
			$site = Sites::find(Input::get('site'));

			if($user) {
				$user->username = Input::get('username');
				$user->email = Input::get('user_email');
				$user->save();

				$roleIds = Role::whereIn('name', Input::get('role'))->take(5)->lists('id');
				$user->roles()->sync($roleIds);
				$site->user()->insert($user);

				return Redirect::to('/admin/users')->with('statusMessage', 'You have successfully updated the user ' . $user->username . '.');
			}
			else {
				return Redirect::to('admin/users')->with('statusMessage', 'User does not exist!');
			}
		}
		else {
			return Redirect::to('/admin/users/edit/' . $userId)->with('errors', $validation->errors->all());
		}
	}

	public function updateRules($userId) {
		$user = Users::find($userId);

		if(!$user) {
			return Redirect::to('/admin/users/rules/' . $userId)->with('errors', 'User does not exist!');
		}

		$rules = Input::get('rule') ? Input::get('rule') : array(0);
		$userRules = Rule::whereIn('name', $rules)->take(5)->lists('id');

		if($userRules) {
			$user->rules()->sync($userRules);
		}
		else {
			$user->rules()->delete();
		}

		return Redirect::to('/admin/users/edit/' . $userId)->with('statusMessage', 'You have successfully update the rules of user ' . $user->username . '.');
	}

	public function delete($userId) {
		$user = Users::find($userId);

		$rules = array(
			'delete' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if($validation->passes() && $user) {

			$user->roles()->delete();
			$user->rules()->delete();
			$user->delete();
			return Redirect::to('/admin/users')->with('statusMessage', 'You have successfully deleted the user: ' . $user->username);
		}
		else {
			return Redirect::to('/admin/users')->with('statusMessage', 'The user ' . $user->username . ' was not deleted.');
		}
		
	}

	public function resetView($token) {
		$this->layout->page = View::make('admin.user.reset')->with('token', $token);
	}

	public function reset() {
		$rules = array(
			'email' => 'required',
			'password' => 'required|confirmed',
			'password_confirmation' => 'required',
			'token' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails()) {
			return Redirect::to('/admin/password/reset/' . Input::get('token'))->with('required', $validation->errors->all());
		}

		$user = Users::with(array('passwordTokens' => function($query) {
			$query->where('token', '=', Input::get('token'));
		}))->where('email', '=', Input::get('email'))->first();
		
		if(!$user) {
			return Redirect::to('error.500');
		}
		else {
			$user->passwordTokens()->delete();
		}
		
		$user->password = Hash::make(Input::get('password'));
		$user->save();
		return Redirect::to('/admin');
	}

	public function forgetPasswordView() {
		$this->layout->page = View::make('admin.user.forgot');
		$this->layout->page->required = Session::get('errors');
	}

	public function forgetPassword() {
		$rules = array(
			'email' => 'required|email'
		);
		$validation = Validator::make(Input::all(), $rules);
		
		if($validation->fails()) {
			return Redirect::to('/admin/password/forgot')->with('errors', $validation->errors->all());
		}

		$user = Users::where('email', '=', Input::get('email'))->first();

		//if user doesnt exist continue anyway
		if($user) {

			//if the token exist, create a new one
			$token = PasswordTokens::where('token', '=', Session::token())->first();
			if(!$token) {
				$token = new PasswordTokens();
				$token->token = Session::token();
				$token->user_id = $user->id;
				$token->save();
			}

			//TODO: fix
			$data = array('username' => $user->username, 'resetLink' => URL::to('/admin/password/reset/' . $token->token));
			Mail::send(array('html' => 'emails.passwordrestore'), $data, function($message) {
				$message->from('voitmaster300@aol.com', 'Laravel');
				$message->to('campbell.andrew86@yahoo.com')->subject('test');
			});
		}

		return Redirect::to('/admin')->with('statusMessage', 'You will recieve an email shortly to reset your password.');
	}
}