<?php
namespace App\Src;

use Illuminate\Support\Facades\DB;
use App\Models\Member as Member;

class Dev
{
	/**
	* Build a random weight array for randomizing choices.
	* Values represent percent for a choice. The sum is 100%.
	*
	* @param Array choice ids
	*
	* @return Array with weight [integer, integer, integer,...]
	*/
	public function weightArray($choicesids) {
		$numberofchoices = count($choicesids);
		$maxindex = $numberofchoices-1;
		$difftospread = 100-5*$numberofchoices;

		$weightarray = [];
		$basenumber = 1;
		foreach($choicesids as $choice) {
			$weightarray[] = 1;
			$basenumber++;
		}

		while(array_sum($weightarray) < 100){
			$index = rand(0, $maxindex);
			$weight = rand(1, 10);
			$weightarray[$index] += $weight;
		}

		// final pruning so that the sum of all percentvalues equals 100.
		$i = 0;
		while(array_sum($weightarray) > 100) {
			if($i == (count($weightarray) - 1)) {
				$i = 0;
			}
			$weightarray[$i] -= 1;
			$i++;
		}

		$this->switchArray($weightarray);
		return $weightarray;
	}

	/**
	* Takes a weightarray and turns it inte a switcharray.
	* eg. $weightarray = [10, 30, 10, 40, 10] will generate
	* $switcharray = [1, 10, 40, 50, 90, 100]
	*
	* @param Array weightarray with percentages for every choice
	*
	* @return Array switcharray with sum progression of every choice.
	*/
	public function switchArray($weightarray) {
		$switcharray = [];
		for($i = 0; $i < count($weightarray); $i++) {
			if($i == 0) {
				$switcharray[] = 0;
			} else {
				$switcharray[] = $switcharray[$i-1] + $weightarray[$i-1];
			}
		}
		$switcharray[] = 100;
		return $switcharray;
	}

	/**
	* Randomize choices for members in event.
	* First calculating number of choices in Event depending on weighted values.
	* Then shuffel members and randomly select choices and drawing choices out of the choice pools
	*
	* @param Array member ids [memberid, memberid,...]
	* @param Array choice ids [choiceid, choiceid,...]
	* @param Array weighted values with percent chance [percent of first choice, percent of second choice,...]
	*
	*/
	public function randomChoices($memberids, $choiceids, $weightarray) {
		$numberofmembers = count($memberids);
		$numberofchoices = count($choiceids);
		$numberchoicespermember = 5;

		// Filling choicepool with number of choices for every choice;
		// $choicepool = [choiceid => number of this choice, choiceid => number of this choice,...]
		$choicepool = [];
		$counter = 0;
		while(array_sum($choicepool) < ($numberofmembers)) {
			foreach($choiceids as $choiceid) {
				$choicepool[$choiceid] = ceil($numberofmembers * $weightarray[$counter]/100);
				$counter++;
			}
		}

		// shuffle($memberids);
		// $memberchoices = [];
		// foreach($memberids as $memberid) {
		// 	$choosen = [];
		// 	while(count($choosen) < $numberchoicespermember) {
		// 		$choice = rand(0, $numberofchoices-1);
		// 		if(!in_array($choice, $choosen)) {
		// 			// if($choicepool[$choiceids[$choice]] > 0) {
		// 			// 	$memberchoices[$memberid][] = $choiceids[$choice];
		// 			// 	$choicepool[$choiceids[$choice]] = $choicepool[$choiceids[$choice]] - 1;
		// 			// 	$numbercounter--;
		// 			// 	$choosen[] = $choice;
		// 			// }
		// 			if($choicepool[$choiceids[$choice]] > 0) {
		// 				$memberchoices[$memberid][] = $choiceids[$choice];
		//
		// 				// denna raden gör att det kraschar eftersom att det är stor riska att det inte finns några val kvar
		// 				$choicepool[$choiceids[$choice]] = $choicepool[$choiceids[$choice]] - 1;
		// 				$choosen[] = $choice;
		// 			}
		//
		// 		}
		// 	}
		// }

		$memberchoices = [];
		foreach($choicepool as $choiceid => $pool) {
			shuffle($memberids);
			$counter = 0;
			// while($pool > 0) {
			// 	$memberchoices[$memberids[$counter]][] = $choiceid;
			// 	$pool--;
			// 	$counter++;
			// }
		}


		return $choicepool;
	}
}
