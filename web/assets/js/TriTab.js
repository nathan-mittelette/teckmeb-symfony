var table = [];
var th = [];
var regex = /date/g;

window.addEventListener("load", function () {
    table = document.querySelectorAll("table");
    table.forEach(function (elem, index) {
        if (elem.tHead != null) {
            if (estTriable(elem)) {
                console.log(elem);
                ajoutListenner(elem, index);
                ajoutAttribut(elem, index);
            }
        }
    });
});

function estTriable(table) {
    var nbCell = table.tHead.rows[0].cells.length;
    for (var i = 1; i < table.rows.length; i++) {
        if (table.rows[i].cells.length != nbCell) {
            return false;
        }
    }
    return true;
}

function ajoutAttribut(table, index) {
    table.setAttribute("tableNumber", index);
    setSortFalse(table);
}

function setSortFalse(table) {
    for (var i = 0; i < table.tHead.rows[0].cells.length; i++) {
        table.tHead.rows[0].cells[i].setAttribute("sort", false);
    }
}

function ajoutListenner(table) {
    for (var indexThead = 0; indexThead < table.tHead.rows[0].cells.length; indexThead++) {
        table.tHead.rows[0].cells[indexThead].addEventListener("click", function (event) {
            triTableau(event.target.offsetParent.getAttribute("tableNumber"), event.target.cellIndex);
        })
    }
}

function triTableau(indexTable, indexThead) {
    var arrayLines = table[indexTable].rows;
    if (arrayLines[0].cells[indexThead].getAttribute("sort") === "true") {
        triMax(arrayLines, indexThead, (table[indexTable].rows[0].cells[indexThead].textContent.toLowerCase().match(regex)));
        setSortFalse(table[indexTable]);
    }
    else {
        triMin(arrayLines, indexThead, (table[indexTable].rows[0].cells[indexThead].textContent.toLowerCase().match(regex)));
        setSortFalse(table[indexTable]);
        arrayLines[0].cells[indexThead].setAttribute("sort", true);
    }
    setUnderLine(arrayLines[0].cells, indexThead);
}

function setUnderLine(cells, indexCurrent) {
    for (var i = 0; i < cells.length; i++) {
        cells[i].style = "text-decoration: " + ((i == indexCurrent) ? "underline" : "none") + ";";
    }
}

function echange(ligne1, ligne2) {
    var tmp = ligne1.innerHTML;
    ligne1.innerHTML = ligne2.innerHTML;
    ligne2.innerHTML = tmp;
}

function getUSDate($date) {
    var splitDate = $date.split("/");
    return splitDate[1] + "/" + splitDate[0] + "/" + splitDate[2];
}

function triMin(arrayLines, indiceTri, isDate) {
    for (var i = 1; i < arrayLines.length; i++) {
        var indiceMin = i;
        for (var j = i; j < arrayLines.length; j++) {
            var contenuMin = arrayLines[indiceMin].cells;
            var contenu = arrayLines[j].cells;
            if (isDate) {
                var dateMin = new Date(getUSDate(contenuMin[indiceTri].innerText));
                var dateCurrent = new Date(getUSDate(contenu[indiceTri].innerText));
                if (dateMin.getTime() > dateCurrent.getTime()) {
                    indiceMin = j;
                }
            }
            else {
                if (isNaN(contenuMin[indiceTri].innerText) || isNaN(contenu[indiceTri].innerText)) {
                    if (contenuMin[indiceTri].innerText > contenu[indiceTri].innerText) {
                        indiceMin = j;
                    }
                }
                else {
                    if (parseInt(contenuMin[indiceTri].innerText, 10) > parseInt(contenu[indiceTri].innerText, 10)) {
                        indiceMin = j;
                    }
                }
            }
        }
        echange(arrayLines[i], arrayLines[indiceMin]);
    }
}

function triMax(arrayLines, indiceTri, isDate) {
    for (var i = 1; i < arrayLines.length; i++) {
        var indiceMax = i;
        for (var j = i; j < arrayLines.length; j++) {
            var contenuMax = arrayLines[indiceMax].cells;
            var contenu = arrayLines[j].cells;
            if (isDate) {
                var dateMax = new Date(getUSDate(contenuMax[indiceTri].textContent));
                var dateCurrent = new Date(getUSDate(contenu[indiceTri].textContent));
                if (dateMax.getTime() < dateCurrent.getTime()) {
                    indiceMax = j;
                }
            }
            else {
                if (isNaN(contenuMax[indiceTri].textContent) || isNaN(contenu[indiceTri].textContent)) {
                    if (contenuMax[indiceTri].textContent < contenu[indiceTri].textContent) {
                        indiceMax = j;
                    }
                }
                else {
                    if (parseInt(contenuMax[indiceTri].textContent, 10) < parseInt(contenu[indiceTri].textContent, 10)) {
                        indiceMax = j;
                    }
                }
            }
        }
        echange(arrayLines[i], arrayLines[indiceMax]);
    }
}