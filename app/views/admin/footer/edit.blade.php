
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

			<h3>NOTE: Leave empty if you would like to use the default footer.</h3>

			{{Form::open(array('url' => 'admin/sites/footer/edit', 'method' => 'PUT'))}}

				{{Form::label('footer_content', 'Footer Content')}}
				<textarea name="footer_content">{{$footer->content}}</textarea>

				{{Form::submit('Update Footer', array('id' => 'submit'))}}
			{{Form::close()}}

		</div>

		<div style="clear:both"></div>

	</div>
</div>