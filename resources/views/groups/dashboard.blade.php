@extends('layouts.standard')

@section('title', 'Groups')

@section('content')
	<a href="{{ route('groupsdashboard')}}">Dashboard</a>
	<a href="{{ route('addgroup')}}">Add group</a>
	<h1>GROUPS</h1>
	@foreach($groups as $group)
		<?php
			$editurl = url('/groups/edit/'.$group->id);
		?>
		<a href="{{ $editurl }}">{{$group->groupname}}</a>
	@endforeach
@endsection
