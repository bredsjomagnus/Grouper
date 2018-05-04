<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
	/*
	* id INT(11) AUTO_INCREMENT,
    * groupname VARCHAR(255),
    * organization VARCHAR(255),
	*/
	/**
	 * Get groups.
	 *
	 * @return object
	 */
	public function getGroups()
	{
		return $this::All();
	}
	/**
	 * Get a organizations different unique groups.
	 *
	 * @param String organization
	 *
	 * @return Object All groups beloning to $organization
	 */
	public function getGroupsBelongingToOrganization($organization) {
		return $this::All()->where('organization', $organization);
	}
	// ['member' => htmlspecialchars(trim($member))
	/**
	 * Create new group by adding an array of members to table
	 *
	 * @param String $groupname - groups groupname
	 * @param Array $members - members in new group
	 *
	 * @return Integer id of last inserted group.
	 */
	public function addGroup($groupname, $organization) {
		return $this::insertGetId(['groupname' => $groupname, 'organization' => $organization]);
	}
	/**
	* Check if choosen groupname already exists. If it does returns true.
	*
	* @param String groupname
	* @param String organization
	* @return Boolean true if gropname exists
	*/
	public function groupNameExists($groupname, $organization) {
		// Get all results where groupname is the choosen groupname
		$res = $this::All()->where('groupname', $groupname)->where('organization', $organization);
		return !$res->isEmpty();
	}

	public function getGroupName($id) {
		return $this::find($id);
	}

	public function getGroupSize() {
		// selects groups by groupid and count them to get each groupsize
		// i nuläget summerar den ALLA grupperna. Måste eventuellt se till att den bara summerar grupperna
		// som tillhör just den aktuella organisationen.
		$groupsizes = DB::table('groupmembers')
                 		->select('groupid', DB::raw('count(*) as numberofmembers'))
                 		->groupBy('groupid')
                 		->get();

		return $groupsizes;
	}

	/**
	* Edit a groups name
	*
	* @param Integer $groupid - group id
	* @param String $newname - new group name
	*
	* @return void
	*/
	public function editGroupName($groupid, $newname) {
		$group = $this::find($groupid);
		$group->groupname = $newname;
		$group->save();
	}
}
