<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group as Group;

class PageController extends Controller
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
    public function groups()
    {
		$group = new Group();

		$data = [
			"groups"	=> $group->getGroups()
		];
        return view('groups.index', $data);
    }
}
