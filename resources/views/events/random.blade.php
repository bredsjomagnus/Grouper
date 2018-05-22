@extends('layouts.standard')

@section('title', 'Event overview')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')
<h1>randomize display</h1>
<p> {{ $numberofchoices }} </p>
<h4>CHOICEIDS</h4>
<p> <?php print_r($choicesids) ?> </p>
<h4>WEIGHT ARRAY- <span>{{array_sum($weightarray)}}%</h4>
<p> <?php print_r($weightarray) ?> </p><br>
<h4>MEMBERIDS - <span>{{count($memberids)}} st, ({{count($memberids)*5}})</span></h4>
<p> <?php print_r($memberids) ?> </p><br>
<h4>CHOICE POOL  - <span>{{array_sum($choicepool)}} st</span></h4>
<p> <?php print_r($choicepool) ?> </p><br>
@endsection
