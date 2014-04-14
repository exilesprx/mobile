@section('nav_options')
@parent
				<li class="{{(strpos(URL::current(), '/users') !== false ? 'active' : '')}}" >
					{{HTML::link('/admin/users', 'Users')}}
				</li>

				<li class="{{(strpos(URL::current(), '/sites') !== false ? 'active' : '')}}" >
					{{HTML::link('/admin/sites', 'Sites')}}
				</li>
@endsection