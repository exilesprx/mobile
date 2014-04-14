
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

			{{Form::open(array('url' => 'admin/password/reset', 'method' => 'PUT'))}}
				{{Form::label('email', 'Email')}}
				{{Form::input('text', 'email')}}
				<br/>

				{{Form::label('password', 'Password')}}
				{{Form::input('password', 'password')}}
				<br/>

				{{Form::label('password_confirmation', 'Password Confirmation')}}
				{{Form::input('password', 'password_confirmation')}}

				{{Form::input('hidden', 'token', $token)}}

				{{Form::submit('Update User', array('id' => 'submit'))}}
			{{Form::close()}}
		</div>

		<div style="clear:both"></div>

	</div>
</div>