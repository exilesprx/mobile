
	<div id="content-wrapper">

		<div id="content" class="user add">
			<div id="errors">
				@if(!empty($this->required))
					@foreach($this->required as $error)
						{{$error}}
						<br/>
					@endforeach
				@endif
			</div>
			{{Form::open('admin/users/create', 'PUT')}}
				{{Form::label('username', 'Username')}}
				{{Form::text('username', Input::get('username'))}}
				<br/>
				
				{{Form::label('user_email', 'Email')}}
				{{Form::text('user_email', Input::get('user_email'))}}
				<br/>

				{{Form::label('user_password', 'Password')}}
				{{Form::text('user_password', Input::get('user_password'))}}
				<br/>

				{{Form::label('site', 'Select the user\'s site')}}<br/>
				{{Form::select('site', $sites, 'Select a site')}}
				<br/>
				<br/>

				{{Form::checkbox('role[]', 'superadmin', false, array('id' => 'admin_role'))}}
				{{Form::label('admin_role', 'Super Admin')}}
				<br/>
				
				{{Form::checkbox('role[]', 'admin', false, array('id' => 'admin_role'))}}
				{{Form::label('admin_role', 'Admin')}}
				<br/>
				
				{{Form::checkbox('role[]', 'user', false, array('id' => 'user_role'))}}
				{{Form::label('user_role', 'User')}}
				<br/>

				<div>
					Super Admin = Users, Sites
					<br/>
					Admin = Pages, Site Settings, Navigation
					<br/>
					User = Widgets
					<br/><br/>
				</div>
				<br/><br/>

				{{Form::submit('Create User', array('id' => 'submit'))}}
			{{Form::close()}}
		</div>

		<div style="clear:both"></div>
	</div>
</div>