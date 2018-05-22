<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Memberchoice as Memberchoice;

class StatisticsController extends Controller
{
    public function statisticsEvent($eventid) {
		$memberchoice = new Memberchoice();

		$barvalue = $memberchoice->getStatisticsForEvent($eventid);  //returns string with values for fusionchart
		$data = [
			"values" =>		$barvalue
		];
		return view('statistics.event', $data);
	}
}
