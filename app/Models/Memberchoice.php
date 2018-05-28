<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;

class Memberchoice extends Model
{
    // use SoftDeletes;

	/**
	* Make choices after pressing save in event overview for a group
	*
	* @param Array with Strings ['memberid_choiceid', ...] for members and there choices
	* @param String organization
	* @param String groupid, is converted to integer in method
	* @param String eventid, is converted to integer in method
	*
	* @return void
	*/
	public function makeChoices($madechoices, $organization, $groupid, $eventid) {
		$this::where('groupid', $groupid)->where('eventid', $eventid)->delete();
		if(isset($madechoices)) {
			foreach ($madechoices as $choice) {
				$choiceparams = explode('_', $choice); // ['memberid', 'choiceid']
				$this::insert([
					'memberid' 		=> (int)$choiceparams[0],
					'choiceid' 		=> (int)$choiceparams[1],
					'organization' 	=> $organization,
					'groupid'		=> (int)$groupid,
					'eventid'		=> (int)$eventid
				]);
			}
		}
	}

	public function getMemberChoices($eventid) {
		$res 	= DB::select(
					DB::raw(
						"SELECT memberid, GROUP_CONCAT(choiceid) as choices FROM memberchoices WHERE eventid = ".$eventid." GROUP BY memberid"
					)
				);
		$memberchoices = [];
		foreach($res as $row) {
			$choicesres = $row->choices;
			$choices	= explode(',', $choicesres);
			$memberchoices[$row->memberid] = $choices;
		}
		return $memberchoices;
	}

	public function resetGroup($groupid, $eventid) {
		$this::where('groupid', $groupid)->where('eventid', $eventid)->delete();
	}

	public function resetEventChoices($eventid) {
		$this::where('eventid', $eventid)->delete();
	}

	/**
	* Get sum of all choices members have done for an event.
	*
	* @param Integer event id.
	*
	* @return Object result
	*/
	public function getSumOfChoicesForEvent($eventid) {
		$res = DB::select(
				DB::raw(
					"SELECT choiceid, COUNT(choiceid) AS numberofachoice FROM memberchoices WHERE eventid LIKE '".$eventid."' GROUP BY choiceid;"
					)
			);

		return $res;
	}

	/**
	* Method specificaly to create json-values for chart.
	*
	* @param Integer event id
	*
	* @return String json-object 'data' with values and labels for percent bar chart.
	*/
	public function getPercentStatisticsForEvent($eventid) {
		$res = $this->getSumOfChoicesForEvent($eventid);

		$all = 0;
		foreach($res as $row) {
			$all += $row->numberofachoice;
		}

		$barvalue = '"data": [';
		foreach($res as $row) {
			$choice = DB::table('choices')->where('id', $row->choiceid)->get();
			$percent = round(($row->numberofachoice/$all)*100, 1);
			$barvalue 	.= '{
								"label": "'.$choice[0]->choicename.'",
								"value": "'.$percent.'"
							},';
		}

		$barvalue = substr($barvalue, 0, -1);
		$barvalue .= ']';

		return $barvalue;
	}

	/**
	* Get an associated array in ascending order over members choices in event
	*
	* @param Integer event id
	*
	* @return Array Associative array in ascending order ['choiceid' => number of choices for least popular choice, ...]
	*/
	public function getSortSumOfChoicesForEvent($eventid) {
		$res = $this->getSumOfChoicesForEvent($eventid);

		$choicesarray = [];
		foreach($res as $row) {
			$choicearray[$row->choiceid] = $row->numberofachoice;
		}
		asort($choicearray); // sort in asscending order

		return $choicearray;
	}
}
