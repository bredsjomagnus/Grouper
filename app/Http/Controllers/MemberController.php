<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member as Member;
use App\Models\Group as Group;

class MemberController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function editMemberProcess($id) {
		$member 	= new Member();
		$membername = $_POST['newvalue'];
		$groupid	= $_POST['groupid'];

		/*-----------------------------------*/

		$member->editMemberMembername($id, $membername);
		return redirect("/groups/edit/".$groupid);
	}

	public function addMemberProcess() {
		$member 	= new Member();
		$membername = htmlspecialchars(trim($_POST['newvalue']));
		$groupid	= $_POST['groupid'];

		/*-----------------------------------*/

		if(strlen($membername) > 0) {
			$member->addMembers([$membername], $groupid);
		}


		/*-----------------------------------*/

		return redirect("/groups/edit/".$groupid);
	}

	public function deleteMember($id) {
		$member		= new Member();
		$groupid	= $_GET['groupid'];

		/*-----------------------------------*/

		$groupmembersrow = $member->deleteMember($id, $groupid);

		return redirect("/groups/edit/".$groupid);
	}

	public function moveMember() {
		$member		= new Member();
		$memberid	= $_GET['member'];
		$fromgroup	= $_GET['from'];
		$togroup	= $_GET['to'];

		/*-----------------------------------*/

		$member->moveMember($memberid, $fromgroup, $togroup);

		/*-----------------------------------*/

		return redirect("/groups/edit/".$fromgroup);
	}
}
