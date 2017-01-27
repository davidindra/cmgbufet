var pages = [];

//@import '_homepage.js';
//@import '_account.js';

function init(ajax) {
    if (!ajax) $.nette.init(); // Nette.ajax.js

    // side menu
    if (!ajax) $('.button-collapse').sideNav();
    else $('.button-collapse').sideNav('hide');

    /*if (ajax && typeof ga != 'undefined') { // not used yet
        ga('send', 'pageview');
    }*/

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

$(document).ready(init());

$.nette.ext('custom', {
    complete: function () {
        init(true);
    }
});

@import "_Gapi.js";
