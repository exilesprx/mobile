
	<div id="content-wrapper">

		<div id="content" class="site list">

			@if($sites)
				@foreach($sites as $site)

			<div>
				<span class="list-heading">Title</span>
				<span>
					{{HTML::link('/admin/sites/edit/'. $site->id, $site->title)}}
				</span>
			</div>
			<div>
				<span class="list-heading">Domain</span>
				<span><a href="{{$site->domain}}">{{$site->domain}}</a></span>
			</div>
			<div>
				<span class="list-heading">Home Folder</span>
				<span>{{$site->home_folder}}</span>
			</div>
			<div>
				<span class="list-heading">Created On</span>
				<span>{{$site->timestampe}}</span>
			</div>

			<br/><br/>

				@endforeach
			@endif
		</div>

		<div style="clear:both"></div>

		{{HTML::link('/admin/sites/add', 'Create a New Site', array('class' => 'button'))}}

	</div>
</div>