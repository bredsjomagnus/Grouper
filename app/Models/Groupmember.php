<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Member as Member;

class Groupmember extends Model
{
	/*
	* This model is to link groups to members.
	*/
    // use SoftDeletes;

	/**
	* Get all groupmembers with groupid, memberid and membername in array.
	*
	* @param Array groupids [groupid, groupid,...]
	*
	* @return Array members ['groupid' => groupid, 'memberid' => memberid, 'membername']
	*/
	public function getGroupMembersByIds($groupids) {
		$member = new Member;
		$members = [];
		foreach($groupids as $groupid) {
			$res = $this::select('memberid')->where('groupid', $groupid)->get();
			foreach($res as $row) {
				$memberrow = $member::find($row->memberid);
				$members[] = [
					"groupid"		=> $groupid,
					"memberid"		=> $row->memberid,
					"membername"	=> $memberrow->membername
				];
			}

		}
		return $members;
	}
	
}
