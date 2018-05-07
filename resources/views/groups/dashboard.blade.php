@extends('layouts.standard')

@section('title', 'Groups')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')
	<h1>GROUPS</h1>
	<!-- GROUPS -->
	<div class="row panelbackground">
		<div class="col-md-12">
			@if(isset($groups) && count($groups) > 0)
				<ul class='group-list'>
					@foreach($groups as $group)
						<?php
						$editurl = url('/groups/edit/'.$group->id);
						$deleteurl = url('/groups/delete/'.$group->id);
						?>
						<li class='group-list-item'>
							<a class='paneldivlink' href="{{ $editurl }}">
								<div class="group-paneldiv">
									<center>
										<table class='groupdashboardtable'>
											<tr>
												<td colspan='3' class='groupnamecell'><center>{{$group->groupname}}</center></td>
											</tr>
											<tr class='groupinforow'>
												<td class='groupemptystylecell'></td>
												<td>
													@if($groupsizes[$counter]->groupid == $group->id)
														<span class='group-panelinfo'>Members: {{$groupsizes[$counter]->numberofmembers}} </span>
													@endif
												</td>
												<td>
													<a href='{{ $deleteurl }}' onclick='return confirm("Do you want to delete this group along with all its members");'>
														<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
													</a>
												</td>
											</tr>
										</table>
									</center>
								</div>
							</a>
						</li>
						<?php $counter++; ?>
					@endforeach
				</ul>
			@else
				<p>no groups</p>
			@endif
		</div>
	<!-- /col-md-12 -->
	</div>
	<!-- /row -->

	<h1>CHOICES</h1>
	<!-- CHOICES -->
	<div class="row choicepanelbackground">
		<div class="col-md-12">
			@if(isset($choices) && count($choices) > 0)
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
										<tr class='groupinforow'>
											<td class='choiceemptystylecell'></td>

											<td>
												<a href='{{ $deletechoiceurl }}' onclick='return confirm("Do you want to delete this choice?");'>
													<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
												</a>
											</td>
										</tr>
									</table>
								</center>
							</div>
						</a>
					</li>
					<?php $counter++; ?>
				@endforeach
			</ul>
			@else
				<p>no choices</p>
			@endif
		</div>
	</div>
@endsection

@section('rightsidepanel')
<h3>RIGHT SIDE PANEL</h3>
@endsection
