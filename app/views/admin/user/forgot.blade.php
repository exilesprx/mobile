
	<div id="content-wrapper">

		<div id="content" class="user reset">
			<div id="errors">
				@if(!empty($this->required))
					@foreach($this->required as $error)
						{{$error}}
						<br/>
					@endforeach
				@endif
			</div>

			<br/>
			<div>
				Enter your email address below.<br/>
				Your will reviece an email containing a link to reset your password.
			</div>
			<br/>

			{{Form::open(array('url' => 'admin/password/forgot', 'method' => 'PUT'))}}
				{{Form::label('email', 'Email')}}
				{{Form::input('text', 'email')}}
				<br/>

				{{Form::submit('Submit', array('id' => 'submit'))}}
			{{Form::close()}}
		</div>

		<div style="clear:both"></div>

	</div>
</div>