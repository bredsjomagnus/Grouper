<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Group as Group;

class Event extends Model
{
    public function createEvent($eventname, $organization, $groups, $choices) {
		$eventid = $this::insertGetId(['eventname' => $eventname, 'organization' => $organization]);

		foreach($groups as $group) {
			DB::table('eventgroups')->insert(
					[
						'eventid'		=> $eventid,
						'groupid' 		=> $group,
						'organization'	=> $organization
					]
				);
		}

		foreach($choices as $choice) {
			DB::table('eventchoices')->insert(
					[
						'eventid'		=> $eventid,
						'choiceid' 		=> $choice,
						'organization'	=> $organization
					]
				);
		}
	}

	public function getEventsBelongingToOrganization($organization) {
		return $this::All()->where('organization', $organization);
	}

	/**
	* Get number of groups in event belonging to certain organization.
	* By default all events in an organization.
	*
	* @param String organization
	* @param Integer id of event, by default all events belonging to organization.
	*
	* @return Object result with columns [eventid, numberofgroups]
	*/
	public function getNumberOfGroups($organization, $id="'%%'") {
		$numberofgroups = DB::select(
							DB::raw(
								"SELECT eventid, count(eventid) AS numberofgroups FROM eventgroups WHERE eventid LIKE ".$id." AND organization LIKE '".$organization."' GROUP BY eventid"
							));
		return $numberofgroups;
	}

	/**
	* Get sum of members in event belonging to certain organization.
	* By default all events in an organization.
	*
	* @param String organization
	* @param Integer id of event, by default all events belonging to organization.
	*
	* @return Array assocciative array [eventid => total number of members, ...]
	*/
	public function getNumberOfMembers($organization, $id='%%') {
		$group				= new Group();
		$numberofmembers	= [];

		$eventgroups 	= DB::table('eventgroups')
								->select('*')
								->where('eventid', 'LIKE', $id)
								->where('organization', $organization)
								->get();

		foreach($eventgroups as $eventgroup) {
			$groupsize = $group->getGroupSize($organization, $eventgroup->groupid);
			if(!array_key_exists($eventgroup->eventid, $numberofmembers)) {
				$numberofmembers[$eventgroup->eventid] = $groupsize[0]->numberofmembers;
			} else {
				$numberofmembers[$eventgroup->eventid] = $numberofmembers[$eventgroup->eventid] + $groupsize[0]->numberofmembers;
			}
		}

		return $numberofmembers;
	}

	/**
	* Get number of choices for event beloning to certain orgainization.
	* By default all events in an orgainization.
	*
	* @param String orgainization
	* @param Integer id of event, by default alla events belonging to orgainization
	*
	* @return Object result with columns [eventid, numberofchoices]
	*/
	public function getNumberOfChoices($organization, $id="'%%'") {
		$numberofchoices = DB::select(
							DB::raw(
								"SELECT eventid, count(eventid) AS numberofchoices FROM eventchoices WHERE eventid LIKE ".$id." AND organization LIKE '".$organization."' GROUP BY eventid"
							));
		return $numberofchoices;
	}
}
