<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Group as Group;
use App\Models\Member as Member;
use App\Models\Choice as Choice;
use App\Models\Event as Event;
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
		$choice		= new Choice();
		$event		= new Event();

		/*----------------------------*/

		$choices	= $choice->getChoicesBelongingToOrganization('Klockarhagsskolan');

		$groups 	= $group->getGroupsBelongingToOrganization("Klockarhagsskolan");
		$groupsizes	= $group->getGroupSize();

		$events		= $event->getEventsBelongingToOrganization('Klockarhagsskolan');

		/*----------------------------*/

		$data = [
			"groups"		=> $groups,
			"choices"		=> $choices,
			"events"		=> $events,
			"groupsizes"	=> $groupsizes,
			"counter"		=> 0
		];

		return view('groups.dashboard', $data);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addGroups()
    {
		// Data to fill up variables when coming from dashboard.
		$data = [
			"members" 			=>	[],
			"groupnameexists"	=> false
		];
        return view('groups.addgroups', $data);
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
		return view('groups.addgroups', $data);
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

	/**
	* Get to view where one can edit a group
	*
	*/
	public function editGroup($groupid) {
		$group		= new Group();
		$member		= new Member();
		/*----------------------------*/
		$groupres	= $group->getGroupName($groupid);
		$members	= $member->getMembers($groupid); // associative array [id => membername, ...]
		$groups		= $group->getGroupsBelongingToOrganization('Klockarhagsskolan');
		/*----------------------------*/
		$data = [
			"group"		=> $groupres,
			"members"	=> $members,
			"groups"	=> $groups,

		];
		return view('groups.edit', $data);
	}

	/**
	* The process to edit a groups name
	*
	*/
	public function editGroupName() {
		$group 		= new Group();
		$newgroupname	= $_POST['newvalue'];
		$groupid 		= $_POST['groupid'];
		/*----------------------------*/

		// Just nu en boolean som inte skickas ut till vyn. Fixar det sen.
		// Den finns för att kunna meddela om ett namnbyte kunde fixas eller ej
		// beroende på om namnet redan existerar eller inte.
		$successfullnamechange = $group->editGroupName($groupid, $newgroupname, 'Klockarhagsskolan');
		/*----------------------------*/
		return redirect("/groups/edit/".$groupid);
	}

	/**
	* Delete a group along with all it's memebers
	*/
	public function deleteGroupProcess($groupid) {
		$group 		= new Group();

		$group->deleteGroup($groupid);

		$groups 	= $group->getGroupsBelongingToOrganization("Klockarhagsskolan");
		$groupsizes	= $group->getGroupSize();

		/*----------------------------*/

		$data = [
			"groups"		=> $groups,
			"groupsizes"	=> $groupsizes,
			"counter"		=> 0
		];

		return view('groups.dashboard', $data);
	}
}
