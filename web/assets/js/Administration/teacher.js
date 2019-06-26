function getData2()
{
    var data = [];
    var table = document.getElementById('tableTeacher');
    var arrayLigne = table.rows;
    for (var i = 1; i < arrayLigne.length; i++)
        {
            var nom = replaceAll(arrayLigne[i].innerText,'\t',' ');
            data[nom] = null;
        }
    return data;
}

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.autocomplete2');
    var data = getData2();
    var instances = M.Autocomplete.init(elems, {
        data : data,
        onAutocomplete: function(val) {
        var value = $('input.autocomplete2').val();
        document.location.href='/administration/suiviTeacher/' + val.split(' ')[0];
    }
    });
  });

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, null);
  });

function replaceAll(machaine, chaineARemaplacer, chaineDeRemplacement) {
   return machaine.replace(new RegExp(chaineARemaplacer, 'g'),chaineDeRemplacement);
 }