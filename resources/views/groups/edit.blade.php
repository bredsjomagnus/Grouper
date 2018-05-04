@extends('layouts.standard')

@section('title', 'Groups')

@section('content')
	<a href="{{ route('groupsdashboard')}}">Dashboard</a>
	<a href="{{ route('addgroup')}}">Add group</a>

	<div class="row">
		<div class="col-md-3">
			<h1>EDIT</h1>
			<h2><div id='edit_groupname' onclick="toFormGroupName({{$group->id}})">{{$group->groupname}}</div></h2>
		</div>
	</div>

	<table>
		<thead>
			<tr>
				<th width='300px'>Member</th>
				<th colspan='2'>Actions</th>
			</tr>
		</thead>
		<tbody>
		@foreach($members as $id => $membername)
			<?php
			$deleteurl = url('/members/delete/'.$id.'?groupid='.$group->id);
			?>
			<tr>
				<!-- <td><div id='firstname_#{result[index]._id}' onclick="toForm('firstname_#{result[index]._id}', '#{result[index]._id}', '#{result[index].firstname}', 'firstname')">#{result[index].firstname}</div></td> -->
				<td><div id='firstname_{{$id}}' onclick="toForm('firstname_{{$id}}', {{$id}}, {{$group->id}}, '{{$membername}}', 'membername')">{{$membername}}</div></td>
				<!-- <td>{{$membername}}</td> -->
				<td><a href="{{$deleteurl}}" onclick="return confirm('Are you sure you want to delete this member?');">delete</a>&nbsp;&nbsp;</td>
				<td>
					<li style='list-style-type: none;' class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            move to <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
							@foreach($groups as $moveto)
								@if($moveto->groupname != $group->groupname)
									<?php
									$moveurl = 'members/move?member='.$id.'&from='.$group->id.'&to='.$moveto->id;
									?>
									<li>
		                                <a href="{{ url($moveurl) }}" onclick="return confirm('Are you sure you want to move this member');">
		                                    {{$moveto->groupname}}
		                                </a>
		                            </li>
								@else
									<li>
										<a href="#" class='disabled-link text-muted'>
											{{$moveto->groupname}}
										</a>
									</li>
								@endif
							@endforeach
                        </ul>
                    </li>
				 </td>
			</tr>
		@endforeach
			<tr style='height: 40px'>
				<td colspan='1'><div id='addmember' onclick="toFormAdd({{$group->id}})">+ Add member</div></td>
			</tr>
		</tbody>
	</table>
@endsection
