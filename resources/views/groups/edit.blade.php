@extends('layouts.standard')

@section('title', 'Groups')

@section('content')
	<a href="{{ route('groupsdashboard')}}">Dashboard</a>
	<a href="{{ route('addgroup')}}">Add group</a>

	<h1>EDIT {{$group->groupname}}</h1>
	<table>
		<thead>
			<tr>
				<th width='300px'>Member</th>
				<th colspan='1'>Actions</th>
			</tr>
		</thead>
		<tbody>
		@foreach($members as $id => $membername)
			<?php
			$deleteurl = url('/members/delete/'.$id.'?groupid='.$group->id);
			?>
			<tr>
				<!-- <td><div id='firstname_#{result[index]._id}' onclick="toForm('firstname_#{result[index]._id}', '#{result[index]._id}', '#{result[index].firstname}', 'firstname')">#{result[index].firstname}</div></td> -->
				<td><div id='firstname_{{$id}}' onclick="toForm('firstname_{{$id}}', {{$id}}, {{$group->id}}, '{{$membername}}', 'membername')">{{$membername}}</div></td>
				<!-- <td>{{$membername}}</td> -->
				<td> <a href="{{$deleteurl}}" onclick="return confirm('Are you sure you want to delete this item?');"> delete</a></td>
			</tr>
		@endforeach
			<tr style='height: 40px'>
				<td colspan='1'><div id='addmember' onclick="toFormAdd({{$group->id}})">+ Add member</div></td>
			</tr>
		</tbody>
	</table>
@endsection
