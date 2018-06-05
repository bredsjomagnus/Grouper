@extends('layouts.standard')

@section('title', 'Event overview')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')
<?php $divideresulturl = url("/divide/event/result/".$eventid); ?>
<h1>DIVIDE SETTINGS</h1>
<form action="{{ $divideresulturl }}" method="post">
	<table width=500px>
		<tr width=80%>
			<td>
				Maximum members per choice:
			</td>
			<td align=right>
				<input type="number" min={{$mingroup}} max={{$membercount}} name="maxmembers" value="{{$mingroup}}">
			</td>
		</tr>
		<tr>
			<td>
				Number of retrys:
			</td>
			<td align=right>
				<input type="number" min=1 max=10 name="numberretrys" value="1">
			</td>
		</tr>
		<tr>
			<td colspan=2 align=right style="padding-top: 20px">
				<input type="hidden" name="eventid" value="{{$eventid}}">
				<input type="hidden" name="membercount" value="{{$membercount}}">
				<input type="hidden" name="mingroup" value="{{$mingroup}}">
				<input type="submit" name="cancelbtn" value="Cancel">
				<input type="submit" name="dividebtn" value="Divide into event groups">
			</td>
		</tr>
	</table>
</form>
@endsection
