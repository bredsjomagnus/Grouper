@extends('layouts.standard')

@section('title', 'Result')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')
<h1>RESULT</h1>
<p>Members with no choice</p>
<?php print_r($noeventgroup); ?>

@foreach($divideresult as $result)
<p>Memberid {{$result->memberid}}, Choiceid {{$result->choiceid}}</p>
@endforeach
@endsection
