	
	<div id="content-wrapper">
		
		<div id="content" class="page-delete">

			@if(!empty($current_page) && $current_page->page_url != 'index')
			{{Form::open(array('url' => 'admin/page/delete/' . $current_page->id, 'method' => 'PUT'))}}
				<div>Are you sure you want to delete the <strong>{{$current_page->page_name}}</strong> page from your site?</div>
				<div>
					{{Form::hidden('delete', 'delete')}}
					{{Form::submit('Yes', array('id' => 'yes'))}}

					{{HTML::link('/admin/page/edit/' . $current_page->id, 'No', array('class' => 'button'))}}
				</div>
			{{Form::close()}}

			@elseif(!empty($current_page) && $current_page->page_url == 'index')
				<div>You cannot delete age from your site. You can only modifiy its conent.</div>
				{{HTML::link('/admin/page/edit/' . $current_page->id, 'Go Back', array('id' => 'back-button'))}}

			@else
				{{Redirect::to('admin/welcome')}}
			@endif
		</div>

		<div style="clear:both"></div>
	</div>
</div>