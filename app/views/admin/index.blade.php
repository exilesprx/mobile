	
	<div id="content-wrapper">
		{{Form::open(array('url' => '/admin/login', 'method' => 'PUT'), array('id' => 'loginbox'))}}
			<div id="errors">{{!empty($error) ? $error : ''}}</div>
			{{Form::text('username', null, array('id' => 'username', 'placeholder' => 'Username'))}}
			{{Form::password('password', array('id' => 'password', 'placeholder' => 'Password'))}}
			{{Form::submit('Login', array('id' => 'submit'))}}
			{{HTML::link('/admin/password/forgot', 'Forgot Password?', array('id' => 'forgot-password'))}}
			{{Form::token()}}
			<div style="clear:both"></div>
		{{Form::close()}}
	</div>
</div>