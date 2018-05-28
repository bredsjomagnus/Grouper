<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memberchoice as Memberchoice;
use App\Models\Eventgroup as Eventgroup;

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

		if(isset($_POST['cancelbtn'])) {
			return redirect('/events/edit/'.$eventid);
		} else if($_POST['dividebtn']) {
			// divide into event groups
			return redirect('divide/event/result/'.$eventid);
		}
	}

	public function divideResult($eventid) {
		$memberchoice	= new Memberchoice();
		$eventgroup		= new Eventgroup();

		/*
			$sortedchoices.
			Associative array in ascending order:
		 	array ['choiceid' => number of least popular choice,...]
		*/
		$sortedchoices	= $memberchoice->getSortSumOfChoicesForEvent($eventid);

		$memberids		= $eventgroup->getMemberIdsInEvent($eventid); // [memberid, memberid,...]
		$data = [
			"sortedchoices"		=> $sortedchoices,
			"memberids"			=> $memberids
		];
		return view('divide.result', $data);
	}
}
