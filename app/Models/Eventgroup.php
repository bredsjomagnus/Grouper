<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eventgroup extends Model
{
    // use SoftDeletes;

	public function getEventGroupsIds($organization) {
		$groupids = [];
		$res = $this::select('groupid')
						->where('organization', $organization)
						->get();
		foreach($res as $row) {
			$groupids[] = $row->groupid;
		}

		return $groupids;
	}

	public function deleteByEventid($eventid) {
		$this::where('eventid', $eventid)->delete();
	}
}
