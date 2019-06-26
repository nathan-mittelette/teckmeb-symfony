function afficheNotif() {
    var requestURL = "/api/notification/get";
    var request = new XMLHttpRequest();
    request.open('GET', requestURL);
    request.responseType = 'json';
    request.send();
    request.onload = function () {
        var listNotif = request.response;
        var sideNavNotif = document.getElementById('sideNavList');
        document.querySelectorAll('#sideNavList #description').forEach(function (elem) {
            sideNavNotif.removeChild(elem);
        });
        var listDescription = document.querySelectorAll('#comp-notification #description');
        if (listDescription != null) {
            listDescription.forEach(function (element) {
                document.getElementById('comp-notification').removeChild(element);
            });
        }
        showNotifications(listNotif);
    }
}

function deleteForSideNav() {
    var sideNav = document.getElementById('sideNavNotification');
    sideNav.textContent = "";
}

function goForSideNav(compteur) {
    var sideNav = document.getElementById('sideNavNotification');
    sideNav.textContent = compteur;
}

function showNotifications(jsonObj) {
    var compteur = 0;
    Notifs = jsonObj['listNotif'];
    if (Notifs.length == 0) {
        var span = document.createElement('span');
        span.className = "black-text text-black";
        var a = document.createElement('a');
        var myDescription = document.createElement('li');
        myDescription.id = 'description';
        var contenu = document.createTextNode('Pas de notification');
        span.appendChild(contenu);
        a.appendChild(span);
        myDescription.appendChild(a);
        var ul = document.getElementById('comp-notification');
        ul.appendChild(myDescription);
        var sideNav = document.getElementById('sideNavList');
        var myDescriptionBis = myDescription.cloneNode(true);
        sideNav.appendChild(myDescriptionBis);
        shutDown();
        deleteForSideNav();
    }
    else {
        for (var i = 0; i < Notifs.length; i++) {
            if (Notifs[i].notsee === true) {
                compteur += 1;
            }
            var sideNav = document.getElementById('sideNavList')
            var span = document.createElement('span');
            span.className = "black-text text-black";
            var a = document.createElement('a');
            a.href = Notifs[i].href;
            var myDescription = document.createElement('li');
            myDescription.id = 'description';
            var contenu = document.createTextNode(Notifs[i].description);
            span.appendChild(contenu);
            a.appendChild(span);
            var ul = document.getElementById('comp-notification');
            myDescription.appendChild(a);
            var myDescriptionBis = myDescription.cloneNode(true);
            sideNav.appendChild(myDescription);
            ul.appendChild(myDescriptionBis);
            var liBis = document.createElement('li');
            liBis.className = "divider";
            liBis.id = 'description';
            var lis = liBis.cloneNode(true);
            ul.appendChild(liBis);
            sideNav.appendChild(lis);
            if (compteur != 0) {
                goForSideNav(compteur);
                go(compteur);
            }
            else {
                deleteForSideNav();
                shutDown();
            }
        }
    }
}

function retireVu() {
    var requestURL = "/api/notification/post";
    var request = new XMLHttpRequest();
    request.open('POST', requestURL, true);
    request.send();
    afficheNotif();
}

window.onload = afficheNotif();
var myVar = setInterval(afficheNotif, 60000);
document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.dropdown-button');
    var instances = M.Dropdown.init(elems, { coverTrigger: false, constrainWidth: false });
});

function shutDown() {
    var span = document.getElementById('notification');
    var a = document.getElementById('container-notification');
    if (span != null) {
        a.removeChild(span);
    }
    var p = document.getElementById('icon-notification');
    p.style.position = "relative";
    var icon = document.getElementById('icon-notification');
    icon.innerHTML = "notifications_none";
}

function go(number) {
    var span = document.getElementById('notification');
    if (span == null) {
        span = document.createElement('small');
        var a = document.getElementById('container-notification');
        span.id = "notification";
        span.className = "notification-badge";
        span.innerHTML = number;
        span.style.backgroundColor = "#f44336";
        var icon = document.getElementById('icon-notification');
        icon.style.position = "absolute";
        icon.innerHTML = "notifications";
        a.appendChild(span);
    }
    else {
        span.innerHTML = number;
    }
    var sideNav = document.getElementById('sideNavNotification');
    sideNav.textContent = number;
}

document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, null);
});

document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(elems, null);
});