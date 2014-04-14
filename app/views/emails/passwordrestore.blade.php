@extends('emails.templates.one-column')

@section('body')

	<div>Hello {{$username}}, </div>

	<div>You have requested a password change. Please follow the link below to change your password:</div>

	<a href="{{$resetLink}}">Reset Password</a>
@endsection