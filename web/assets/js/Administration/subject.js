function valider(subjectId, groupeId)
{
    var select = document.getElementById('select' + subjectId);
    var teacherId = select.options[select.selectedIndex].value;
    var requestURL = "/Process/ValideEdu/" + subjectId + "/" + groupeId + "/" + teacherId;
    var request = new XMLHttpRequest();
    request.open('POST', requestURL, true);
    request.send();
    var input = document.getElementById('input' + subjectId);
    input.checked = true;
    M.toast({html: 'Professeur bien ajouté à ce sujet'});
}