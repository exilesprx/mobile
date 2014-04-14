	
	<div id="content-wrapper">
		
		<div id="content" class="page-delete">

			@if(!empty($current_widget))
			{{Form::open('admin/widgets/delete/'.$current_widget->id, 'POST')}}
				<div>Are you sure you want to delete the <strong>{{$current_widget->name}}</strong> widget from your site?</div>
				<div>
					{{Form::hidden('delete', 'delete')}}
					{{Form::submit('Yes', array('id' => 'yes'))}}

					{{HTML::link('/admin/widgets', 'No', array('class' => 'button'))}}
				</div>
			{{Form::close()}}

			@endif
		</div>

		<div style="clear:both"></div>
	</div>
</div>