{{'<?xml version="1.0" encoding="utf-8" ?>'}}
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	@section('htmlhead')
		@if(!empty($htmlhead))
			{{$htmlhead}}
		@endif
	@show
</head>


<body>
@section('body')
	<div id="wrapper" data-role="page">
		<div id="header" data-role="header">
			<h1>
				<a href="{{Request::root()}}">
					{{HTML::image($site->home_folder. '/' . $site->logo, 'Logo', array('id' => 'logo', 'height' => '25px', 'width' => 'auto'))}}
				</a>
				W3Innovations.net
			</h1>
		</div>

		{{$page}}

		<div id="footer" data-role="footer">
		@section('footer')
			@if(!empty($footer))
				{{$footer}}
			@endif
		@show
		</div>
	</div>
@show
</body>
</html>