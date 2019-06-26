var data = [];
var dataToInputId = [];
var dataToIndex = [];
var table;
var listInput;
var listData;
window.addEventListener("load", function () {
    table = document.getElementById('tableGroupe');
    listInput = document.querySelectorAll('table tbody tr td label input');
    listData = document.querySelectorAll('table tbody tr td label span');
    for (var i = 0; i < listInput.length; i++) {
        data[listData[i].innerHTML] = null;
        dataToInputId[listData[i].innerHTML] = listInput[i].id;
    }
    document.querySelectorAll('#tableStudent tbody tr td label input').forEach(function (elem) {
        console.log(elem);
        doalert(elem);
    });
})

$(document).ready(function () {
    $('input.autocomplete').autocomplete({
        data: data,
        onAutocomplete: function (val) {
            var value = $('input.autocomplete').val();
            var input = document.getElementById(dataToInputId[value]);
            if (input.checked == true) {
                deleteLignetab(value);
                input.checked = false;
            }
            else {
                creationLignetab(value);
                input.checked = true;
            }
            var inputAuto = document.getElementById('autocomplete-input');
            inputAuto.value = "";
        }
    });
});

function deleteOfTab(id) {
    console.log(id);
    var arrayLignes = table.rows;
    for (var i = 1; i < arrayLignes.length; i++) {
        if (arrayLignes[i].cells[0].textContent == id) {
            break;
        }
    }
    var contenu = arrayLignes[i].cells[0].innerHTML + " " + arrayLignes[i].cells[1].innerHTML + " " + arrayLignes[i].cells[2].innerHTML;
    var input = document.getElementById(dataToInputId[contenu]);
    input.checked = false;
    table.deleteRow(i);
}

function creationLignetab(value) {
    var nouvelleLigne = table.tBodies[0].insertRow(-1);
    var colonne1 = nouvelleLigne.insertCell(0);
    colonne1.textContent = value.split(' ')[0];
    var colonne2 = nouvelleLigne.insertCell(1);
    colonne2.textContent = value.split(' ')[1];
    var colonne3 = nouvelleLigne.insertCell(2);
    colonne3.textContent = value.split(' ')[2];
    var colonne4 = nouvelleLigne.insertCell(3);
    var index = nouvelleLigne.rowIndex;
    dataToIndex[value.split(' ')[0]] = index;
    var icon = document.createElement("i");
    icon.className = "material-icons";
    icon.textContent = "delete";
    icon.addEventListener("click", function (event) {
        deleteOfTab(event.target.parentElement.parentElement.cells[0].textContent);
    })
    colonne4.appendChild(icon);
}

function deleteLignetab(value) {
    var arrayLignes = table.rows;
    for (var i = 0; i < arrayLignes.length; i++) {
        if (arrayLignes[i].cells[0].innerHTML == value.split(' ')[0]) {
            table.deleteRow(i);
        }
    }
}

function doalert(checkboxElem) {
    var value = checkboxElem.labels[0].innerText;
    if (checkboxElem.checked || checkboxElem.checked == "checked") {
        console.log("Ajout de : ",value);
        creationLignetab(value);
    } else {
        deleteLignetab(value);
    }
}

