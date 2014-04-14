	
	<div id="content-wrapper">
		
		<div id="content" class="page-delete">

			{{Form::open('admin/sites/delete/' . $this->site->id, 'PUT')}}
				<div>Are you sure you want to delete the <strong>{{$this->site->title}}</strong> site?</div>
				<div>
					{{Form::hidden('delete', 'delete')}}
					{{Form::submit('Yes', array('id' => 'yes'))}}

					{{HTML::link('/admin/sites', 'No', array('class' => 'button'))}}
				</div>
			{{Form::close()}}
		</div>

		<div style="clear:both"></div>
	</div>
</div>