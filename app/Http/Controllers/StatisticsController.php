<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Memberchoice as Memberchoice;

class StatisticsController extends Controller
{
    public function statisticsEvent($eventid) {
		$memberchoice = new Memberchoice();

		$barvaluepercent = $memberchoice->getPercentStatisticsForEvent($eventid);  //returns string with values for fusionchart
		$data = [
			"valuespercent" 	=> $barvaluepercent,
			"eventid"			=> $eventid
		];
		return view('statistics.event', $data);
	}
}
