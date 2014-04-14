
	<div id="content-wrapper">

		<div id="content" class="user list">

			<div>Click on a username to edit the users permissions</div>
			<br/>

			<div id="list-headings">
				<span class="list-heading">Username</span>
				<span class="list-heading">Email Address</span>
				<span class="list-heading">Roles</span>
				<span class="list-heading">Rules</span>
			</div>
			@if($users)
				@foreach($users as $user)

			<div>
				<span>
					{{HTML::link('/admin/users/edit/' . $user->id, $user->username)}}
				</span>
				<span>{{$user->email}}</span>
				<span>
					{{implode(',', $user->getRoleList())}}
				</span>
				<span>
					{{implode(',', $user->getRuleList())}}
				</span>
			</div>

				@endforeach
			@endif
		</div>

		<div style="clear:both"></div>

		{{HTML::link('/admin/users/add', 'Create a New User', array('class' => 'button'))}}
	</div>
</div>