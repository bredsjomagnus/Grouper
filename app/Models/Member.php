<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Member as Member;

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
	*
	* @return void
	*/
    public function addMembers($members, $groupid) {
		foreach($members as $member) {
			$memberid = $this::insertGetId(['membername' => htmlspecialchars(trim($member))]);
			DB::insert('insert into groupmembers (groupid, memberid) values (?, ?)', [$groupid, $memberid]);
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
		$members = $this->getMembersByIds($groupmembers);

		return $members;
	}

	public function getMembersByIds($groupmembers) {
		$members = [];
		foreach($groupmembers as $groupmember) {
			$member = $this::find($groupmember->memberid);
			$members[$member->id] = $member->membername;
		}
		return $members;
	}

	public function editMemberMembername($id, $newmembername) {
		$member = $this::find($id);
		$member->membername = $newmembername;
		$member->save();
	}
}
