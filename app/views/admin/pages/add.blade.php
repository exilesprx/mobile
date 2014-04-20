
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
			{{Form::open(array('url' => 'admin/page/create', 'method' => 'PUT', 'files' => true))}}

				{{Form::label('page_name', 'Page Name')}}
				{{Form::text('page_name', Input::get('page_name'))}}
				<br/>
				
				{{Form::label('page_url', 'Page URL')}}
				{{Form::text('page_url', Input::get('page_url'))}}
				<br/>

				{{Form::label('page_image', 'Page Image')}}
				{{Form::file('page_image')}}
				<br/>

				{{Form::label('page_content', 'Page Content')}}
				<textarea name="page_content" placeholder="Insert your content here...">
					{{Input::get('page_content')}}
				</textarea>
				<br/>

				{{Form::submit('Add Page', array('id' => 'submit'))}}
			{{Form::close()}}
			<!--<script>
			    CKEDITOR.replace('page_content', {
			    });
			</script>-->
		</div>

		<div style="clear:both"></div>
	</div>
</div>