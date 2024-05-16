@extends('_layouts.template')

@section('title', 'spotify')

@section('content')
<style>

        .loading.show {
            opacity: 1;
        }
        
        .loading .spin {
            border: 3px solid hsla(185, 100%, 62%, 0.2);
            border-top-color: #3cefff;
            border-radius: 50%;
            width: 3em;
            height: 3em;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
          to {
            transform: rotate(360deg);
          }
        }
    </style>
    
<div class="d-flex flex-column justify-content-center align-items-center h-100 w-100 text-white" style="font-size: 4em;">
    <h1>Estamos recogiendo tus datos, espera un momento...</h1>
    <div class="loading show">
        <div class="spin"></div>
    </div>
</div>

<h1 id="userId" hidden>{{ $user }}</h1>
<script>
    localStorage.setItem("userId", document.querySelector("#userId").innerHTML)
    const clientId = "e1ccac91ae2f4f3c8534f5f9b00d729c";
    const params = new URLSearchParams(window.location.search);
    const code = params.get("code");

    handleAuthentication(clientId, code);

    async function handleAuthentication(clientId, code) {
        if (!code) {
            await redirectToAuthCodeFlow(clientId);
        } else {

            try {
                const accessToken = await getAccessToken(clientId, code);
                const profile = await fetchProfile(accessToken);
                localStorage.setItem("user", JSON.stringify(profile))

                const topTracks = await fetchTopTracks(accessToken);
                const topTracksIds = topTracks.items.map(track => track.id);

                const recommendations = await getRecommendations(accessToken, topTracksIds);
                const tracksUri = recommendations.tracks.map(track => track.uri);

                const user_id = profile.id;
                const playlist = await createPlaylist(accessToken, user_id, tracksUri);
                if (playlist) {
                localStorage.setItem("playlistId", playlist.id);
            }
            
                location.href = '/user/' + document.querySelector("#userId").innerHTML;
            } catch (error) {
                console.error('Error en la autenticación:', error);
            }
        }
    }

    async function redirectToAuthCodeFlow(clientId) {
        const verifier = generateCodeVerifier(128);
        const challenge = await generateCodeChallenge(verifier);

        localStorage.setItem("verifier", verifier);

        const params = new URLSearchParams();
        params.append("client_id", clientId);
        params.append("response_type", "code");
        params.append("redirect_uri", "http://localhost:8000/spotify");
        params.append("scope", "user-read-private user-read-email user-top-read playlist-modify-public playlist-modify-private");
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
        params.append("redirect_uri", "http://localhost:8000/spotify");
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

    async function fetchTopTracks(token) {
        const result = await fetch("https://api.spotify.com/v1/me/top/tracks?time_range=short_term&limit=5", {
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`
            }
        });
        return await result.json();
    }

    async function getRecommendations(token, topTracksIds) { 
    const result = await fetch(`https://api.spotify.com/v1/recommendations?limit=50&seed_tracks=${topTracksIds.join(',')}`, {
        method: "GET",
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
    return await result.json();
}

async function createPlaylist(token, user_id, tracksUri) {
    try {
        const result = await fetch(`https://api.spotify.com/v1/users/${user_id}/playlists`, {
            method: "POST",
            headers: {
                "Authorization": `Bearer ${token}`,
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "name": "Esta playlist es de 10",
                "description": "OLE OLE QUE BUENA LA PLAYLIST - MIRA COMO USO LA API OLGUI OLGUI",
                "public": false
            })
        });

        if (!result.ok) {
            throw new Error('Error al crear la playlist');
        }

        const playlist = await result.json();

        const addTracksResult = await fetch(`https://api.spotify.com/v1/playlists/${playlist.id}/tracks?uris=${tracksUri.join(',')}`, {
            method: "POST",
            headers: {
                "Authorization": `Bearer ${token}`
            }
        });

        if (!addTracksResult.ok) {
            throw new Error('Error al agregar pistas a la playlist');
        }

        return playlist;
    } catch (error) {
        console.error('Error al crear la playlist:', error);
        return null;
    }
}


</script>
@endsection