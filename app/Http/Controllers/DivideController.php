<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memberchoice as Memberchoice;
use App\Models\Eventchoice as Eventchoice;
use App\Models\Eventgroup as Eventgroup;
use App\Models\Divideresult as Divideresult;
use App\Models\Member as Member;
use App\Models\Choice as Choice;
use App\Models\Group as Group;
use App\Models\Event as Event;

class DivideController extends Controller
{
    public function console($eventid, Request $request) {
		$membercount = $request->input('membercount');
		$choicecount = $request->input('choicecount');
		$eventid	 = $request->input('eventid');

		$mingroup = ceil($membercount/$choicecount);
		$data = [
			"membercount"	=> $membercount,
			"mingroup"		=> $mingroup,
			"eventid"		=> $eventid
		];
		return view('divide.console', $data);
	}

	// public function concoleprocess(Request $request) {
	// 	// $cancelbtn		= $request->input('cancelbtn');
	// 	$dividebtn		= $request->input('dividebtn');
	// 	$eventid		= $request->input('eventid');
	// 	$retrys			= $request->input('numberretrys');
	// 	$groupcap		= $request->input('maxmembers');
	//
	// 	if(isset($_POST['cancelbtn'])) {
	// 		return redirect('/events/edit/'.$eventid);
	// 	} else if($_POST['dividebtn']) {
	// 		// divide into event groups
	// 		return redirect('divide/event/result/'.$eventid.'?numberretrys='.$retrys.'&maxmembers='.$groupcap.'&divide=yes');
	// 	}
	// }

	public function divideResult(Request $request, $eventid) {
		$memberchoice	= new Memberchoice();
		$eventgroup		= new Eventgroup();
		$divide			= new Divideresult();
		$eventchoice	= new Eventchoice();
		$choice			= new Choice();
		$member			= new Member();
		$group			= new Group();
		$event			= new Event();

		// $retrys			= $_GET['numberretrys'];
		// $groupcap		= $_GET['maxmembers'];
		// $getdivide		= $_GET['divide'];
		$retrys			= $request->input('numberretrys');
		$groupcap		= $request->input('maxmembers');
		$dividebtn		= $request->input('dividebtn');

		$choiceids		= $eventchoice->getEventChoicesById($eventid); // For this event Array: [choiceid, choiceid,...]
		$choices		= $choice->getChoicesByIdsAssociative($choiceids); // For this event; [['choiceid' => choiceid, 'choicename' => choicename],...]

		$memberids		= $eventgroup->getMemberIdsInEvent($eventid); // For this event [memberid, memberid,...]
		$members		= $member->getMembersByIds($memberids); // For this event [memberid => membername, ]

		$eventname		= $event->getEventName($eventid);
		/*
			$choicetemplate.
			Associative array in ascending order:
		 	array ['choiceid' => number of least popular choice,...]
		*/
		$choicetemplate	= $memberchoice->getSortSumOfChoicesForEvent($eventid);
		// $noeventgroup 	= $memberchoice->handleMemberchoicesWithTemplate($eventid, $choicetemplate, $memberids, $retrys, $groupcap); // not working

		/*
		* Only divide into new groups if pressing right button
		*/
		if(isset($dividebtn)) {
			$memberchoice->handleMemberchoicesNoTemplate($eventid, $choicetemplate, $memberids, $retrys, $groupcap);
		}


		$divideresult 		= $divide->getDivideResult($eventid);
		// $nongroupmembers	= $divide->isThereNonGroupMembers($eventid);

		$memberchoices 		= $memberchoice->getMemberChoices($eventid);
		$memberinfo			= $member->getMembersDivideInfo($memberids, $eventid);

		// $numberofgroups 	= $eventgroup->getNumberOfGroups($eventid);
		$eventgroups		= $eventgroup->getEventGroupsById($eventid); // All that events groups ids in array
		$groups				= $group->getGroupsByIds($eventgroups); // All groups in events as [["groupid" => groupid, "groupname" => groupname],... ]


		$data = [
			"eventname"			=> $eventname,
			"groups"			=> $groups,
			"numberofgroups"	=> count($eventgroups),
			"numberofmembers"	=> count($memberids),
			"numberofchoices"	=> count($choiceids),
			"groupcap"			=> $groupcap,
			"numberretrys"		=> $retrys,
			"membercount"		=> $request->input('membercount'),
			"mingroup"			=> $request->input('mingroup'),
			"eventid"			=> $eventid,
			"divideresult"		=> $divideresult,
			"choices"			=> $choices,
			"members"			=> $members,
			"choicetemplate"	=> $choicetemplate,
			"memberchoices"		=> $memberchoices,
			"memberinfo"		=> $memberinfo
		];

		// if(isset($choicetemplate)) {
		// 	print_r($choicetemplate);
		// }
		// echo "<br>";
		// if(isset($memberchoices)) {
		// 	print_r($memberchoices);
		// }

		return view('divide.result', $data);
	}

	public function retrieve($eventid) {
		$member			= new Member();
		$memberchoice	= new Memberchoice();

		$memberchoices 	= $memberchoice->getMemberChoices($eventid);

        return response()
					->json(
						[
							'msg' 	=> 'This is get method',
							'data'	=> json_encode($memberchoices)
						]);
	}

	public function moveMember(Request $request) {
		$divide		= new Divideresult();

		$memberid 	= $_GET['memberid'];
		$choiceid 	= $_GET['choiceid'];
		$eventid 	= $_GET['eventid'];

		$divide->moveMember($memberid, $choiceid, $eventid);
		// $data = [
		// 	"memberid"	=> $memberid,
		// 	"choiceid"	=> $choiceid,
		// 	"eventid"	=> $eventid
		// ];

		return redirect("divide/event/result/".$eventid);
	}
}
