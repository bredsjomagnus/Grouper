function markmember(memberid, memberchoices) {
	// array of this memebers choices ids.
	choicesarray = memberchoices.split(";");

	$(".divide-paneldiv-choice").addClass('divide-paneldiv').removeClass('divide-paneldiv-choice');
	/*
	* If memberdiv already got active class just remove it.
	* else toggle class from active to not active and vice verse.
	*/
	if($("#"+memberid).hasClass('divide-paneldiv-active')){
		$(".divide-paneldiv-active").addClass('divide-paneldiv').removeClass('divide-paneldiv-active');
		$(".choice-column-active").addClass('choice-column').removeClass('choice-column-active');
		$(".movemembershow").addClass('movememberhidden').removeClass('movemembershow');
	} else {
		$(".divide-paneldiv-active").addClass('divide-paneldiv').removeClass('divide-paneldiv-active');
		$("#"+memberid).addClass('divide-paneldiv-active').removeClass('divide-paneldiv');

		$(".movememberhidden").addClass('movemembershow').removeClass('movememberhidden');

		$(".choice-column-active").addClass('choice-column').removeClass('choice-column-active');
		choicesarray.forEach(function(choice) {
			$("#choice_"+choice).addClass('choice-column-active').removeClass('choice-column');
		  	// console.log(choice);
		});
	}
}
/**
* Get memberchoices from database.
*
*/
function markchoice(choiceid, eventid) {
	if($("#choice_"+choiceid).hasClass('choice-column-active')){
		// Just turn of active classes
		$(".choice-column-active").addClass('choice-column').removeClass('choice-column-active');
		$(".divide-paneldiv-active").addClass('divide-paneldiv').removeClass('divide-paneldiv-active');
		$(".divide-paneldiv-choice").addClass('divide-paneldiv').removeClass('divide-paneldiv-choice');
	} else {
		// Get members choices from database
		var divideretrieveurl = "http://localhost/Programmering/Gruppindelare/Grouper/public/divide/retrieve/"+eventid;
		$.ajax({
		    type:     "get",
		    url:      divideretrieveurl,
		    dataType: "json",
		    success: function (response) {
				// response is jsonstring {msg: this is a get response, data: members choices}
				iterateMemberChoices(response.data, choiceid);
		    },
			error: function(xhr, status, error) {
			  alert(xhr.responseText);
			}
		});
	}
}

function iterateMemberChoices(memberchoices, choiceid) {
	// Make jsonstring into jsonobject.
	let memberchoicesJSON = JSON.parse(memberchoices);

	// Reset active classes
	$(".divide-paneldiv-active").addClass('divide-paneldiv').removeClass('divide-paneldiv-active');
	$(".choice-column-active").addClass('choice-column').removeClass('choice-column-active');
	$(".divide-paneldiv-choice").addClass('divide-paneldiv').removeClass('divide-paneldiv-choice');
	$("#choice_"+choiceid).addClass('choice-column-active');

	// Iterate over memberchoices.and find with memeber has this choice
	Object.entries(memberchoicesJSON).forEach(function([key, value]) {
		if(value.indexOf(choiceid) != -1) {
			// light up members with this choice
			$("#"+key).addClass('divide-paneldiv-choice').removeClass('divide-paneldiv');
		}
	});
}

function moveMember(choiceid, eventid) {
	/*
	* Redirecting to /divide/move with query string with info that change database and move member.
	*/
	let movingmember = $('.divide-paneldiv-active').attr( "id" );
	var dividemoveurl = "http://localhost/Programmering/Gruppindelare/Grouper/public/divide/move?memberid="+movingmember+"&choiceid="+choiceid+"&eventid="+eventid;

	window.location.replace(dividemoveurl);

}
