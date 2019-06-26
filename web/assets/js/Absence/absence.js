var button1 = document.getElementById('button1');
var button2 = document.getElementById('button2');
var button3 = document.getElementById('button3');
var button4 = document.getElementById('button4');
var button5 = document.getElementById('button5');
var button6 = document.getElementById('button6');
var buttonMatin = 0;
var buttonApres = 0;
var studentId = null;
var numToId = [];

function replaceAll(machaine, chaineARemaplacer, chaineDeRemplacement) {
    return machaine.replace(new RegExp(chaineARemaplacer, 'g'), chaineDeRemplacement);
}

document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, {
        onOpenStart: function () {
            button1.className = "card-panel blue-grey lighten-2 center-align";
            button2.className = "card-panel blue-grey lighten-2 center-align";
            button3.className = "card-panel blue-grey lighten-2 center-align";
            button4.className = "card-panel blue-grey lighten-2 center-align";
            button5.className = "card-panel blue-grey lighten-2 center-align";
            button6.className = "card-panel blue-grey lighten-2 center-align";
            buttonMatin = 0;
            buttonApres = 0;
            var justified = document.getElementById('teckmeb_absencebundle_absence_justified');
            justified.checked = false;
            var absenceId = document.getElementById('teckmeb_absencebundle_absence_absenceType');
            absenceId.selectedIndex = 0;
            var dat = document.getElementById('teckmeb_absencebundle_absence_beginDate');
            var date = new Date(dat.value.substring(6, 10), dat.value.substring(3, 5) - 1, dat.value.substring(0, 2), 10, 30, 0);
            if (date.getDay() == 5) {
                button6.innerHTML = "13:30 - 17:30";
                button4.innerHTML = "13:30 - 15:30";
                button5.innerHTML = "15:30 - 17:30";
            }
            else {
                button6.innerHTML = "14:00 - 18:00";
                button4.innerHTML = "14:00 - 16:00";
                button5.innerHTML = "16:00 - 18:00";
            }

        }
    });
});

function replaceAll(machaine, chaineARemaplacer, chaineDeRemplacement) {
    return machaine.replace(new RegExp(chaineARemaplacer, 'g'), chaineDeRemplacement);
}

document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems, {
        format: 'dd/mm/yyyy',
        i18n: {
            labelMonthNext: 'Mois suivant',
            labelMonthPrev: 'Mois précédent',
            labelMonthSelect: 'Selectionner le mois',
            labelYearSelect: 'Selectionner une année',
            months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
            weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            today: 'Aujourd\'hui',
            clear: 'Réinitialiser',
            close: 'Fermer'
        },
        onClose: function () {
            var dat = document.getElementById('teckmeb_absencebundle_absence_beginDate');
            var date = new Date(dat.value.substring(6, 10), dat.value.substring(3, 5) - 1, dat.value.substring(0, 2), 10, 30, 0);
            if (date.getDay() == 5) {
                button6.innerHTML = "13:30 - 17:30";
                button4.innerHTML = "13:30 - 15:30";
                button5.innerHTML = "15:30 - 17:30";
            }
            else {
                button6.innerHTML = "14:00 - 18:00";
                button4.innerHTML = "14:00 - 16:00";
                button5.innerHTML = "16:00 - 18:00";
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, {
        dropdownOptions: {
            coverTrigger: false
        }
    });
});

function setStudentId(id) {
    studentId = id;
}
function envoie() {
    var justified = document.getElementById('teckmeb_absencebundle_absence_justified');
    justified = justified.checked;
    var dat = document.getElementById('teckmeb_absencebundle_absence_beginDate');
    var date = replaceAll(dat.value, '/', '-');
    var absenceId = document.getElementById('teckmeb_absencebundle_absence_absenceType');
    absenceId = absenceId.options[absenceId.selectedIndex].value;
    var requestURL = "/Process/AjoutAbsence/" + justified + "/" + date + "/" + absenceId + "/" + studentId + "/" + buttonMatin + "/" + buttonApres;
    var request = new XMLHttpRequest();
    request.open('POST', requestURL, true);
    request.send();
    request.onload = function () {
        var json = JSON.parse(request.responseText);
        M.toast({ html: json['messageRetour'] });
    };
}

function getData() {
    var data = [];
    var table = document.getElementById('tableStudent');
    var arrayLigne = table.rows;
    for (var i = 1; i < arrayLigne.length; i++) {
        var nom = replaceAll(arrayLigne[i].innerText, '\t', ' ');
        data[nom] = null;
        numToId[nom] = arrayLigne[i].childNodes[1].childNodes[1].id
    }
    return data;
}

document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.autocomplete');
    var data = getData();
    var instances = M.Autocomplete.init(elems, {
        data: data,
        onAutocomplete: function (val) {
            setStudentId(numToId[val]);
            var el = document.querySelector('.modal');
            var inst = M.Modal.getInstance(el);
            inst.open();
        }
    });
});
function changeColor(idColor) {
    switch (idColor) {
        case 1:
            if (buttonMatin == 1) {
                button1.className = "card-panel blue-grey lighten-2 center-align";
                buttonMatin = 0;
            }
            else {
                button1.className = "card-panel red center-align";
                button2.className = "card-panel blue-grey lighten-2 center-align";
                button3.className = "card-panel blue-grey lighten-2 center-align";
                buttonMatin = 1;
            }
            break;
        case 2:
            if (buttonMatin == 2) {
                button2.className = "card-panel blue-grey lighten-2 center-align";
                buttonMatin = 0;
            }
            else {
                button1.className = "card-panel blue-grey lighten-2 center-align";
                button2.className = "card-panel red center-align";
                button3.className = "card-panel blue-grey lighten-2 center-align";
                buttonMatin = 2;
            }
            break;
        case 3:
            if (buttonMatin == 3) {
                button3.className = "card-panel blue-grey lighten-2 center-align";
                buttonMatin = 0;
            }
            else {
                button1.className = "card-panel blue-grey lighten-2 center-align";
                button2.className = "card-panel blue-grey lighten-2 center-align";
                button3.className = "card-panel red center-align";
                buttonMatin = 3;
            }
            break;
        case 4:
            if (buttonApres == 1) {
                button4.className = "card-panel blue-grey lighten-2 center-align";
                buttonApres = 0;
            }
            else {
                button4.className = "card-panel red center-align";
                button5.className = "card-panel blue-grey lighten-2 center-align";
                button6.className = "card-panel blue-grey lighten-2 center-align";
                buttonApres = 1;
            }
            break;
        case 5:
            if (buttonApres == 2) {
                button5.className = "card-panel blue-grey lighten-2 center-align";
                buttonApres = 0;
            }
            else {
                button4.className = "card-panel blue-grey lighten-2 center-align";
                button5.className = "card-panel red center-align";
                button6.className = "card-panel blue-grey lighten-2 center-align";
                buttonApres = 2;
            }
            break;
        case 6:
            if (buttonApres == 3) {
                button6.className = "card-panel blue-grey lighten-2 center-align";
                buttonApres = 0;
            }
            else {
                button4.className = "card-panel blue-grey lighten-2 center-align";
                button5.className = "card-panel blue-grey lighten-2 center-align";
                button6.className = "card-panel red center-align";
                buttonApres = 3;
            }
            break;
    }
}
