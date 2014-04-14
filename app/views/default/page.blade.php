<div id="content-wrapper" data-role="content">

	<a href="" data-rel="back" data-theme="a" data-role="button" data-inline="true" data-icon="arrow-l" data-iconpos="left" data-transition="slide">Back</a>
	
	@if(!empty($page->page_image))
	<div id="slider">
		@section('page_image')
		<img class="slide" src="{{URL::asset($this->page->page_image)}}" />
		@show
	</div>
	@endif

	<div style="padding: 10px; max-width: 320px; margin: auto; text-align: center;">
		@section('page_content')
		{{$page->page_content}}
		@show
	</div>

</div>