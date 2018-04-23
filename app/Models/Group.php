<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	/**
	 * Get groups.
	 *
	 * @return array
	 */
	public function getGroups()
	{
		return $this::All();
	}
}
