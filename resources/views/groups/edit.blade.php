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
				<!-- <td><div id='firstname_#{result[index]._id}' onclick="toForm('firstname_#{result[index]._id}', '#{result[index]._id}', '#{result[index].firstname}', 'firstname')">#{result[index].firstname}</div></td> -->
				<td><div id='firstname_{{$id}}' onclick="toForm('firstname_{{$id}}', {{$id}}, {{$group->id}}, '{{$membername}}', 'membername')">{{$membername}}</div></td>
				<!-- <td>{{$membername}}</td> -->
				<td><a href="#">rename</a>,&nbsp;&nbsp;</td>
				<td> <a href="#"> delete</a></td>
			</tr>
		@endforeach
			<tr style='height: 40px'>
				<td colspan='1'><div id='addmember' onclick="toFormAdd({{$group->id}})">+ Add member</div></td>
			</tr>
		</tbody>
	</table>

@endsection
