<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event as Event;
use App\Models\Eventchoice as Eventchoice;
use App\Models\Eventgroup as Eventgroup;

use App\Models\Group as Group;
use App\Models\Groupmember as Groupmember;
use App\Models\Choice as Choice;
use App\Models\Member as Member;
use App\Models\Memberchoice as Memberchoice;

use App\Src\Dev as Devtool;


class EventController extends Controller
{
    public function createEvent() {
		$group 		= new Group;
		$choice		= new Choice;

		$groups 	= $group->getGroupsBelongingToOrganization('Klockarhagsskolan');
		$choices 	= $choice->getChoicesBelongingToOrganization('Klockarhagsskolan');

		$groupsheight	= count($groups)*20;
		$choicesheight	= count($choices)*20;

		$data =  [
			"groups"		=> $groups,
			"groupsheight"	=> $groupsheight."px",
			"choices"		=> $choices,
			"choicesheight"	=> $choicesheight."px",

		];
		return view('events.create', $data);
	}

	public function createEventProcess(Request $request) {
		$event		= new Event;
		$eventname	= $request->input('eventname');
		$groups		= $request->input('groups');
		$choices	= $request->input('choices');

		if(isset($eventname) || trim($eventname) != '' && isset($groups) && isset($choices)) {
			$event->createEvent(htmlspecialchars(trim($eventname)), 'Klockarhagsskolan', $groups, $choices);
		}

		return redirect("/groups");
	}

	public function deleteEventProcess($id) {
		$event			= new Event;
		$eventgroup		= new Eventgroup;
		$eventchoice	= new Eventchoice;

		$eventgroup->deleteByEventid($id);
		$eventchoice->deleteByEventid($id);
		$event->deleteEvent($id);

		return back();
	}

	public function editEvent($id) {
		$eventgroup		= new Eventgroup;
		$eventchoice	= new Eventchoice;
		$group			= new Group;
		$groupmember	= new Groupmember;
		$choice			= new Choice;
		$member			= new Member;
		$memberchoice	= new Memberchoice;

		$groupids		= $eventgroup->getEventGroupsById($id); // Array: [groupid, groupid, groupid...]
		$groups			= $group->getGroupsByIds($groupids); // Array; ['groupid' => groupid, 'groupname' => groupname]

		$choiceids		= $eventchoice->getEventChoicesById($id); // Array: [choiceid, choiceid,...]
		$choices		= $choice->getChoicesByIds($choiceids);

		$members		= $groupmember->getGroupMembersByIds($groupids);

		$memberchoices	= $memberchoice->getMemberChoices($id);

		$data = [
			"groups"		=> $groups,
			"choices"		=> $choices,
			"members"		=> $members,
			"eventid"		=> $id,
			"memberchoices"	=> $memberchoices
		];
		return view('events.overview', $data);
	}

	public function makeChoicesProcess(Request $request){
		$memberchoice	= new Memberchoice;

		if(isset($_POST['savechoicesbtn'])) {
			$madechoices	= $request->input('choices'); // Array with String 'memberid_choiceid'
			$groupid		= $request->input('groupid');
			$eventid		= $request->input('eventid');
			$memberchoice->makeChoices($madechoices, 'Klockarhagsskolan', $groupid, $eventid);
		} elseif(isset($_POST['resetchoicesbtn'])) {
			$groupid		= $request->input('groupid');
			$eventid		= $request->input('eventid');
			$memberchoice->resetGroup($groupid, $eventid);
		}
		return back();
	}

	// public function randomizeEvent($eventid) {
	// 	$eventchoice		= new Eventchoice;
	// 	$eventgroup			= new Eventgroup;
	// 	$dev				= new Devtool;
	//
	// 	$choicesids			= $eventchoice->getEventChoicesById($eventid);
	// 	$numberofchoices 	= $eventchoice->getNumberOfChoices($eventid);
	//
	// 	$memberids			= $eventgroup->getMemberIdsInEvent($eventid); // [memberid, memberid,...]
	//
	// 	$weightarray		= $dev->weightArray($choicesids);
	// 	$switcharray		= $dev->switchArray($weightarray);
	// 	$dev->randomChoices($eventid, $memberids, $choicesids, $switcharray, 'Klockarhagsskolan');
	//
	//
	// 	$data = [
	// 		"numberofchoices"	=> $numberofchoices,
	// 		"choicesids"		=> $choicesids,
	// 		"weightarray"		=> $weightarray,
	// 		"memberids"			=> $memberids
	// 	];
	//
	// 	return back();
	// }
	//
	// public function deleteAllInEvent($eventid) {
	// 	$memberchoice	= new Memberchoice;
	//
	// 	$memberchoice->resetEventChoices($eventid);
	//
	// 	return back();
	// }

	public function devOptions(Request $request) {
		$memberchoice		= new Memberchoice;
		$eventchoice		= new Eventchoice;
		$eventgroup			= new Eventgroup;
		$dev				= new Devtool;

		$eventid			= $request->input('eventid');
		$choosingnumber		= $request->input('choosingnumber');

		if(isset($_POST['randomizeall'])) {
			$choicesids			= $eventchoice->getEventChoicesById($eventid);
			$numberofchoices 	= $eventchoice->getNumberOfChoices($eventid);

			$memberids			= $eventgroup->getMemberIdsInEvent($eventid); // [memberid, memberid,...]

			$weightarray		= $dev->weightArray($choicesids);
			$switcharray		= $dev->switchArray($weightarray);
			$dev->randomChoices($eventid, $memberids, $choicesids, $switcharray, $choosingnumber, 'Klockarhagsskolan');
		} else if(isset($_POST['deleteall'])){
			$memberchoice->resetEventChoices($eventid);
		}

		return back();
	}
}
