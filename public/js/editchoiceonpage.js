function toForm(divid, id, value, field) {

    console.log("value: " + value);
    console.log("field: " + field);
    console.log("id: " + id);

	// Variable and creating form and inupttags
    var paramholder = document.getElementById(divid);
    var form = document.createElement("form");
    var input = document.createElement("input");
    var inputhiddenfield = document.createElement("input");
    var inputhiddenid = document.createElement("input");

	// setting form attributes
    form.setAttribute("action", "../choices/newname/"+id);
    form.setAttribute("method", "post");

	// setting input attributes
    input.setAttribute("value", value);
    input.setAttribute("type", "text");
    input.setAttribute("name", "newvalue");
    input.setAttribute("class", "form-control");

	// setting input attributes
    inputhiddenfield.setAttribute("type", "hidden");
    inputhiddenfield.setAttribute("name", "field");
    inputhiddenfield.setAttribute("value", field);

	// setting input attributes
    // inputhiddenid.setAttribute("type", "hidden");
    // inputhiddenid.setAttribute("name", "id");
    // inputhiddenid.setAttribute("value", id);


    // input.blur(function() {
    //     console.log("Tappar fokus");
    //     // form.parentNode.replaceChild(paramholder, form);
    // });

	// Putting form with inputfields on screen
    form.appendChild(input);
    form.appendChild(inputhiddenfield);
    // form.appendChild(inputhiddenid);
    paramholder.parentNode.replaceChild(form, paramholder);
}

function toFormAdd() {
    var paramholder = document.getElementById('addchoice');
    var form = document.createElement("form");
    var input = document.createElement("input");
    var inputhiddenid = document.createElement("input");

    form.setAttribute("action", "../choices/addoneprocess");
    form.setAttribute("method", "post");

    input.setAttribute("value", "");
    input.setAttribute("placeholder", "Add new choice");
    input.setAttribute("type", "text");
    input.setAttribute("name", "choice");
    input.setAttribute("class", "form-control");

    // inputhiddenid.setAttribute("type", "hidden");
    // inputhiddenid.setAttribute("name", "groupid");
    // inputhiddenid.setAttribute("value", groupid);

    form.appendChild(input);
    // form.appendChild(inputhiddenid);
    paramholder.parentNode.replaceChild(form, paramholder);
}
