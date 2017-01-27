var Gapi = {
    renderButtonNeeded: false,
    onLoad: function(){
        gapi.load('auth2', function () {
            gapi.auth2.init();
        });

        if(this.renderButtonNeeded) this.renderButton();
    },

    renderButton: function(){
        gapi.signin2.render('my-signin2', {
            'scope': 'profile email',
            'width': 200,
            'height': 50,
            'longtitle': false,
            'theme': 'dark',
            'onsuccess': Gapi.onSuccess,
            'onfailure': Gapi.onFailure
        });
    },

    onSuccess: function(googleUser) {
        Materialize.toast('Přihlašování...', 3000, 'rounded');

        var id_token = googleUser.getAuthResponse().id_token;

        var profile = googleUser.getBasicProfile();
        if (profile.getEmail().indexOf('@cmgpv.cz') === -1) { // not @cmgpv.cz mail
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.signOut().then(function () {
                //Materialize.toast('Zadaný mail nepatří k doméně @cmgpv.cz, přihlášení nebylo umožněno.', 3000, 'rounded');
                location.href = '/ucet/prihlasit?token=' + id_token;
            });
        } else {
            location.href = '/ucet/prihlasit?token=' + id_token;
            //$.nette.ajax('/ucet/prihlasit?token=' + id_token);
        }
    },

    onFailure: function(error) {
        Materialize.toast('Přihlášení se nezdařilo.', 3000, 'rounded');
    },

    signOut: function() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            Materialize.toast('Odhlašování...', 3000, 'rounded');
            location.href = '/ucet/odhlasit?next=1';
        });
    },
}

var gapiOnLoad = Gapi.onLoad;
