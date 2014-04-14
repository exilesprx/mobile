	
	<div id="content-wrapper" class="edit">
		
		<div id="sidebar">
			<ul>
				@foreach($pages as $page)
					<li class="page {{Request::segment(4) == $page->id ? 'active' : ''}}">
						{{HTML::link('/admin/page/edit/' . $page->id, $page->page_name)}}
					</li>
				@endforeach
				<li class="page add">
					{{HTML::link('/admin/page/add', '+Add Page')}}
				</li>
				@if($current_page->page_url != 'index') 
				<li class="page delete">
					{{HTML::link('/admin/page/delete/' . $current_page->id, '-Delete Page')}}
				</li>
				@endif
			</ul>
		</div>
		<div id="content">
			<div id="errors">
				@if(!empty($this->required))
					@foreach($this->required as $error)
						{{$error}}
						<br/>
					@endforeach
				@endif
			</div>
			{{Form::open(array('url' => 'admin/page/update/' . $current_page->id, 'method' => 'PUT', 'files' => true))}}
				{{Form::label('page_name', 'Page Name')}}
				{{Form::text('page_name', $current_page->page_name)}}
				<br/>
				
				@if($current_page->page_url == 'index')
					{{Form::label('page_url', 'Page URL', array('style' => 'display:none;'))}}
					{{Form::hidden('page_url', $current_page->page_url)}}
				@else
					{{Form::label('page_url', 'Page URL')}}
					{{Form::text('page_url', $current_page->page_url)}}
				<br/>
				@endif

				{{Form::label('page_image', 'Page Image')}}
				@if(!empty($current_page->page_image))
					{{Form::text('old_image', 'Current Image - ' . $current_page->page_image, array('readonly' => 'readyonly', 'id' => 'old-image'))}}
					<span id="close-image">
						{{HTML::image('admin/images/icons/delete.png', 'page logo', array('height' => 20, 'width' => 'auto'))}}
					</span>
				@endif

				{{Form::file('page_image')}}
				<br/>

				{{Form::label('page_content', 'Page Content')}}
				<textarea name="page_content">{{$current_page->page_content}}</textarea>
				<br/>

				<input type="submit" id="submit" name="submit" value="Save" />
			{{Form::close()}}
			<!--<script>
			    CKEDITOR.replace('page_content', {
			    });
			</script>-->

		</div>

		<div style="clear:both"></div>
	</div>
</div>