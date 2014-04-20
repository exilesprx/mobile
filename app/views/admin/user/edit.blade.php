
	<div id="content-wrapper">

		<div id="content" class="user edit">
			<div id="errors">
				@if(!empty($this->required))
					@foreach($this->required as $error)
						{{$error}}
						<br/>
					@endforeach
				@endif
			</div>

			{{HTML::link('/admin/users/rules/' . $currentUser->id, 'Update Widget Rules', array('class' => 'button'))}}
			<br/><br/>

			{{Form::open(array('url' => 'admin/users/update/' . $currentUser->id, 'method' => 'PUT'))}}
				{{Form::label('username', 'Username')}}
				{{Form::text('username', $currentUser->username)}}
				<br/>
				
				{{Form::label('user_email', 'Email')}}
				{{Form::text('user_email', $currentUser->email)}}
				<br/>

				{{Form::label('site', 'Select the user\'s site')}}<br/>
				{{Form::select('site', $sites, $currentUser->site_id)}}
				<br/>
				<br/>

				{{Form::checkbox('role[]', 'superadmin', $currentUser->has_role('superadmin'), array('id' => 'admin_role'))}}
				{{Form::label('admin_role', 'Super Admin')}}
				<br/>
				
				{{Form::checkbox('role[]', 'admin', $currentUser->has_role('admin'), array('id' => 'admin_role'))}}
				{{Form::label('admin_role', 'Admin')}}
				<br/>
				
				{{Form::checkbox('role[]', 'user', $currentUser->has_role('user'), array('id' => 'user_role'))}}
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

				{{Form::submit('Update User', array('id' => 'submit'))}}
			{{Form::close()}}

			<br/>
			{{HTML::link('/admin/users/delete/' . $currentUser->id, 'Delete User', array('class' => 'button delete'))}}
		</div>

		<div style="clear:both"></div>

	</div>
</div>