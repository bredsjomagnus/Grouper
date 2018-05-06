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
    public function addChoices() {

		/*-----------------------------------*/

		$data = [];

		/*-----------------------------------*/

		return view('choice.addchoices', $data);
	}

	public function addChoicesConfirm() {
		$file 				= file_get_contents($_FILES['file']['tmp_name']);
		$csvarray 			= explode(PHP_EOL, $file);

		/*-----------------------------------*/

		$data = [
			'choices'	=> array_filter($csvarray)
		];

		/*-----------------------------------*/

		return view('choice.addchoices', $data);
	}

	public function addChoicesProcess(Request $request) {
		$choice		= new Choice;
		$choices 	= $request->input('choices');

		/*-----------------------------------*/

		$choice->addChoices($choices, 'Klockarhagsskolan');

		/*-----------------------------------*/

		return redirect("/groups");
	}
}
