<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    public function addChoices($choices, $organization) {
		foreach($choices as $choice) {
			$memberid = $this::insert(['choicename' => htmlspecialchars(trim($choice)), 'organization' => $organization]);
		}
	}

	public function getChoicesBelongingToOrganization($organization) {
		return $this::All()->where('organization', $organization);
	}
}
