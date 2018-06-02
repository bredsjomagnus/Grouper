<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Groupmember as Groupmember;

class Eventgroup extends Model
{
	/*
	* This group is to link all the groups an event contains.
	*/

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
	* @return Array if to array set to true. [groupid, groupid,...]
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

	/**
	* Get all memberids that is in an event.
	*
	* @param Integer event id.
	*
	* @return Array members ids [memberid, memberid,...]
	*/
	public function getMemberIdsInEvent($eventid) {
		$groupmember = new Groupmember;

		$groupids = $this->getEventGroupsById($eventid);
		$members = $groupmember->getGroupMembersByIds($groupids);

		$memberids = [];
		foreach($members as $member) {
			$memberids[] = $member['memberid'];
		}
		return $memberids;
	}

}
