var pages = [];

//@import '_homepage.js';
//@import '_account.js';

function init(ajax) {
    if (!ajax) {
        $.nette.init();
        $('.button-collapse').sideNav();
    }else{
        $('.button-collapse').sideNav('hide');

        if (typeof ga != 'undefined') { // not used yet
            //ga('send', 'pageview');
        }
    }

    // remove GET parameters
    window.history.pushState('', '', window.location.pathname);

    // highlight menu item
    $('nav li').each(function(){
        if(
            (window.location.pathname.lastIndexOf($(this).find('a').attr('href')) !== -1
             && $(this).find('a').attr('href') != '/')
            || (window.location.pathname == $(this).find('a').attr('href'))
        ){
            $(this).addClass('active');
        }else{
            $(this).removeClass('active');
        }
    });


    // custom scripts for pages
    console.log(_page + ':' + _pageAction);
    if (pages[_page]) // function is available
        pages[_page](ajax); // call it


    // Materialize things common for multiple pages
    flashes.forEach(function (flash) {
        Materialize.toast(flash, 4300, 'rounded');
    });

    // tooltips
    $('div.material-tooltip').remove();
    $('.tooltipped').tooltip({delay: 100, html: true, position: 'top'});
}

// main launching calls

var gapiRenderButtonNeeded = false; // trigger for non-AJAX Google login button rendering

$(document).ready(init());

$.nette.ext('custom', {
    complete: function () {
        init(true);
    }
});

// Google API - login button // TODO make an object GapiDriver of this functions and move to separate JS file

function gapiOnLoad() {
    gapi.load('auth2', function () {
        gapi.auth2.init();
    });

    if(gapiRenderButtonNeeded) gapiRenderButton();
}

function gapiRenderButton(){
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
            //Materialize.toast('Zadaný mail nepatří k doméně @cmgpv.cz, přihlášení nebylo umožněno.', 3000, 'rounded');
            location.href = '/ucet/prihlasit?token=' + id_token;
        });
    } else {
        location.href = '/ucet/prihlasit?token=' + id_token;
        //$.nette.ajax('/ucet/prihlasit?token=' + id_token);
    }
}

function gapiOnFailure(error) {
    Materialize.toast('Přihlášení se nezdařilo.', 3000, 'rounded');
}

function gapiSignOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        Materialize.toast('Odhlašování...', 3000, 'rounded');
        location.href = '/ucet/odhlasit?next=1';
    });
}
