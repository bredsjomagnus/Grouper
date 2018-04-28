<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member as Member;

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
		$membername = $_POST['newvalue'];
		$groupid	= $_POST['groupid'];

		/*-----------------------------------*/

		$member->addMembers([$membername], $groupid);
		
		return redirect("/groups/edit/".$groupid);
	}
}
