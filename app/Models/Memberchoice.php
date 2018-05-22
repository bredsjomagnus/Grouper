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

	public function getStatisticsForEvent($eventid) {
		$res = DB::select(
				DB::raw(
					"SELECT choiceid, COUNT(choiceid) AS numberofachoice FROM memberchoices WHERE eventid LIKE '".$eventid."' AND organization LIKE 'Klockarhagsskolan' GROUP BY choiceid;"
					)
			);

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

		// '"data": [{
		// 					"label": "Consumer general",
		// 					"value": "13"
		// 				  }, {
		// 					"label": "Enterprise internal app",
		// 					"value": "83.7"
		// 				  }, {
		// 					"label": "Progressive Web Apps",
		// 					"value": "25.1"
		// 				  }, {
		// 					"label": "Consumer social network",
		// 					"value": "24"
		// 				  }, {
		// 					"label": "Desktop web apps",
		// 					"value": "18.5"
		// 				  }, {
		// 					"label": "Desktop apps (electron, etc)",
		// 					"value": "12.3"
		// 				  }, {
		// 					"label": "Consumer chat",
		// 					"value": "12.2"
		// 				  }, {
		// 					"label": "Other",
		// 					"value": "4.5"
		// 				}]'
		$barvalue = substr($barvalue, 0, -1);
		$barvalue .= ']';

		return $barvalue;
	}
}
