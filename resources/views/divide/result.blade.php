@extends('layouts.standard')

@section('title', 'Result')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')
<h1>RESULT</h1>
<?php print_r($sortedchoices); ?>
<br>
<?php print_r($memberids); ?>
@endsection
