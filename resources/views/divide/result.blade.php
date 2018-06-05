@extends('layouts.standard')

@section('title', 'Result')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')
<?php $counter = 1; ?>
<div class="row">
	<div class="col-md-12">
		<center>
			<form action="#" method="post">
				<table width=70%>
					<tr>
						<td align=right>
							Maximum members per choice:
						</td>
						<td align=left>
							<input type="number" min={{$mingroup}} max={{$membercount}} name="maxmembers" value="{{$groupcap}}">
						</td>
						<td align=left>
							Number of retrys:
						</td>
						<td align=left>
							<input type="number" min=1 max=10000 name="numberretrys" value="{{$numberretrys}}">
						</td>
						<td align=left>
							<input type="hidden" name="eventid" value="{{$eventid}}">
							<!-- <input type="submit" name="cancelbtn" value="Cancel"> -->
							<input type="submit" name="dividebtn" value="Retry">
						</td>
					</tr>
				</table>
			</form>
		</center>
	</div>
</div>

<h1>RESULT</h1>

<div class="row">
	<div class="col-md-4">
		<ul class='group-list'>
			<div class='choiceheader'>
				<h4>NO CHOICE</h4>
			</div>
			@foreach($divideresult as $result)
				@if($result->choiceid == null)
					<?php
					$choicenames = "";
					foreach($memberinfo[$result->memberid]['choicenames'] as $choicename) {
						$choicenames .= $choicename .", ";
					}
					$choiceids = "";
					foreach($memberinfo[$result->memberid]['choiceids'] as $memberinfochoiceid) {
						$choiceids .= $memberinfochoiceid .";";
					}
					$hiddenname = "memberid[".$result->memberid."]";
					$hiddeninput = "<input type='hidden' name='memberid[".$result->memberid."]' value='".$memberinfochoiceid."' >";
					$choicenames = substr($choicenames, 0, -2);
					$choiceids = substr($choiceids, 0, -1);
					?>

					<li>
						<div id={{$result->memberid}} class="divide-paneldiv" onclick="markmember('{{$result->memberid}}','{{$choiceids}}')">
							<table>
								<tr>
									<td class='group-panelinfo'>{{$memberinfo[$result->memberid]['groupname']}}</td>
								</tr>
								<tr>
									<td>{{$memberinfo[$result->memberid]['membername']}}</td>
								</tr>
								<tr>
									<td class='group-panelinfo'>Choices: {{$choicenames}}</td>
								</tr>
							</table>
						</div>
					</li>

				@endif
			@endforeach
		</ul>
	</div>
</div>


<h3>Members with choices</h3>
<div class="row">
	<div class="col-md-12">
		<form action="#" method="post">
			@foreach($choices as $choiceid => $choicename)
				@if($counter%4 == 0)
					<div class="row choicerow">
				@endif
				<div class="col-md-3">
					<ul class='group-list'>
						<div class='choiceheader'>
							<h4 id='choice_{{$choiceid}}' class='choice-column' onclick="markchoice('{{$choiceid}}', '{{$eventid}}')">{{$choicename}}<div id="link_{{$choiceid}}" class='movememberhidden' onclick="moveMember('{{$choiceid}}', '{{$eventid}}')">
								Move to this choice
							</div></h4>
						</div>
						@foreach($divideresult as $result)
							@if($result->choiceid == $choiceid)
								<?php
								$choicenames = "";
								foreach($memberinfo[$result->memberid]['choicenames'] as $choicename) {
									$choicenames .= $choicename .", ";
								}
								$choiceids = "";
								foreach($memberinfo[$result->memberid]['choiceids'] as $memberinfochoiceid) {
									$choiceids .= $memberinfochoiceid .";";
								}
								$hiddenname = "memberid[".$result->memberid."]";
								$hiddeninput = "<input type='hidden' name='memberid[".$result->memberid."]' value='".$memberinfochoiceid."' >";
								$choicenames = substr($choicenames, 0, -2);
								$choiceids = substr($choiceids, 0, -1);
								?>

								<li>
									<div id={{$result->memberid}} class="divide-paneldiv" onclick="markmember('{{$result->memberid}}','{{$choiceids}}')">
										<table>
											<tr>
												<td class='group-panelinfo'>{{$memberinfo[$result->memberid]['groupname']}}</td>
											</tr>
											<tr>
												<td>{{$memberinfo[$result->memberid]['membername']}}</td>
											</tr>
											<tr>
												<td class='group-panelinfo'>Choices: {{$choicenames}}</td>
											</tr>
										</table>
									</div>
								</li>
							@endif
						@endforeach
					</ul>
				</div>
				@if($counter%4 == 0)
					</div>
				@endif
				<?php $counter++; ?>
			@endforeach
		</form>
	</div>
</div>

@endsection
