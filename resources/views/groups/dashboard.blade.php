@extends('layouts.standard')

@section('title', 'Dashboard')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')

	<h1>GROUPS</h1>
	<!-- GROUPS -->
	@if(isset($groups) && count($groups) > 0)
		<div class="row">
			<div class="col-md-12">

					<ul class='group-list'>
						@foreach($groups as $group)
							<?php
							$editurl = url('/groups/edit/'.$group->id);
							$deleteurl = url('/groups/delete/'.$group->id);
							?>
							<li class='group-list-item'>
								<a class='paneldivlink' href="{{ $editurl }}">
									<div class={{ in_array($group->id, $eventgroupids ) ? 'group-paneldiv': 'group-paneldiv' }}>
										<center>
											<table class='groupdashboardtable'>
												<tr>
													<td colspan='3' class='groupnamecell'><center>{{$group->groupname}}</center></td>
												</tr>
												<tr class='groupinforow'>
													<td class='groupemptystylecell'></td>
													<!-- $groupsizes is an associative array as follows [groupid => numberofmembers,...] -->
													<td>
														@if($groupsizes[$groupmemberscounter]->groupid == $group->id)
															<span class='group-panelinfo'>Members: {{$groupsizes[$groupmemberscounter]->numberofmembers}} </span>
														@endif
													</td>
													<td>
														<a href='{{ in_array($group->id, $eventgroupids ) ? '#' : $deleteurl }}' onclick='return confirm("Do you want to delete this group along with all its members");'>
															<span class="{{ in_array($group->id, $eventgroupids ) ? '': 'glyphicon glyphicon-trash' }}" aria-hidden="true"></span>

														</a>
														<!-- $eventgroupids contains all ids of every group that is in an event -->
														<span class='inevent-panelinfo'>{{ in_array($group->id, $eventgroupids ) ? 'IN EVENT': '' }}</span>
													</td>
												</tr>
											</table>
										</center>
									</div>
								</a>
							</li>
							<?php $groupmemberscounter++; ?>
						@endforeach
					</ul>

			</div>
		<!-- /col-md-12 -->
		</div>
		<!-- /row -->
	@else
	<div class="row">
		<h3 class='text-danger'>No groups yet. Add groups in menu 'Add group'!</h3>
	</div>
	@endif

	<h1>CHOICES</h1>
	<!-- CHOICES -->
	@if(isset($choices) && count($choices) > 0)
		<div class="row">
			<div class="col-md-12">
				<ul class='group-list'>
					@foreach($choices as $choice)
						<?php
						$editchoiceurl = url('/choices/edit');
						$deletechoiceurl = url('/choices/delete/'.$choice->id);
						?>
						<li class='group-list-item'>
							<a class='paneldivlink' href="{{ $editchoiceurl }}">
								<div class="choice-paneldiv">
									<center>
										<table class='groupdashboardtable'>
											<tr>
												<td colspan='2' class='groupnamecell'><center>{{$choice->choicename}}</center></td>
											</tr>
											<tr class='choiceinforow'>
												<td class="{{ in_array($choice->id, $eventchoiceids ) ? 'choiceemptyineventstylecell': 'choiceemptystylecell' }}"></td>

												<td>
													<a href='{{ $deletechoiceurl }}' onclick='return confirm("Do you want to delete this choice?");'>
														<span class="{{ in_array($choice->id, $eventchoiceids ) ? '': 'glyphicon glyphicon-trash' }}" aria-hidden="true"></span>
													</a>
													<!-- $eventchoiceids contains all ids of every group that is in an event -->
													<span class='inevent-panelinfo'>{{ in_array($choice->id, $eventchoiceids ) ? 'IN EVENT': '' }}</span>
												</td>
											</tr>
										</table>
									</center>
								</div>
							</a>
						</li>
					@endforeach
				</ul>

			</div>
		</div>
	@else
		<div class="row">
			<h3 class='text-danger'>No choices yet. Add choices in menu 'Add choice'!</h3>
		</div>
	@endif
@endsection

@section('rightsidepanel')
<h1 style='padding-left:40px;'>UPCOMING EVENTS</h1>
@if(isset($events) && count($events) > 0)
	<br>
	<div class="row eventpanelbackground">
		<div class="col-md-12">
			<ul class='group-list'>
				@foreach($events as $event)
					<?php
					$editeventurl = url('/events/edit/'.$event->id);
					$deleteeventurl = url('/events/delete/'.$event->id);
					?>
					<li class='group-list-item'>
						<a class='paneldivlink' href="{{ $editeventurl }}">
							<div class="event-paneldiv">
								<center>
									<table class='groupdashboardtable'>
										<tr>
											<td colspan='2' class='groupnamecell'><center>{{$event->eventname}}</center></td>
										</tr>
										<tr class='eventinforow'>
											<td class='groupemptystylecell'></td>
											<td>
												@if($numberofgroups[$numberofgroupscounter]->eventid == $event->id)
													<span class='group-panelinfo'>Groups: {{$numberofgroups[$numberofgroupscounter]->numberofgroups}}</span><br>
												@endif

												<span class='group-panelinfo'>Members: {{ $numberofmembers[$event->id] }}</span><br>
												@if(count($numberofchoices) > 0)
													@if($numberofchoices[$numberofgroupscounter]->eventid == $event->id)
														<span class='group-panelinfo'>Choices: {{$numberofchoices[$numberofgroupscounter]->numberofchoices}}</span>
													@endif
												@else
													<span class='group-panelinfo'>Choices: No choices!</span>
												@endif
											</td>
											<td>
												<a href='{{ $deleteeventurl }}' onclick='return confirm("Do you want to delete this event?");'>
													<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
												</a>
											</td>
										</tr>
									</table>
								</center>
							</div>
						</a>
					</li>
					<?php $numberofgroupscounter++; ?>
				@endforeach
			</ul>
		</div>
	</div>
@else
<div class="row">
	<h4 class='text-danger'>No events yet. Add events in menu 'Create Event'!</h4>
</div>
@endif
@endsection
