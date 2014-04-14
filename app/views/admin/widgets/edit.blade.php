
	<div id="content-wrapper">
		

		<div id="content" class="page-add">
			<div id="errors">
				@if(!empty($this->required))
					@foreach($this->required as $error)
						{{$error}}
						 <br/>
					@endforeach
				@endif
			</div>
			{{Form::open('admin/widgets/update/'.$current_widget->id, 'PUT')}}

				@if(Auth::user()->has_role('admin') || Auth::user()->has_role('superadmin'))
					{{Form::label('widget_name', 'Widget Name')}}
					{{Form::text('widget_name', $current_widget->name)}}
					<br/>
				@elseif(Auth::user()->has_role('user'))
					{{Form::hidden('widget_name', $current_widget->name)}}
					<br/>
				@endif

				{{Form::label('widget_content', 'Page Content')}}
				<textarea name="widget_content" placeholder="Insert your widget content here...">
					{{$current_widget->content}}
				</textarea>
				<br/>

				{{Form::submit('Save Widget', array('id' => 'submit'))}}
			{{Form::close()}}
			<script>
			    CKEDITOR.replace('widget_content', {
			    });
			</script>
		</div>

		<div style="clear:both"></div>
	</div>
</div>