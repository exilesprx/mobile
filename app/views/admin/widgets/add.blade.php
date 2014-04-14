	@section('html_head')
		{{ HTML::style('http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js') }}
		{{ HTML::script('ckeditor/ckeditor.js') }}
		{{ HTML::script('js/main.js') }}
	@show
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
			{{Form::open(array('url' => 'admin/widgets/create/' . $current_page->id, 'method' => 'PUT')) }}
				{{Form::label('widget_name', 'Widget Name')}}
				{{Form::text('widget_name', Input::get('widget_name'))}}
				<br/>

				{{Form::label('widget_content', 'Page Content')}}
				<textarea name="widget_content" placeholder="Insert your widget content here...">
					{{Input::has('widget_content') ? Input::get('widget_content') : ''}}
				</textarea>
				<br/>

				{{Form::submit('Add Widget', array('id' => 'submit'))}}
			{{Form::close()}}
			<script>
			    CKEDITOR.replace('widget_content', {
			    });
			</script>
		</div>

		<div style="clear:both"></div>
	</div>
</div>