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
            goodSelect();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    goodSelect();
});

function goodSelect() {
    var dat = document.getElementById('teckmeb_absencebundle_absence_beginDate');
    var date = new Date(dat.value.substring(6, 10), dat.value.substring(3, 5) - 1, dat.value.substring(0, 2), 10, 30, 0);
    console.log(date.getDay());
    if (date.getDay() == 5) {
        var debut = document.getElementById('heureDebut');
        var fin = document.getElementById('heureFin');
        replaceHeure(debut, 2, '13:30');
        replaceHeure(debut, 3, '15:30');
        replaceHeure(fin, 2, '15:30');
        replaceHeure(fin, 3, '17:30');
    }
    else {
        var debut = document.getElementById('heureDebut');
        var fin = document.getElementById('heureFin');
        replaceHeure(debut, 2, '14:00');
        replaceHeure(debut, 3, '16:00');
        replaceHeure(fin, 2, '16:00');
        replaceHeure(fin, 3, '18:00');
    }
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, {
        dropdownOptions: {
            coverTrigger: false
        }
    });
}

function replaceHeure(combo, index, heure) {
    var selected = combo.options[index].selected;
    combo.options[index] = new Option(heure, heure);
    if (selected) {
        combo.options[index].selected = true;
    }
}