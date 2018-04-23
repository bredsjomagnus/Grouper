@extends('layouts.standard')

@section('title', 'Groups')

@section('content')
<h1>GROUPS</h1>
@foreach($groups as $group)
<p>{{$group->groupname}}</p>
@endforeach

@endsection
