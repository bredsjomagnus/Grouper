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
		// $difftospread = 100-5*$numberofchoices;

		$weightarray = [];
		// $basenumber = 1;
		foreach($choicesids as $choice) {
			$weightarray[] = 1;
			// $basenumber++;
		}

		while(array_sum($weightarray) < 100){
			$index = rand(0, $maxindex);
			$weight = rand(1, 3);
			$weightarray[$index] += $weight;
		}

		// final pruning so that the sum of all percentvalues equals 100.
		$i = 0;
		while(array_sum($weightarray) > 100) {

			//restart cycle
			if($i == (count($weightarray) - 1)) {
				$i = 0;
			}

			//take away one and move to next
			$weightarray[$i] -= 1;
			$i++;
		}

		// $this->switchArray($weightarray);
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
	public function randomChoices($eventid, $memberids, $choiceids, $switcharray, $choosingnumber, $organization) {
		$numberofchoices = $choosingnumber;
		foreach($memberids as $member) {
			$memberchoices = [];
			while(count($memberchoices) < $numberofchoices) {
				$notchoosen = true;
				while($notchoosen) {
					$rand = rand(1, 100);
					for($i = 0; $i < count($switcharray)-1; $i++) {
						if($rand >= $switcharray[$i] && $rand <= $switcharray[$i+1]) {
							if(!in_array($choiceids[$i], $memberchoices)) {
								if(count($memberchoices) < $numberofchoices) {
									$memberchoices[] = $choiceids[$i];
									$notchoosen = false;
								}
							}
						}
					}
				}
			}
			foreach($memberchoices as $choiceid) {
				$group = DB::table('groupmembers')->select('groupid')
													->where('memberid',$member)
													->get();
				DB::table('memberchoices')->insert(
						[
							'eventid'		=> $eventid,
							'memberid' 		=> $member,
							'choiceid'		=> $choiceid,
							'groupid'		=> $group[0]->groupid,
							'organization'	=> $organization
						]
					);
			}
		}
	}
}
