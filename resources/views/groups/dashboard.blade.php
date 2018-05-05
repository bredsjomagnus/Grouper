@extends('layouts.standard')

@section('title', 'Groups')

@section('content')


	<h1>GROUPS</h1>
	<!-- GROUPS -->
	<div class="row panelbackground">
		<div class="col-md-12">
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
	<!-- /col-md-12 -->
	</div>
	<!-- /row -->

	<h1>CHOICES</h1>
	<!-- CHOICES -->
	<div class="row panelbackground">
		<div class="col-md-12">

		</div>
	</div>

@endsection
