@extends('layouts.standard')

@section('title', 'Event overview')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')
<h1>randomize display</h1>
<p> {{ $numberofchoices }} </p>
<p> <?php print_r($choicesids) ?> </p>
<p> <?php print_r($weightarray) ?> </p><br>
<p> <?php print_r($memberids) ?> </p>
@endsection
