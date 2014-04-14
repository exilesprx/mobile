	
	<div id="content-wrapper">
		
		<div id="content" class="page-delete">

			{{Form::open('admin/users/delete/' . $currentUser->id, 'PUT')}}
				<div>Are you sure you want to delete the user <strong>{{$currentUser->username}}</strong> ?</div>
				<div>
					{{Form::hidden('delete', 'delete')}}
					{{Form::submit('Yes', array('id' => 'yes'))}}

					{{HTML::link('/admin/users/edit/' . $currentUser->id, 'No', array('class' => 'button'))}}
				</div>
			{{Form::close()}}
		</div>

		<div style="clear:both"></div>
	</div>
</div>