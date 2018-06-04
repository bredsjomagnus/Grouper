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
	} else {
		$(".divide-paneldiv-active").addClass('divide-paneldiv').removeClass('divide-paneldiv-active');
		$("#"+memberid).addClass('divide-paneldiv-active').removeClass('divide-paneldiv');

		$(".choice-column-active").addClass('choice-column').removeClass('choice-column-active');
		choicesarray.forEach(function(choice) {

			$("#choice_"+choice).addClass('choice-column-active').removeClass('choice-column');
		  	console.log(choice);
		});
	}
}

function markchoice(choiceid, eventid) {
	// Här behöver jag alla medlemmar och deras val för att kunna markera de som har gjort just detta valet.
	// console.log("choiceid: " + choiceid);
	// var hostname = window.location.hostname;
	// console.log("hostname: " + hostname);
	// var protocol = window.location.protocol;
	// console.log("protocol: " + protocol);
	// var pathname = window.location.pathname;
	// console.log("pathname: " + pathname);
	// var href = window.location.href;
	// console.log("href: " + href);
	// console.log("hrefsplit: " + href.split('/'));
	if($("#choice_"+choiceid).hasClass('divide-paneldiv-checked')){
		$(".divide-paneldiv-choice").addClass('divide-paneldiv').removeClass('divide-paneldiv-choice');
		$(".divide-paneldiv-active").addClass('divide-paneldiv').removeClass('divide-paneldiv-active');
	} else {
		var divideretrieveurl = "http://localhost/Programmering/Gruppindelare/Grouper/public/divide/retrieve/"+eventid;
		var memberschoices;
		$.ajax({
		    type:     "get",
		    url:      divideretrieveurl,
		    dataType: "json",
		    success: function (response) {
		        // console.log("response: " + response.data);
				// memberschoices = response.data;
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

	$(".divide-paneldiv-choice").addClass('divide-paneldiv').removeClass('divide-paneldiv-choice');
	$(".divide-paneldiv-active").addClass('divide-paneldiv').removeClass('divide-paneldiv-active');
	$(".divide-paneldiv-checked").addClass('').removeClass('divide-paneldiv-checked');
	$("#choice_"+choiceid).addClass('divide-paneldiv-checked');
	// Iterate over memberchoices.
	Object.entries(memberchoicesJSON).forEach(function([key, value]) {
		if(value.indexOf(choiceid) != -1) {
			console.log("memberid: " +key);
			$("#"+key).addClass('divide-paneldiv-choice').removeClass('divide-paneldiv');

		}

	});
}
