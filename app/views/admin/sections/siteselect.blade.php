
@section('site.select')
		<div style="clear:both"></div>
		
		{{ Form::open(array('url' => '/admin/sites/change', 'method' => 'PUT')) }}
		{{ Form::select('site', $sites, Session::get('site.id')) }}
		{{ Form::submit('Change Site') }}
		{{ Form::close() }}

		<div style="clear:both"></div>
@yield_section