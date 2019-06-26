function getData1()
{
    var data = [];
    var table = document.getElementById('tableStudent');
    var arrayLigne = table.rows;
    for (var i = 1; i < arrayLigne.length; i++)
        {
            var nom = replaceAll(arrayLigne[i].innerText,'\t',' ');
            data[nom] = null;
        }
    return data;
}

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.autocomplete1');
    var data = getData1();
    var instances = M.Autocomplete.init(elems, {
        data : data,
        onAutocomplete: function(val) {
        var value = $('input.autocomplete1').val();
        document.location.href='/Suivi/profile/' + val.split(' ')[0];
    }
    });
  });

function replaceAll(machaine, chaineARemaplacer, chaineDeRemplacement) {
   return machaine.replace(new RegExp(chaineARemaplacer, 'g'),chaineDeRemplacement);
 }