function init(ajax) {
    if (!ajax) {
        $(function () {
            $.nette.init();
            //$.nette.ext('init').linkSelector = 'a';
            //$.nette.ext('init').formSelector = 'form';
            //$.nette.ext('init').buttonSelector = 'button[type="submit"]';
            //$('.no-ajax').netteAjaxOff();
        });
    }

    if (ajax) {
        if (typeof ga != 'undefined') {
            ga('send', 'pageview');
        }
    }

    if (_page == 'Homepage') {
        $('.button-collapse').sideNav();
        $('.parallax').parallax();
    }


    flashes.forEach(function (flash) {
        Materialize.toast(flash, 3000, 'rounded');
    });
}

$(document).ready(init());

$.nette.ext('custom', {
    complete: function () {
        init(true);
    }
});

// Google API - login button

function gapiOnLoad() {
    gapi.load('auth2', function () {
        gapi.auth2.init();
    });

    gapi.signin2.render('my-signin2', {
        'scope': 'profile email',
        'width': 200,
        'height': 50,
        'longtitle': false,
        'theme': 'dark',
        'onsuccess': gapiOnSuccess,
        'onfailure': gapiOnFailure
    });
}

function gapiOnSuccess(googleUser) {
    Materialize.toast('Přihlašování...', 3000, 'rounded');

    var id_token = googleUser.getAuthResponse().id_token;

    var profile = googleUser.getBasicProfile();
    if (profile.getEmail().indexOf('@cmgpv.cz') === -1) { // not @cmgpv.cz mail
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            Materialize.toast('Zadaný mail nepatří k doméně @cmgpv.cz, přihlášení nebylo umožněno.', 3000, 'rounded');
            //location.href = '/ucet/prihlasit?token=' + id_token;
        });
    } else {
        location.href = '/ucet/prihlasit?token=' + id_token;
    }
}

function gapiOnFailure(error) {
    Materialize.toast('Přihlášení se nezdařilo.', 3000, 'rounded');
}

function gapiSignOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        Materialize.toast('Odhlašování...', 3000, 'rounded');
    });

    setTimeout(function () {
        location.href = '/ucet/odhlasit?next=1';
    }, 1000);
}
