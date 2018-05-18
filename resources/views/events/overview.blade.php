@extends('layouts.standard')

@section('title', 'Event overview')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')

	<h1>Event overview</h1>
	<br>
	<?php
	$randomurl = url('/events/randomize/'.$eventid);
	?>
	<a class='btn btn-default' href="{{ $randomurl }}">Slumpa</a>
	<a class='btn btn-default' href="#">Rensa allt</a>
	<br>
	<br>
	<ul class="nav nav-tabs">
		<?php $counter = 1; ?>
		@foreach($groups as $group)
			<li class="{{ ($counter == 1) ? 'active' : '' }}">
				<a href="#{{$group['groupid']}}" data-toggle="tab">{{$group['groupname']}}</a>
			</li>
			<?php $counter++; ?>
		@endforeach
	</ul>
	<div class="tab-content">
	<?php $activepanecounter = 1; ?>
	@foreach($groups as $group)

			<div class="tab-pane {{ ($activepanecounter == 1) ? 'active' : '' }}" id="{{$group['groupid']}}">
				<form action="{{ route('makechoicesprocess') }}" method="POST">
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
											<?php $checked = '' ?>
											@if(array_key_exists($member['memberid'], $memberchoices))
												<?php $checked = in_array($choice['choiceid'], $memberchoices[$member['memberid']]) ? 'checked' : ''; ?>
											@endif
											<td>
												<input type="checkbox" name="choices[]" value="{{ $member['memberid'] }}_{{ $choice['choiceid'] }}" {{ $checked }}>
											</td>
										@endforeach
					                </tr>
								@endif
			                @endforeach
							<tr>
								<td colspan={{ count($choices) +1 }} align='right'>
									<input type="hidden" name="groupid" value={{ $group['groupid'] }} >
									<input type="hidden" name="eventid" value={{ $eventid }}>
									<input class='btn btn-danger' type="submit" name="resetchoicesbtn" value="Reset" onclick="return confirm('Really reset all choices in this group?')">
									<input class='btn btn-primary' type="submit" name="savechoicesbtn" value="Save">
								</td>
							</tr>
			            </tbody>
					</table>
				</form>
			</div> <!-- /tab-pane -->
		<?php $activepanecounter++; ?>
	@endforeach
	</div> <!-- /tab-content -->
@endsection
