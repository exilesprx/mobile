		<div id="topbar">
			<ul>
			@if(!in_array(Request::segment(2), array('login', null, 'password')))

				<li class="{{(strpos(URL::current(), '/welcome') !== false ? 'active' : '')}}" >
					{{HTML::link('/admin/welcome', 'Home')}}
				</li>
				
				@section('nav_options')
				@show

				<li class="{{(strpos(URL::current(), '/widgets') !== false ? 'active' : '')}}" >
					{{HTML::link('/admin/widgets', 'Widgets')}}
				</li>

				<li class="{{(strpos(URL::current(), '/help') !== false ? 'active' : '')}}" >
					{{HTML::link('/admin/help', 'Help')}}
				</li>
			@endif
			</ul>
			<div style="clear: both"></div>
		</div>