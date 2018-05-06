@extends('layouts.standard')

@section('title', 'Add choice')

@section('content')

<h1>ADD CHOICES</h1>

<table width="600px">
	<form action="{{ route('addchoicesconfirm') }}" method="post" enctype="multipart/form-data">
		@csrf
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

@if(isset($choices))
	<div class="row">
		<h4>IMPORT CHOICES</h4>
	</div>
	<table>
	@foreach($choices as $choice)
		<tr>
			<td>{{htmlspecialchars($choice)}}</td>
		</tr>
	@endforeach
	</table>
	<form action="{{ route('addchoicesprocess') }}" method="post">
		@csrf
		@foreach($choices as $choice)
			<input type="hidden" name="choices[]" value="{{$choice}}" />
		@endforeach
		<br>
		<br>
		<input type="submit" name="newchoices" value="Add choices">
	</form>
@endif

@endsection
