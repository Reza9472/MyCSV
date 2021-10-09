
// EDIT ROW FUNCTION
function edit_row(no)
{

    var header = document.getElementById('header' + no); // HEADER OF THE COLUMN

    let index = checkedDataJsArr.indexOf(header.innerHTML); // INDEX OF THE COLUMN

    checkedDataJsArr.splice(index , 1); // DELETE THAT ELEMENT FROM THE ARRAY


    header.innerHTML = "<input type='text' class='form-control' id='field"+no+"'>";

    document.getElementById("edit_button"+no).style.display="none"; // HIDE THE EDIT BUTTON
    document.getElementById("save_button"+no).style.display="block"; // DIUSPLAY THE SAVE BUTTON

}


// SAVE ROW FUNCTION
function save_row(no)
{

    let inputValue = document.getElementById('field' + no).value; // VALUE USER ENTERS FOR EDITING
    checkedDataJsArr.splice(no , 0 , inputValue); // add the edited value to array

    document.getElementById('header' + no).innerHTML = inputValue; // UPDATE THE VALUE

    document.getElementById("edit_button"+no).style.display="block";
    document.getElementById("save_button"+no).style.display="none";

}


// DELETE ROW FUNCTION
function delete_row(no)
{
    console.log(no);
    document.getElementById("row"+no+"").outerHTML="";
    checkedDataJsArr.splice(no , 1); // delete from the array

    console.log(checkedDataJsArr);

}


function moveColumn(i){ // MOVE COLUMN FUNCTION


    let table1 = $("#data_table tbody"); // THE TABLE'S TBODY

    let next = parseInt(i) + 1;
    let $tbody = $('#row' + parseInt(i)).parent();

    let num = $('#row' + parseInt(i)).index();


    moveChild(num,num+1, table1); // MOVE THE CHILD OF THAT ELEMENT
}

// FUNCTION TO MOVE THE CHILD OF THE GIVEN ELEMENT
function moveChild(from, to, $par) {
    const $ch = $par.children();

    $ch.eq(from).insertAfter($ch.eq(to));
}



