				
	<div id="content-wrapper">

		<div id="content" class="user rules">
			<div id="errors">
				@if(!empty($this->required))
					@foreach($this->required as $error)
							{{$error}}
							<br/>
					@endforeach
				@endif
			</div>
			{{Form::open('admin/users/rules/' . $currentUser->id, 'PUT')}}
				<h3>Select the rules that you would like the user to have for widgets.</h3>
				<br/>

				@if(Auth::user->has_rule('superadmin'))
				{{Form::checkbox('rule[]', 'widget.create', $currentUser->has_rule('widget.create'), array('id' => 'create'))}}
				{{Form::label('create', 'User can create widgets')}}
				<br/>
				
				{{Form::checkbox('rule[]', 'widget.edit', $currentUser->has_rule('widget.edit'), array('id' => 'edit'))}}
				{{Form::label('edit', 'User can edit widgets')}}
				<br/>
				
				{{Form::checkbox('rule[]', 'widget.delete', $currentUser->has_rule('widget.delete'), array('id' => 'delete'))}}
				{{Form::label('delete', 'User can delete widgets')}}

				{{Form::submit('Set Widget Rules', array('id' => 'submit'))}}
			{{Form::close()}}
		</div>

		<div style="clear:both"></div>
	</div>
</div>