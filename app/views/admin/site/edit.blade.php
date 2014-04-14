
	<div id="content-wrapper" class="welcome">
		

		<div id="content">
			<h3>Edit you site settings below.</h3>
			<br/>

			{{Form::open_for_files('admin/sites/update/' . $this->site->id, 'PUT')}}

				{{Form::label('domain', 'Domain')}}
				{{Form::text('domain', $this->site->domain)}}
				<br/>
				
				{{Form::label('title', 'Title')}}
				{{Form::text('title', $this->site->title)}}
				<br/>

				{{Form::label('logo', 'Logo')}}
				@if($this->site->logo)
					{{Form::text('old_logo', $this->site->logo, array('id' => 'old_logo', 'readonly' => 'readonly'))}}
					<span id="close-image">
						{{HTML::image('bundles/admin/images/icons/delete.png', 'Logo',array('height' => 20, 'width' => 'auto'))}}
					</span>
				@endif
				{{Form::file('logo')}}
				<br/>
				
				{{Form::label('description', 'SEO Description')}}
				{{Form::text('description', $this->site->description)}}
				<br/>

				{{Form::label('keywords', 'SEO Keywords')}}
				{{Form::text('keywords', $this->site->keywords)}}
				<br/>

				{{Form::submit('Save', array('id' => 'submit'))}}
			{{Form::close()}}

			<br/>
			{{HTML::link('/admin/sites/delete/' . $this->site->id, 'Delete Site', array('class' => 'button delete'))}}
			<br/>
			
		</div>

		<div style="clear:both"></div>
	</div>
</div>