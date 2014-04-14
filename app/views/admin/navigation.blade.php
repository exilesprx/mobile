
	<div id="content-wrapper">

		<div id="content" class="navigation">
			<h3>Please drag and drop the buttons in the order you would like them to appear on your home page.</h3>
			<br/><br/>
			<h4>Current pages that exist, but are not part of your navigation</h4>
			<div style="font-size: 10pt;">(drap pages into the box below to remove the page from your home page navigation)</div>
			<ul id="sortable1" class="connectedSortable" style="list-style-type: none;">
				@foreach($pages as $page)
				<li class="ui-state-default">
					<span>{{$page->page_name}}</span>
					<input type="hidden" name="{{$page->id}}" id="{{$page->id}}" value="{{$page->id}}" />
				</li>
				@endforeach
				
			</ul>
			
			<hr/>
			
			{{Form::open(array('url' => 'admin/navigation/update', 'method' => 'PUT'))}}
				<h4>Current navigation setup</h4>
				<div style="font-size: 10pt;">(drap a page into the box below to add it to your home page navigation)</div>
				<ul id="sortable2" class="connectedSortable">
				@foreach($navigation as $nav)
				<li class="ui-state-default">
					<span>{{$nav->name}}</span>
					<input type="hidden" name="{{$nav->page_id}}" id="{{$nav->page_id}}" value="{{$nav->page_id}}" />
				</li>
			
				@endforeach
				</ul>

				{{Form::submit('Save', array('id' => 'submit'))}}
			{{Form::close()}}
		</div>
		
		<div style="clear:both"></div>
	</div>
</div>
<script>
$(function() {
	$("#sortable1, #sortable2").sortable({
		connectWith: ".connectedSortable"
	}).disableSelection();
});
</script>