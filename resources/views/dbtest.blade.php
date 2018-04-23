@extends('layouts.standard')

@section('title', 'Welcome')

@section('content')


<div class="flex-center position-ref full-height">
    <h1>DB TESTING</h1>
	@foreach ($groups as $group)
		<p>{{ $group->groupname }}</p>
	@endforeach

</div>

@endsection
