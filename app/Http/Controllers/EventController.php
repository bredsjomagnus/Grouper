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

		$groupids		= $eventgroup->getEventGroupsById($id); // Array: [groupid, groupid, groupid...]
		$groups			= $group->getGroupsByIds($groupids); // Array; ['groupid' => groupid, 'groupname' => groupname]

		$choiceids		= $eventchoice->getEventChoicesById($id);
		$choices		= $choice->getChoicesByIds($choiceids);

		$members		= $groupmember->getGroupMembersByIds($groupids);

		$data = [
			"groups"		=> $groups,
			"choices"		=> $choices,
			"members"		=> $members
		];
		return view('events.overview', $data);
	}
}
