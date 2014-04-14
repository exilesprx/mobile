<?php

class BaseController extends Controller {
	public $layout = 'default.layout';
	protected $site;
	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

	public function __construct() {
	}

	public function initialize() {
		$validDomains = array();
		$validDomains[] = preg_replace(array('/http:\/\//', '/http:\/\/www\./'), 'http://www.', Request::root());
		$validDomains[] = preg_replace(array('/http:\/\//', '/http:\/\/www\./'), 'http://', Request::root());
		
		$this->site = Sites::whereIn('domain', $validDomains)->first();


		if(!empty($this->site->domain)) {
			Config::set('application.url', $this->site->domain);
		}
		if(!empty($this->site->home_folder)) {
			Config::set('application.asset_url', Request::root() . '/' . $this->site->home_folder);
		}
	}

}