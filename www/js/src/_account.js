if(ajax)
    gapiRenderButton(); // GAPI is already setted up, so we can just render
else
    gapiRenderButtonNeeded = true; // set rendering as needed - will be done in GAPI onLoad method
