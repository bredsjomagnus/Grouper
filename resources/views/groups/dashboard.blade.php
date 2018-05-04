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
				<a class='paneldivlink' href="{{ $editurl }}">
			<div class="group-paneldiv">
				<center>
					<span>{{$group->groupname}}</span><br>
					@if($groupsizes[$counter]->groupid == $group->id)
						<span class='group-panelinfo'>Members: {{$groupsizes[$counter]->numberofmembers}}</span>
					@endif
				</center>
			</div>
			</a>
			</li>
			<?php $counter++; ?>
		@endforeach
		</ul>
@endsection
