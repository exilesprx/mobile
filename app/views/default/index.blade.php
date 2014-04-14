<div id="content-wrapper" data-role="content">
	
	@if(!empty($page->page_image))
	<div id="slider">
		<img class="slide" src="{{URL::asset($page->page_image)}}" />
	</div>
	@endif

	<div style="text-align: center; font-weight: bold; padding: 3px;">
		@section('page_content')
			{{$page->page_content}}
		@show
	</div>
	
	@section('navigation')
	@if(!empty($navigation))
	<div data-role="controlgroup">
		@foreach($navigation as $nav)
			<a href="{{$nav->page->page_url}}" class="button" data-role="button" data-theme="a" data-icon="arrow-r" data-iconpos="right" data-transition="slide">
				{{$nav->name}}
			</a>
		@endforeach
	</div>
	@endif

	@show
</div>