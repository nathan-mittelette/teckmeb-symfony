function replaceAll(machaine, chaineARemaplacer, chaineDeRemplacement) {
    return machaine.replace(new RegExp(chaineARemaplacer, 'g'), chaineDeRemplacement);
}

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.tooltipped');
    var instances = M.Tooltip.init(elems, null);
});

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, null);
});

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems, {
        format: 'yyyy-mm-dd',
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
    });
});

var dataToInput = [];

function getData() {
    var table = document.getElementById('absence');
    var lignes = table.rows;
    var data = [];
    var contenu = "";
    for (var i = 1; i < lignes.length; i++) {
        console.log(lignes[i]);
        contenu = lignes[i].cells[0].innerHTML + " " + lignes[i].cells[1].innerHTML + " " + lignes[i].cells[2].innerHTML + " " + lignes[i].cells[3].innerHTML + " " + lignes[i].cells[4].innerHTML + " " + lignes[i].cells[5].innerHTML + " " + lignes[i].cells[6].innerHTML + " " + lignes[i].cells[7].innerHTML + " " + lignes[i].cells[8].textContent;
        data[contenu] = null;
        dataToInput[contenu] = lignes[i].cells[9].childNodes[0].href;
    }
    return data;
}

document.addEventListener('DOMContentLoaded', function() {
    var data = getData();
    var elems = document.querySelectorAll('.autocomplete');
    var instances = M.Autocomplete.init(elems, {
        data: data,
        onAutocomplete: function(val) {
            document.location = dataToInput[val];
        }
    });
});