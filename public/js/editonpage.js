function toForm(divid, id, value, field) {
    // console.log("Klickade på " + value+" med id " + id);
    console.log("value: " + value);
    console.log("field: " + field);
    console.log("id: " + id);
    var paramholder = document.getElementById(divid);
    var form = document.createElement("form");
    var input = document.createElement("input");
    var inputhiddenfield = document.createElement("input");
    var inputhiddenid = document.createElement("input");

    form.setAttribute("action", "/member/edit");
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
    // input.blur(function() {
    //     console.log("Tappar fokus");
    //     // form.parentNode.replaceChild(paramholder, form);
    // });

    form.appendChild(input);
    form.appendChild(inputhiddenfield);
    form.appendChild(inputhiddenid);
    paramholder.parentNode.replaceChild(form, paramholder);
