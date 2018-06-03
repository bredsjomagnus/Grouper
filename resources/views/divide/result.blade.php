@extends('layouts.standard')

@section('title', 'Result')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')

<h1>RESULT</h1>
<h5>Members with no choice</h5>
@foreach($noeventgroup as $nogroup)
<p>{{ $members[$nogroup] }}</p>
@endforeach
<h3>Members with choices</h3>
	@foreach($choices as $choiceid => $choicename)
		<h4>{{$choicename}}</h4>
		@foreach($divideresult as $result)
			@if($result->choiceid == $choiceid)
				<p>{{$members[$result->memberid]}}</p>
			@endif
		@endforeach
	@endforeach

@endsection
