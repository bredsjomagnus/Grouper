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
				<th colspan='2'>Actions</th>
			</tr>
		</thead>
		<tbody>
		@foreach($members as $id => $membername)
			<tr>
				<td>{{$membername}}</t>
				<td><a href="#">rename</a>,&nbsp;&nbsp;</td>
				<td> <a href="#"> delete</a></td>
			</tr>
		@endforeach
			<tr style='height: 40px'>
				<td colspan='3'>+ Add member</td>
			</tr>
		</tbody>
	</table>

@endsection
