@extends('layouts.standard')

@section('title', 'Create Event')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')
<h1>CREATE EVENT</h1>
<p class='text-muted'>Every field must be set! The event has to have a name, groups and choices to be created.</p>
<div class="col-md-4">
	<form action="{{ route('createeventprocess') }}" method="post">
		<label for="eventname">EVENT NAME:</label><br>
		<input type="text" name="eventname" value="" placeholder="Event name">
		<br>
		<br>
		<label for="groups">GROUPS:</label>
		<select class='form-control' style="height: {{$groupsheight}}" name="groups[]" multiple>
			@foreach($groups as $group)
				<option value="{{$group->id}}">{{$group->groupname}}</option>
			@endforeach
		</select>
		<br>
		<label for="choices">CHOICES:</label>
		<select class='form-control' style="height: {{$choicesheight}}" name="choices[]" multiple>
			@foreach($choices as $choice)
				<option value="{{$choice->id}}">{{$choice->choicename}}</option>
			@endforeach
		</select>
		<br>
		<input type="submit" name="createeventsubmit" value="Create">
	</form>
</div>

@endsection
