
	<div id="content-wrapper" class="welcome">
		

		<div id="content">
			<h3>Edit you site settings below.</h3>
			<br/>

			{{Form::open(array('url' => 'admin/sites/update/' . $site->id, 'method' => 'PUT', 'files' => true))}}

				{{Form::label('domain', 'Domain')}}
				{{Form::text('domain', $site->domain)}}
				<br/>
				
				{{Form::label('title', 'Title')}}
				{{Form::text('title', $site->title)}}
				<br/>

				{{Form::label('logo', 'Logo')}}
				@if($site->logo)
					{{Form::text('old_logo', $site->logo, array('id' => 'old_logo', 'readonly' => 'readonly'))}}
					<span id="close-image">
						{{HTML::image('bundles/admin/images/icons/delete.png', 'Logo',array('height' => 20, 'width' => 'auto'))}}
					</span>
				@endif
				{{Form::file('logo')}}
				<br/>
				
				{{Form::label('description', 'SEO Description')}}
				{{Form::text('description', $site->description)}}
				<br/>

				{{Form::label('keywords', 'SEO Keywords')}}
				{{Form::text('keywords', $site->keywords)}}
				<br/>

				{{Form::submit('Save', array('id' => 'submit'))}}
			{{Form::close()}}

			<br/>
			{{HTML::link('/admin/sites/delete/' . $site->id, 'Delete Site', array('class' => 'button delete'))}}
			<br/>
			
		</div>

		<div style="clear:both"></div>
	</div>
</div>