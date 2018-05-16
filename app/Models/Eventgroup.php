<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eventgroup extends Model
{
    // use SoftDeletes;

	/**
	* Get all group ids in event in an organization.
	*
	*/
	public function getAllEventGroupsIds($organization) {
		$res = $this::select('groupid')
						->where('organization', $organization)
						->get();

		$groupids = $this->makeArrayfromRes($res);

		return $groupids;
	}

	/**
	* Get an events groupids.
	*
	* @param Integer eventid
	* @param Boolean to array setting. Default set to true
	*
	* @return Object if to array set to false
	* @return Array if to array set to true.
	*/
	public function getEventGroupsById($eventid, $toarray = true) {
		$res = $this::select('groupid')->where('eventid', $eventid)->get();

		$createdarray;
		foreach($res as $row) {
			$createdarray[] = $row->groupid;
		}
		return $createdarray;
	}

	public function deleteByEventid($eventid) {
		$this::where('eventid', $eventid)->delete();
	}

	public function makeArrayfromRes($res) {
		$createdarray = [];
		foreach($res as $row) {
			$createdarray[] = $row->groupid;
		}
		return $createdarray;
	}
}
