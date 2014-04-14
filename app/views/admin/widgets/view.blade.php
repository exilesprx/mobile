
	<div id="content-wrapper">
		

		<div id="content" class="widget-edit">
			<div id="errors">
				@if(!empty($this->required))
					@foreach($this->required as $error)
						{{$error}}
						<br/>
					@endforeach
				@endif
			</div>

			<h3>Create/Edit your site widgets below.</h3>

			<div>Each existing page can have up to 5 widgets.</div>

			<br/><br/>

			@if(empty($pages))
				<div>You must have pages before you can create a widget!</div>
			@endif
			
			@foreach($pages as $page)
				<div class="page">
					<div class="page-name">{{$page->page_name}}</div>
					<ul>
						@foreach($page->widgets as $widget)
							<li>
								<span class="widget-name">-{{$widget->name}}</span>

								@if(Auth::user()->has_rule('widget.edit') || Auth::user()->has_role('admin') || Auth::user()->has_role('superadmin'))
									{{HTML::image_link('/admin/widgets/edit/' . $widget->id, '/bundles/admin/images/icons/edit-widget.png', 'Edit', array('image' => array('height' => 30, 'width' => 'auto')))}}
								@endif

								@if(Auth::user()->has_rule('widget.delete') || Auth::user()->has_role('admin') || Auth::user()->has_role('superadmin'))
									{{HTML::image_link('/admin/widgets/delete/' . $widget->id, '/bundles/admin/images/icons/delete-widget.png', 'Delete', array('image' => array('height' => 30, 'width' => 'auto')))}}
								@endif

							</li>
						@endforeach
					</ul>

					@if( (count($page->widgets) < 5 && Auth::user()->has_rule('widget.create'))  || Auth::user()->has_role('admin') || Auth::user()->has_role('superadmin'))
						{{HTML::link('/admin/widgets/add/' . $page->id, 'Add Widget', array('class' => 'button'))}}
						<br/><br/>
					@endif
				</div>
				
				<br/>
			@endforeach
		</div>

		<div style="clear:both"></div>
	</div>
</div>