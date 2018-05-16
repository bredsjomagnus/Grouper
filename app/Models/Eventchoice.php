<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eventchoice extends Model
{
    // use SoftDeletes;
	public function deleteByChoiceid($choiceid) {
		$this::where('choiceid', $choiceid)->delete();
	}

	public function deleteByEventid($eventid) {
		$this::where('eventid', $eventid)->delete();
	}

	public function getAllEventChoicesIds($organization) {
		$choiceids = [];
		$res = $this::select('choiceid')
						->where('organization', $organization)
						->get();
		foreach($res as $row) {
			$choiceids[] = $row->choiceid;
		}

		return $choiceids;
	}
	public function getEventChoicesById($eventid) {
		$res = $this::select('choiceid')->where('eventid', $eventid)->get();

		$createdarray;
		foreach($res as $row) {
			$createdarray[] = $row->choiceid;
		}
		return $createdarray;
	}
}
