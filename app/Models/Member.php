<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

// use App\Models\Member as Member;
use App\Models\Group as Group;
use App\Models\Memberchoice as Memberchoice;

class Member extends Model
{
	/*
	* id INT(11) AUTO_INCREMENT,
	* membername VARCHAR(255),
	*/

	/**
	* Add new members to table and to table 'groupmemers'
	*
	* @param Array members to add to table.
	* @param Integer id of group members is associated to
	* @param String organization for with the members is part of
	*
	* @return void
	*/
    public function addMembers($members, $groupid, $organization) {
		foreach($members as $member) {
			$memberid = $this::insertGetId(['membername' => htmlspecialchars(trim($member)), 'organization' => $organization]);
			DB::insert('insert into groupmembers (groupid, memberid, organization) values (?, ?, ?)', [$groupid, $memberid, $organization]);
		}
	}

	/**
	* Get members in a group
	*
	* @param Integer group id
	*
	* @return Array group members
	*/
	public function getMembers($groupid) {
		$groupmembers = DB::table('groupmembers')->where('groupid', $groupid)->get();
		$members = $this->getMembersByObject($groupmembers);

		return $members;
	}

	/**
	* Get members of a group by object via table groupmembers
	*
	* @param Object groupmembers {id, groupid, memberid} from one group
	*
	* @return Array groupmembers ['id' => 'membername', ...]
	*/
	public function getMembersByObject($groupmembers) {
		$members = [];
		foreach($groupmembers as $groupmember) {
			$member = $this::find($groupmember->memberid);
			$members[$member->id] = $member->membername;
		}
		return $members;
	}

	public function getMembersByIds($memberids) {
		$members = [];

		foreach($memberids as $memberid) {
			$res = $this::find($memberid);
			$members[$memberid] = $res->membername;
		}
		return $members;
	}

	public function getMembersDivideInfo($memberids, $eventid) {
		$memberchoice = new Memberchoice();

		$members = [];
		$memberchoices = $memberchoice->getMemberChoices($eventid);
		foreach($memberids as $memberid) {
			$group = new Group();
			$res = $this::find($memberid);
			$groupmemberres = DB::table('groupmembers')
				->where('memberid', $memberid)
				->get();
			$groupname = $group->getGroupnameById($groupmemberres[0]->groupid);

			$choicenames = [];
			foreach($memberchoices[$memberid] as $memchoiceid) {
				$choicename = DB::table('choices')->where('id', $memchoiceid)->get();
				$choicenames[] = $choicename[0]->choicename;
			}

			$members[$memberid] = [
				"membername"	=> $res->membername,
				"groupname"		=> $groupname,
				"choiceids"		=> $memberchoices[$memberid],
				"choicenames"	=> $choicenames
			];
		}
		return $members;
	}

	/**
	* Edit members name.
	*
	* @param Integer id of member
	* @param String new membername
	*
	* @return void
	*/
	public function editMemberMembername($id, $newmembername) {
		$member = $this::find($id);
		$member->membername = $newmembername;
		$member->save();
	}

	/**
	* Delete member from tables 'member' and 'groupmembers'
	*
	* @param Integer id of member to delete
	* @param Integer id of group from with member is being deleted
	*
	* @return void
	*/
	public function deleteMember($id, $groupid) {
		/* First checking if member is part of other groups
		* If so just delete member from current group,
		* otherwise, if this was the only group for that
		* member, delete member from both 'groupmembers'
		* and from 'members'.
		*/
		$numberofgroups = DB::table('groupmembers')->where('memberid', $id)->count();
		if($numberofgroups > 1) {
			$groupmembersrow = DB::table('groupmembers')->where('groupid', $groupid)->where('memberid', $id)->delete();
			// $groupmembersrow->delete();
		} else {
			$groupmembersrow = DB::table('groupmembers')->where('groupid', $groupid)->where('memberid', $id)->delete();
			$this::find($id)->delete();
		}
	}

	public function moveMember($memberid, $fromgroup, $togroup, $organization) {
		DB::table('groupmembers')->where('groupid', $fromgroup)->where('memberid', $memberid)->delete();
		DB::insert('insert into groupmembers (groupid, memberid, organization) values (?, ?, ?)', [$togroup, $memberid, $organization]);
	}

}
