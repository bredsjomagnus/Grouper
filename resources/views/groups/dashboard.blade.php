@extends('layouts.standard')

@section('title', 'Groups')

@section('content')
	<a href="{{ route('groupsdashboard')}}">Dashboard</a>
	<a href="{{ route('addgroup')}}">Add group</a>
	<h1>GROUPS</h1>
	<ul class='group-list'>


		@foreach($groups as $group)
			<?php
				$editurl = url('/groups/edit/'.$group->id);
			?>
			<li class='group-list-item'>
				<a href="{{ $editurl }}">
			<div class="group-paneldiv">
				<center>{{$group->groupname}}</center>
			</div>
			</a>
			</li>
		@endforeach
		</ul>
@endsection
