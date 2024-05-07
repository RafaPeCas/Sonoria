
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify</title>
</head>

<body>
    <h1>Display your Spotify profile data</h1>
    <p id="token" hidden>{{ $_GET['code'] }}</p>
    <section id="profile">
        <h2>Logged in as <span id="displayName"></span></h2>
        <span id="avatar"></span>
        <ul>
            <li>User ID: <span id="id"></span></li>
            <li>Email: <span id="email"></span></li>
            <li>Spotify URI: <a id="uri" href="#"></a></li>
            <li>Link: <a id="url" href="#"></a></li>
            <li>Profile Image: <span id="imgUrl"></span></li>
        </ul>
    </section>
</body>

</html>
<script>
    (async () => {
        const clientId = "e1ccac91ae2f4f3c8534f5f9b00d729c";
        const params = new URLSearchParams(window.location.search);
        const code = params.get("code");

        if (!code) {
            redirectToAuthCodeFlow(clientId);
        } else {
            const accessToken = await getAccessToken(clientId, code);
            const profile = await fetchProfile(accessToken);
            localStorage.setItem("profileData", JSON.stringify(profile))
        }

        async function redirectToAuthCodeFlow(clientId) {
            const verifier = generateCodeVerifier(128);
            const challenge = await generateCodeChallenge(verifier);

            localStorage.setItem("verifier", verifier);

            const params = new URLSearchParams();
            params.append("client_id", clientId);
            params.append("response_type", "code");
            params.append("redirect_uri", "http://localhost:8000/spotify");
            params.append("scope", "user-read-private user-read-email");
            params.append("code_challenge_method", "S256");
            params.append("code_challenge", challenge);

            document.location = `https://accounts.spotify.com/authorize?${params.toString()}`;
        }

        function generateCodeVerifier(length) {
            let text = '';
            let possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

            for (let i = 0; i < length; i++) {
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            return text;
        }

        async function generateCodeChallenge(codeVerifier) {
            const data = new TextEncoder().encode(codeVerifier);
            const digest = await window.crypto.subtle.digest('SHA-256', data);
            return btoa(String.fromCharCode.apply(null, [...new Uint8Array(digest)]))
                .replace(/\+/g, '-')
                .replace(/\//g, '_')
                .replace(/=+$/, '');
        }


        async function getAccessToken(clientId, code) {
            const verifier = localStorage.getItem("verifier");

            const params = new URLSearchParams();
            params.append("client_id", clientId);
            params.append("grant_type", "authorization_code");
            params.append("code", code);
            params.append("redirect_uri", "http://localhost:5173/callback");
            params.append("code_verifier", verifier);

            const result = await fetch("https://accounts.spotify.com/api/token", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: params
            });

            const {
                access_token
            } = await result.json();
            return access_token;
        }

        async function fetchProfile(token) {
            const result = await fetch("https://api.spotify.com/v1/me", {
                method: "GET",
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });

            return await result.json();
        }
    })();
</script>