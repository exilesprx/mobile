<?php
echo'<?xml version="1.0" encoding="utf-8" ?>';
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{{!empty($site->title) ? $site->title : 'P Mobile'}}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-ico" href="favicon.ico"/>
	{{HTML::style('admin/css/admin.css')}}
	{{ HTML::script("http://code.jquery.com/jquery-1.9.1.min.js") }}
	{{ HTML::script("admin/js/main.js") }}
	@section('html_head')
	@show
</head>


<body>
<div id="header">
	<a href="{{URL::to('/')}}">
		<img id="logo" src="{{URL::asset('admin/images/admin-logo.png')}}" />
	</a>
	<div style="position: absolute; top: 10px; right: 20px;">
		@if(Auth::check())
			<h2 id="username-msg">Welcome - {{Auth::user()->username}}</h2>
			<h2 id="site-msg">{{$site->title}}</h2>
			{{Form::open(array('url' => '/admin/logout', 'method' => 'PUT'), array('id' => 'logout'))}}
				{{Form::submit('Logout', array('id' => 'logout'))}}
			{{Form::close()}}
		@endif
		<div style="clear: both"></div>
	</div>
</div>

	<div id="wrapper">
		@if(Session::has('statusMessage'))
			<div id="status-message">
				{{Session::get('statusMessage')}}
			</div>
		@endif

		{{$topnav}}

		{{$page}}
		
	<div id="footer">
		
	</div>
</body>
</html>