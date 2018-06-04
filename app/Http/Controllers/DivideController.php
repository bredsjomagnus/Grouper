<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memberchoice as Memberchoice;
use App\Models\Eventchoice as Eventchoice;
use App\Models\Eventgroup as Eventgroup;
use App\Models\Divideresult as Divideresult;
use App\Models\Member as Member;
use App\Models\Choice as Choice;

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

	public function concoleprocess(Request $request) {
		// $cancelbtn		= $request->input('cancelbtn');
		$dividebtn		= $request->input('dividebtn');
		$eventid		= $request->input('eventid');
		$retrys			= $request->input('numberretrys');
		$groupcap		= $request->input('maxmembers');

		if(isset($_POST['cancelbtn'])) {
			return redirect('/events/edit/'.$eventid);
		} else if($_POST['dividebtn']) {
			// divide into event groups
			return redirect('divide/event/result/'.$eventid.'?numberretrys='.$retrys.'&maxmembers='.$groupcap);
		}
	}

	public function divideResult($eventid) {
		$memberchoice	= new Memberchoice();
		$eventgroup		= new Eventgroup();
		$divide			= new Divideresult();
		$eventchoice	= new Eventchoice();
		$choice			= new Choice();
		$member			= new Member();

		$retrys			= $_GET['numberretrys'];
		$groupcap		= $_GET['maxmembers'];

		$choiceids		= $eventchoice->getEventChoicesById($eventid); // For this event Array: [choiceid, choiceid,...]
		$choices		= $choice->getChoicesByIdsAssociative($choiceids); // For this event; [['choiceid' => choiceid, 'choicename' => choicename],...]

		$memberids		= $eventgroup->getMemberIdsInEvent($eventid); // For this event [memberid, memberid,...]
		$members		= $member->getMembersByIds($memberids); // For this event [memberid => membername, ]


		/*
			$choicetemplate.
			Associative array in ascending order:
		 	array ['choiceid' => number of least popular choice,...]
		*/
		$choicetemplate	= $memberchoice->getSortSumOfChoicesForEvent($eventid);
		// $noeventgroup 	= $memberchoice->handleMemberchoicesWithTemplate($eventid, $choicetemplate, $memberids, $retrys, $groupcap); // not working

		$noeventgroup 	= $memberchoice->handleMemberchoicesNoTemplate($eventid, $choicetemplate, $memberids, $retrys, $groupcap);

		$divideresult 	= $divide->getDivideResult($eventid);

		$memberchoices 	= $memberchoice->getMemberChoices($eventid);

		$memberinfo		= $member->getMembersDivideInfo($memberids, $eventid);

		$data = [
			"eventid"			=> $eventid,
			"noeventgroup"		=> $noeventgroup,
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
}
