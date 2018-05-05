<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Choice as Choice;

class ChoiceController extends Controller
{
	/**
	* Add choice to database
	*
	*/
    public function addChoice() {

		/*-----------------------------------*/

		$data = [];

		/*-----------------------------------*/
		return view('choice.add', $data);
	}
}
