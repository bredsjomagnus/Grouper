@extends('layouts.standard')

@section('title', 'Groups')

@section('content')
	<a href="{{ route('groupsdashboard')}}">Dashboard</a>
	<a href="{{ route('addgroup')}}">Add group</a>

	<h1>GROUPS</h1>
	<!-- GROUPS -->
	<div class="row panelbackground">
		<div class="col-md-12">


			<div class="">
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
			</div>
			<!-- panelbackground -->
		</div>
	<!-- /col-md-12 -->
	</div>
	<!-- /row -->

	<!-- CHOICES -->
	<div class="row">
		<div class="col-md-12">
			<h1>CHOICES</h1>
		</div>
	</div>

@endsection
