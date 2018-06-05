<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;

use App\Models\Divideresult as Divideresult;
use App\Models\Member as Member;

class Memberchoice extends Model
{
	/*
	* This model is for all the multiple choices a member can do.
	*/

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
		// get the count/sum of every choice for this event
		$res = $this->getSumOfChoicesForEvent($eventid);

		// put values in array
		$choicesarray = [];
		foreach($res as $row) {
			$choicearray[$row->choiceid] = $row->numberofachoice;
		}
		// sort array with respect to values in ascending order.
		asort($choicearray);

		return $choicearray;
	}



	/**
	* Place members in event in eventgroups depending on members choice and choicetemplate
	*
	* @param Integer event id
	* @param Array assocciated array sorted in ascending order ['choiceid' => number of least popular choice,...]
	* @param Array member ids
	*
	* @return void
	*/
	// public function handleMemberchoicesWithTemplate($eventid, $choicetemplate, $memberids, $retrycap, $groupcap) {
	// 	$divide = new Divideresult();
	// 	$retrys = 0;
	//
	// 	/*
	// 	* $memberchoices is assocciative array with memberid as key and choices ids in array as value
	// 	* [memberid => [choiceid, choiceid, choiceid,...], memberid => [choiceid, choiceid, choiceid], ...]
	// 	* The choices for that member is only for this event with event id = $eventid
	// 	*/
	// 	$memberchoices = $this->getMemberChoices($eventid);
	//
	// 	while($retrys < $retrycap) {
	// 		// Setting up $choicetemplate
	// 		$choicepool = [];
	// 		foreach($choicetemplate as $choiceid => $number) {
	// 			$choicepool[$choiceid] = 0;
	// 		}
	// 		$noeventgroup = [];
	// 		/*
	// 		* $eventgrouparray will be builed up to an assocciative array with memberid as key and choiceid as value.
	// 		*/
	// 		$eventgrouparray = [];
	// 		shuffle($memberids);
	// 		foreach($memberids as $memberid) {
	// 			$placedingroup = false;
	// 			foreach($choicetemplate as $choiceid) {
	// 				/*
	// 				* For every choiceid in template in order from least popular till most popular.
	// 				* If member has that choice and if that choice hasn't reached the groupcap,
	// 				* Place member in that group. Increase number of members in that choicepool.
	// 				*/
	// 				if(in_array($choiceid, $memberchoices[$memberid])) {
	// 					if($choicepool[$choiceid] < $groupcap) {
	// 						$eventgrouparray[$memberid] = $choiceid;
	// 						$choicepool[$choiceid] += 1;
	// 						$placedingroup = true;
	// 						// break 1; // exit only the choicetemplate foreach
	// 					}
	// 				}
	// 			}
	// 			if(!$placedingroup) {
	// 				$noeventgroup[] = $memberid;
	// 			}
	// 		}
	// 		if(count($noeventgroup) < 1) {
	// 			$retrys = $retrycap;
	// 		} else {
	// 			$retrys++;
	// 		}
	// 	}
	//
	// 	/*
	// 	* Set the result into the database
	// 	*/
	// 	$divide->setDivideResult($eventid, $eventgrouparray);
	//
	//
	// 	return $noeventgroup;
	// }

	/**
	* Place members in event in eventgroups by total randomness.
	*
	* @param Integer event id
	* @param Array assocciated array sorted in ascending order ['choiceid' => number of least popular choice,...]
	* @param Array member ids
	* @param Integer max number of retrys
	* @param Integer max number per group
	*
	* @return void
	*/
	public function handleMemberchoicesNoTemplate($eventid, $choicetemplate, $memberids, $retrycap, $groupcap) {
		$divide = new Divideresult();
		$member = new Member();
		$retrys = 0;

		/*
		* $memberchoices is assocciative array with memberid as key and choices ids in array as value
		* [memberid => [choiceid, choiceid, choiceid,...], memberid => [choiceid, choiceid, choiceid], ...]
		* The choices for that member is only for this event with event id = $eventid
		*/
		// $memberchoices = $this->getMemberChoices($eventid);

		$memberinfo = $member->getMembersDivideInfo($memberids, $eventid);

		while($retrys < $retrycap) {
			// Setting up $choicetemplate
			$choicepool = [];
			foreach($choicetemplate as $choiceid => $number) {
				$choicepool[$choiceid] = 0;
			}
			$noeventgroup = [];
			/*
			* $eventgrouparray will be builed up to an assocciative array with memberid as key and choiceid as value.
			*/
			$eventgrouparray = [];
			shuffle($memberids);
			foreach($memberids as $memberid) {
				$placedingroup = false;

				// $thismemberschoices = $memberchoices[$memberid];
				$thismemberschoices = $memberinfo[$memberid]['choiceids'];
				shuffle($thismemberschoices);
				foreach($thismemberschoices as $choiceid) {
					if($choicepool[$choiceid] < $groupcap) {
						$eventgrouparray[$memberid] = $choiceid;
						$choicepool[$choiceid] += 1;
						$placedingroup = true;
						break 1; // exit only the choicetemplate foreach
					}
				}
				if(!$placedingroup) {
					$noeventgroup[] = $memberid;
				}
			}



			if(count($noeventgroup) < 1) {
				$retrys = $retrycap;
			} else {
				$retrys++;
			}
		}

		/*
		* Set the result into the database
		*/
		$divide->setDivideResult($eventid, $eventgrouparray);


		return $noeventgroup;
	}
}
