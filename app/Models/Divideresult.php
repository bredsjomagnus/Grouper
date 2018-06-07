<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divideresult extends Model
{
    /*
	* This model is to store final results after dividing into groups.
	*
	* Parameters:
	* eventid
	* memberid
	* choiceid
	*/

	/**
	* Get divide result for event
	*
	* @param Integer event id
	*
	* @return Object result
	*/
	public function getDivideResult($eventid) {
		$res = $this::where('eventid', $eventid)->get();

		return $res;
	}

	/**
	* Reset prevous made choices for event
	*
	* @param Integer event id
	*
	* @return void
	*/
	public function resetPreviousChoices($eventid) {
		$this::where('eventid', $eventid)->delete();
	}

	/**
	* Put memberchoices selection into database
	*
	* @param Array $eventgrouparray is an associative array as [memberid => choiceid, ...]
	*
	* @return void
	*/
	public function setDivideResult($eventid, $eventgrouparray, $noeventgroup) {

		/*
		* Reset previous choices
		*/
		$this->resetPreviousChoices($eventid);

		/*
		* Store new choices
		*/
		foreach($eventgrouparray as $memberid => $choiceid) {
			$this::insert([
				"eventid" 	=> $eventid,
				"memberid"	=> $memberid,
				"choiceid"	=> $choiceid
			]);
		}

		foreach($noeventgroup as $memberid) {
			$this::insert([
				"eventid" 	=> $eventid,
				"memberid"	=> $memberid,
				"choiceid"	=> null
			]);
		}
	}

	// VERKAR INTE FUNGERA SOM TÄNKT
	// public function isThereNonGroupMembers($eventid) {
	// 	$res = $this::where('eventid', $eventid)
	// 			->where('choiceid', null)
	// 			->get();
	//
	// 	return empty((array)$res);
	// }

	public function moveMember($memberid, $choiceid, $eventid) {
		$this::where('eventid', $eventid)
	          ->where('memberid', $memberid)
	          ->update(['choiceid' => $choiceid]);
	}
}
