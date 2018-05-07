<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    public function addChoices($choices, $organization) {
		foreach($choices as $choice) {
			$this::insert(['choicename' => htmlspecialchars(trim($choice)), 'organization' => $organization]);
		}
	}

    public function addChoice($choice, $organization) {
		$this::insert(['choicename' => htmlspecialchars(trim($choice)), 'organization' => $organization]);
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

	public function editChoice($id, $newname) {
		$choice = $this::find($id);
		$choice->choicename = $newname;
		$choice->save();
	}
}
