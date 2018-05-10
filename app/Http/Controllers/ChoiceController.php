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

	public function addChoiceProcess(Request $request) {
		$choice		= new Choice;
		$choices 	= $request->input('choice');

		/*-----------------------------------*/

		$choice->addChoice($choices, 'Klockarhagsskolan');

		/*-----------------------------------*/

		return redirect('/choices/edit');
	}

	public function deleteChoicesProcess($id) {
		$choice 	= new Choice;
		$choice->deleteChoice($id);

		// return redirect("/groups");
		return back();
	}

	public function editChoices() {
		$choice 		= new Choice;
		$choices 		= $choice->getAllChoices();

		$data = [
			"choices"	=> $choices
		];
		return view('choice.edit', $data);
	}

	public function editChoicesProcess($id) {
		$choice		= new Choice;
		$newname	= $_POST['newvalue'];
		$choice->editChoice($id, $newname);


		return redirect('/choices/edit');
	}
}
