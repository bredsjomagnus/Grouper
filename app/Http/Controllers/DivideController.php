<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
		}
	}
}
