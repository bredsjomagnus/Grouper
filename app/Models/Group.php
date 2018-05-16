<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Member as Member;

class Group extends Model
{
	use SoftDeletes;
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
	* Get groups by groupid.
	*
	* @param Array $groupids
	*
	* @return Array ['groupid' => groupid, 'groupname' => groupname]
	*/
	public function getGroupsByIds($groupids) {
		$groups = [];

		foreach($groupids as $groupid) {
			$res = $this::find($groupid);
			$groups[] = [
				"groupid"	=> $groupid,
				"groupname"	=> $res->groupname
			];
		}
		return $groups;
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

	/**
	* Gets number of members of a group. By default all groups of an organization
	*
	* @param String the organization for the groups
	* @param Integer the id of the group that will be checked for group size. By default all groups.
	*
	* @return Object With all requested groups group sizes - columns [groupid, numberofmembers]
	*/
	public function getGroupSize($organization, $id="'%%'") {
		// selects groups by groupid and count them to get each groupsize
		// i nuläget summerar den ALLA grupperna. Måste eventuellt se till att den bara summerar grupperna
		// som tillhör just den aktuella organisationen.
		// $groupsizes = DB::table('groupmembers')
        //          		->select('groupid', DB::raw('count(*) as numberofmembers'))
        //          		->groupBy('groupid')
        //          		->get();

		$groupsizes = DB::select(
						DB::raw(
							"SELECT groupid, count(groupid) AS numberofmembers FROM groupmembers WHERE groupid LIKE ".$id." AND organization LIKE '".$organization."' GROUP BY groupid"
							));
		return $groupsizes;
	}

	/**
	* Edit a groups name if there is no other group in the organization with that new name
	*
	* @param Integer $groupid - group id
	* @param String $newname - new group name
	*
	* @return Boolean if successfull or not
	*/
	public function editGroupName($groupid, $newname, $organization) {
		$success = false;
		if(!$this->groupNameExists($newname, $organization)) {
			$group = $this::find($groupid);
			$group->groupname = $newname;
			$group->save();
			$success = true;
		}

		return $success;
	}

	/**
	* Delete group along with all its memebers
	*
	* @param Integer $groupid - group id
	*
	* @return void
	*/
	public function deleteGroup($groupid) {
		$member = new Member();
		$res = DB::table('groupmembers')
									->where('groupid', $groupid)
									->get();
		foreach($res as $row) {
			$member->deleteMember($row->memberid, $groupid);
		}

		$this::find($groupid)->delete();
	}
}
