@extends('layouts.standard')

@section('title', 'Groups')

@section('content')

	<a href="{{ route('groupsdashboard')}}">Dashboard</a>
	<a href="{{ route('addgroup')}}">Add group</a>
	<h1>ADD GROUP</h1>
	<table width="600px">
		<form action="{{ route('addgroupconfirm') }}" method="post" enctype="multipart/form-data">
			@csrf
			<tr>
				<td width="20%">Group name</td>
				<td width="80%"><input type="text" name="groupname" id="groupname" placeholder='Enter Groupname' onkeyup="groupnameinput()" /></td>
			</tr>
			<tr>
				<td width="20%">Select file</td>
				<td width="80%"><input type="file" name="file" id="file" onchange="validateFile()" /></td>
			</tr>

			<tr>
				<td></td>
				<td><input type="submit" name="submit" value='Importera' id='importera' /></td>
			</tr>
		</form>
	</table>
	<br>
	@if($groupnameexists)
		<h4 class='text-danger'>GROUP '{{ $groupname }}' ALREADY EXISTS. CHOOSE ANOTHER GROUP NAME</h4>
	@elseif(count($members) > 0)
		<div class="row">
			<h4>CREATE '{{ $groupname }}' WITH THE FOLLOWING MEMBERS</h4>
		</div>
		<table>
		@foreach($members as $member)
			<tr>
				<td>{{htmlspecialchars($member)}}</td>
			</tr>
		@endforeach
		</table>
		<form action="{{ route('addgroupprocess') }}" method="post">
			@csrf
			@foreach($members as $member)
				<input type="hidden" name="members[]" value="{{$member}}" />
			@endforeach
			<input type="hidden" name="groupname" value="{{$groupname}}">
			<br>
			<br>
			<input type="submit" name="newgroup" value="Add group">
		</form>
	@endif


@endsection
