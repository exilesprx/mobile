	
	<div id="content-wrapper" class="edit">
		
		<div id="sidebar">
			<ul>
				<li class="page">
					{{HTML::link('/admin/sites/header/edit', 'Site Header')}}
				</li>
				<li class="page">
					{{HTML::link('/admin/sites/footer/edit', 'Site Footer')}}
				</li>
				@foreach($pages as $page)
					<li class="page {{Request::segment(4) == $page->id ? 'active' : ''}}">
						{{HTML::link('/admin/page/edit/' . $page->id, $page->page_name)}}
					</li>
				@endforeach
				<li class="page add">
					{{HTML::link('/admin/page/add', '+Add Page')}}
				</li>
			</ul>
		</div>
		<div id="content">

			//TODO: Intro on how to use the admin system to edit pages.
			<br/><br/>
			Hello and welcome to our tutorial....
		</div>

		<div style="clear:both"></div>
	</div>
</div>