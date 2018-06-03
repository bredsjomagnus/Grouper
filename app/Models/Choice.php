<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Eventchoice as Eventchoice;

class Choice extends Model
{
	use SoftDeletes;

	public function addChoices($choices, $organization) {
		foreach($choices as $choice) {
			$alreadyexists = $this::All()->where('choicename', $choice);
			if($alreadyexists->isEmpty()) {
				$this::insert(['choicename' => htmlspecialchars(trim($choice)), 'organization' => $organization]);
			}

		}
	}

    public function addChoice($choice, $organization) {
		$alreadyexists = $this::All()->where('choicename', $choice);
		if($alreadyexists->isEmpty()) {
			$this::insert(['choicename' => htmlspecialchars(trim($choice)), 'organization' => $organization]);
		}
	}

	public function getChoicesBelongingToOrganization($organization) {
		return $this::All()->where('organization', $organization);
	}

	public function deletechoice($id) {
		$this::find($id)->delete();
	}

	public function getChoice($id) {
		return $this::find($id);
	}

	public function getAllChoices() {
		return $this::All();
	}

	public function getChoicesByIds($chouiceids) {
		$choices = [];

		foreach($chouiceids as $choiceid) {
			$res = $this::find($choiceid);
			$choices[] = [
				"choiceid"		=> $choiceid,
				"choicename"	=> $res->choicename
			];
		}
		return $choices;
	}

	public function getChoicesByIdsAssociative($choiceids) {
		$choices = [];

		foreach($choiceids as $choiceid) {
			$res = $this::find($choiceid);
			$choices[$choiceid] = $res->choicename;
		}
		return $choices;
	}

	public function editChoice($id, $newname) {
		$choice = $this::find($id);
		$choice->choicename = $newname;
		$choice->save();
	}
}
