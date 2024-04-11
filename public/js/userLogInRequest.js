"use strict"

function userLoginRequest() {
    let clientId = "e1ccac91ae2f4f3c8534f5f9b00d729c"
    let logInUri

    const params = new URLSearchParams();
    params.append("client_id", clientId);
    params.append("response_type", "code");
    params.append("redirect_uri", "http://localhost:8000/spotify");
    params.append("scope", "user-read-private user-read-email");
    params.append("show_dialog", "true");


    logInUri = `https://accounts.spotify.com/authorize?${params.toString()}`;

    window.open(logInUri, '_self');
}
