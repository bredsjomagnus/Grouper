<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group as Group;
use App\Models\Member as Member;

class GroupController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function groupsDashboard()
    {
		$group 		= new Group();
		$groups 	= $group->getGroupsBelongingToOrganization("Klockarhagsskolan");

		/*----------------------------*/

		$data = [
			"groups"	=> $groups
		];

        return view('groups.dashboard', $data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addGroup()
    {
		// Data to fill up variables when coming from dashboard.
		$data = [
			"members" 			=>	[],
			"groupnameexists"	=> false
		];
        return view('groups.addgroup', $data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addGroupConfirm()
    {
		$group				= new Group();
		$groupname 			= $_POST['groupname'];

		// PHP_EOL build array with End Of Line as delimiter
		// array_filter trims array so that empty elements is removed
		$file 				= file_get_contents($_FILES['file']['tmp_name']);
		$csvarray 			= explode(PHP_EOL, $file);

		$groupnameexists 	= $group->groupNameExists($groupname, "Klockarhagsskolan");

		/*----------------------------*/

		$data = [
			"members"			=> array_filter($csvarray),
			"groupname"			=> $groupname,
			"groupnameexists"	=> $groupnameexists
		];
		return view('groups.addgroup', $data);
    }

    /**
     * Create new group and add members to it
     *
     * @return \Illuminate\Http\Response
     */
    public function addGroupProcess()
    {
		$group 		= new Group();
		$member		= new Member();
		$members 	= $_POST['members'];
		$groupname 	= $_POST['groupname'];

		/*----------------------------*/

		$groupid 	= $group->addGroup($groupname, 'Klockarhagsskolan');
		$member->addMembers($members, $groupid);

		return redirect("/groups");
    }

	public function editGroup($groupid) {
		$group		= new Group();
		$member		= new Member();

		/*----------------------------*/

		$groupres	= $group->getGroupName($groupid);
		$members	= $member->getMembers($groupid); // associative array [id => membername, ...]

		/*----------------------------*/

		$data = [
			"group"		=> $groupres,
			"members"		=> $members
		];

		return view('groups.edit', $data);
	}

}
