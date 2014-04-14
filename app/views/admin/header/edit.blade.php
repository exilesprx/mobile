
	<div id="content-wrapper">

		<div id="content" class="user edit">
			<div id="errors">
				@if(!empty($this->required))
					@foreach($this->required as $error)
						{{$error}}
						<br/>
					@endforeach
				@endif
			</div>

			<h3>NOTE: Leave empty if you would like to use the default header.</h3>

			{{Form::open(array('url' => 'admin/sites/header/edit', 'method' => 'PUT'))}}

				{{Form::label('header_content', 'Header Content')}}
				<textarea name="header_content">{{$header->content}}</textarea>

				{{Form::submit('Update Header', array('id' => 'submit'))}}
			{{Form::close()}}

		</div>

		<div style="clear:both"></div>

	</div>
</div>