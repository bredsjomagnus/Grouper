<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    public function createEvent($eventname, $organization, $groups, $choices) {
		$eventid = $this::insertGetId(['eventname' => $eventname, 'organization' => $organization]);

		foreach($groups as $group) {
			DB::table('eventgroups')->insert(
					[
						'eventid'	=> $eventid,
						'groupid' 	=> $group
					]
				);
		}

		foreach($choices as $choice) {
			DB::table('eventchoices')->insert(
					[
						'eventid'	=> $eventid,
						'choiceid' 	=> $choice
					]
				);
		}
	}

	public function getEventsBelongingToOrganization($organization) {
		return $this::All()->where('organization', $organization);
	}
}
