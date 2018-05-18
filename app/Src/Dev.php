<?php
namespace App\Src;

use Illuminate\Support\Facades\DB;
use App\Models\Member as Member;

class Dev
{
	/**
	* Build a random weight array for randomizing choices
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

		return $weightarray;
	}
}
