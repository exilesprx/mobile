@section('nav_options')
@parent
				<li class="{{(strpos(URL::current(), '/page') !== false ? 'active' : '')}}" >
					{{HTML::link('/admin/page', 'Pages')}}
				</li>
				
				<li class="{{(strpos(URL::current(), '/navigation') !== false ? 'active' : '')}}" >
					{{HTML::link('/admin/navigation', 'Navigation')}}
				</li>
@endsection