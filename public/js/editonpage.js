function toForm(divid, id, groupid, value, field) {
    // console.log("Klickade på " + value+" med id " + id);
    console.log("value: " + value);
    console.log("field: " + field);
    console.log("id: " + id);
    var paramholder = document.getElementById(divid);
    var form = document.createElement("form");
    var input = document.createElement("input");
    var inputhiddenfield = document.createElement("input");
    var inputhiddenid = document.createElement("input");
	var baseURL = window.location.protocol + "//" + window.location.host + "/Programmering/Gruppindelare/Grouper/public/";
	var editURL = baseURL + "members/edit/"+id;

    form.setAttribute("action", "../../members/edit/"+id);
    form.setAttribute("method", "post");

    input.setAttribute("value", value);
    input.setAttribute("type", "text");
    input.setAttribute("name", "newvalue");
    input.setAttribute("class", "form-control");

    inputhiddenfield.setAttribute("type", "hidden");
    inputhiddenfield.setAttribute("name", "field");
    inputhiddenfield.setAttribute("value", field);

    inputhiddenid.setAttribute("type", "hidden");
    inputhiddenid.setAttribute("name", "id");
    inputhiddenid.setAttribute("value", id);

    inputhiddenid.setAttribute("type", "hidden");
    inputhiddenid.setAttribute("name", "groupid");
    inputhiddenid.setAttribute("value", groupid);
    // input.blur(function() {
    //     console.log("Tappar fokus");
    //     // form.parentNode.replaceChild(paramholder, form);
    // });

    form.appendChild(input);
    form.appendChild(inputhiddenfield);
    form.appendChild(inputhiddenid);
    paramholder.parentNode.replaceChild(form, paramholder);
}
