$(function () {
    if(_page == 'Homepage') {
        $('.button-collapse').sideNav();
        $('.parallax').parallax();
    }


    flashes.forEach(function(flash){
        Materialize.toast(flash, 3000, 'rounded');
    });
});

// Google API - login button

function gapiOnLoad() {
    gapi.load('auth2', function() {
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

function gapiOnSuccess(googleUser){
    Materialize.toast('Přihlašování...', 3000, 'rounded');

    var id_token = googleUser.getAuthResponse().id_token;

    var profile = googleUser.getBasicProfile();
    if(profile.getEmail().indexOf('@cmgpv.cz') === -1){
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            location.href = '/ucet/prihlasit?token=' + id_token;
        });
    }else {
        location.href = '/ucet/prihlasit?token=' + id_token;
    }
}

function gapiOnFailure(error){
    Materialize.toast('Přihlášení se nezdařilo.', 3000, 'rounded');
}

function gapiSignOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        Materialize.toast('Odhlašování...', 3000, 'rounded');
    });

    setTimeout(function(){
        location.href = '/ucet/odhlasit?next=1';
    }, 1000);
}
