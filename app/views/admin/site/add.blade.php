
	<div id="content-wrapper">

		<div id="content" class="user add">
			<div id="errors">
				@if($this->required)
					@foreach ($this->required as $error)
						{{$error}}
						<br/>
					@endforeach
				@endif
			</div>
			{{Form::open('admin/sites/create', 'PUT')}}
				{{Form::label('domain', 'Domain')}}
				{{Form::text('domain', Input::old('domain'))}}
				<br/>
				
				{{Form::label('title', 'Title')}}
				{{Form::text('title', Input::old('title'))}}
				<br/>

				{{Form::file('logo')}}
				<br/>
				
				{{Form::label('description', 'SEO Description')}}
				{{Form::text('description', Input::old('description'))}}
				<br/>

				{{Form::label('keywords', 'SEO Keywords')}}
				{{Form::text('keywords', Input::old('keywords'))}}
				<br/>

				{{Form::submit('Create Site', array('id' => 'submit'))}}
			{{Form::close()}}
		</div>

		<div style="clear:both"></div>
	</div>
</div>