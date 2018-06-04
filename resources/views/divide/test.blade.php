@extends('layouts.standard')

@section('title', 'Result')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')

<h1>TEST</h1>
<p>{{$memberid}}</p>
<p>{{$choiceid}}</p>
<p>{{$eventid}}</p>
@endsection
