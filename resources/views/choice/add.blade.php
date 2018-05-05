@extends('layouts.standard')

@section('title', 'Add choice')

@section('content')

<h1>ADD CHOICES</h1>

<table width="600px">
	<form action="{{ route('addgroupconfirm') }}" method="post" enctype="multipart/form-data">
		@csrf
		<!-- <tr>
			<td width="20%">Group name</td>
			<td width="80%"><input type="text" name="groupname" id="groupname" placeholder='Enter Groupname' onkeyup="groupnameinput()" /></td>
		</tr> -->
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

@endsection
