@extends('layouts.standard')

@section('title', 'Edit choice')

@section('content')
<h1>EDIT CHOICES</h1>

<table>
	<thead>
		<tr>
			<th width='300px'>Choice</th>
			<th colspan='2'>Actions</th>
		</tr>
	</thead>
	<tbody>
	@foreach($choices as $choice)
		<?php
		$deletechoiceurl = url('/choices/delete/'.$choice->id);
		?>
		<tr>
			<td><div id='firstname_{{$choice->id}}' onclick="toForm('firstname_{{$choice->id}}', {{$choice->id}}, '{{$choice->choicename}}', 'choicename')">{{$choice->choicename}}</div></td>
			<td><a href="{{$deletechoiceurl}}" onclick="return confirm('Are you sure you want to delete this choice?');">delete</a>&nbsp;&nbsp;</td>
		</tr>
	@endforeach
		<tr style='height: 40px'>
			<td colspan='1'><div id='addchoice' onclick="toFormAdd()">+ Add choice</div></td>
		</tr>
	</tbody>
</table>
@endsection
