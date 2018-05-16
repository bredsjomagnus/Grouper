@extends('layouts.standard')

@section('title', 'Event overview')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')
	<h1>Event overview</h1>
	@foreach($groups as $group)
		<form action="#" method="post">


		<table class='table'>
			<thead>
				<tr>
					<th>{{ $group['groupname'] }}</th>
					@foreach($choices as $choice)
						<th>{{ $choice['choicename'] }}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
                @foreach($members as $member)
					@if($member['groupid'] == $group['groupid'])
		                <tr>
		                    <td>{{ $member['membername'] }}</td>
							@foreach($choices as $choice)
								<td> <input type="checkbox" name="" value=""> </td>
							@endforeach
		                </tr>
					@endif
                @endforeach
				<tr>
					<td colspan={{ count($choices) +1 }} align='right'> <input class='btn btn-primary' type="submit" name="savebtn" value="Save"></td>
				</tr>
            </tbody>
		</table>

		</form>
	@endforeach
@endsection
