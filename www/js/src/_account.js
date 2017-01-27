pages['Account'] = function(ajax) {
    if (ajax)
        Gapi.renderButton(); // GAPI is already setted up, so we can just render
    else
        Gapi.renderButtonNeeded = true; // set rendering as needed - will be done in GAPI onLoad method
}
