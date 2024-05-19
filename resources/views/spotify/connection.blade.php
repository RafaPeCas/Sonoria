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

<h1 id="userId" userName="{{$name}}" hidden>{{ $user }}</h1>
<script>
    const clientId = "e1ccac91ae2f4f3c8534f5f9b00d729c";
    const params = new URLSearchParams(window.location.search);
    const code = params.get("code");

    document.addEventListener('DOMContentLoaded', () => {
        localStorage.setItem("userId", document.querySelector("#userId").innerHTML);
        handleAuthentication(clientId, code);
    });

    async function handleAuthentication(clientId, code) {
        if (!code) {
            await redirectToAuthCodeFlow(clientId);
        } else {
            try {
                const accessToken = await getAccessToken(clientId, code);
                const profile = await fetchProfile(accessToken);
                localStorage.setItem("user", JSON.stringify(profile));

                const topTracks = await fetchTopTracks(accessToken);
                const recommendations = await getRecommendations(accessToken, topTracks.items.map(track => track.id));
                const playlist = await createPlaylist(accessToken, profile.id, recommendations.tracks.map(track => track.uri));

                if (playlist) {
                    localStorage.setItem("playlistId", playlist.id);
                }

                redirectToUserPage();
            } catch (error) {
                console.error('Error en la autenticación:', error);
                redirectToHomePage();
            }
        }
    }

    function redirectToUserPage() {
        location.href = '/user/' + localStorage.getItem("userId");
    }

    function redirectToHomePage() {
        location.href = '/home';
    }

    async function redirectToAuthCodeFlow(clientId) {
        try {
            const verifier = generateCodeVerifier(128);
            const challenge = await generateCodeChallenge(verifier);

            localStorage.setItem("verifier", verifier);

            const params = new URLSearchParams({
                client_id: clientId,
                response_type: "code",
                redirect_uri: "http://localhost:8000/spotify",
                scope: "user-read-private user-read-email user-top-read playlist-modify-public playlist-modify-private",
                code_challenge_method: "S256",
                code_challenge: challenge
            });

            document.location = `https://accounts.spotify.com/authorize?${params.toString()}`;
        } catch (error) {
            console.error('Error en el flujo de autorización:', error);
            redirectToHomePage();
        }
    }

    function generateCodeVerifier(length) {
        const possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        return Array.from({ length }, () => possible.charAt(Math.floor(Math.random() * possible.length))).join('');
    }

    async function generateCodeChallenge(codeVerifier) {
        try {
            const data = new TextEncoder().encode(codeVerifier);
            const digest = await window.crypto.subtle.digest('SHA-256', data);
            return btoa(String.fromCharCode(...new Uint8Array(digest)))
                .replace(/\+/g, '-')
                .replace(/\//g, '_')
                .replace(/=+$/, '');
        } catch (error) {
            console.error('Error al generar el desafío del código:', error);
            redirectToHomePage();
        }
    }

    async function getAccessToken(clientId, code) {
        try {
            const verifier = localStorage.getItem("verifier");
            const params = new URLSearchParams({
                client_id: clientId,
                grant_type: "authorization_code",
                code,
                redirect_uri: "http://localhost:8000/spotify",
                code_verifier: verifier
            });

            const response = await fetch("https://accounts.spotify.com/api/token", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: params.toString()
            });

            const data = await response.json();
            return data.access_token;
        } catch (error) {
            console.error('Error al obtener el token de acceso:', error);
            redirectToHomePage();
        }
    }

    async function fetchProfile(token) {
        try {
            return await fetchFromSpotify("https://api.spotify.com/v1/me", token);
        } catch (error) {
            console.error('Error al obtener el perfil:', error);
            redirectToHomePage();
        }
    }

    async function fetchTopTracks(token) {
        try {
            return await fetchFromSpotify("https://api.spotify.com/v1/me/top/tracks?time_range=short_term&limit=5", token);
        } catch (error) {
            console.error('Error al obtener las pistas principales:', error);
            redirectToHomePage();
        }
    }

    async function fetchFromSpotify(url, token) {
        const response = await fetch(url, {
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`
            }
        });

        if (!response.ok) {
            throw new Error(`Error fetching from Spotify: ${response.statusText}`);
        }

        return response.json();
    }

    async function getRecommendations(token, topTracksIds) {
        try {
            const url = `https://api.spotify.com/v1/recommendations?limit=50&seed_tracks=${topTracksIds.join(',')}`;
            return await fetchFromSpotify(url, token);
        } catch (error) {
            console.error('Error al obtener recomendaciones:', error);
            redirectToHomePage();
        }
    }

    async function createPlaylist(token, userId, tracksUri) {
        try {
            let name = document.querySelector("#userId").getAttribute("userName");
            const playlistResponse = await fetch(`https://api.spotify.com/v1/users/${userId}/playlists`, {
                method: "POST",
                headers: {
                    "Authorization": `Bearer ${token}`,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    "name": `Aquí está la playlist para ${name}`,
                    "description": "OLE OLE QUE BUENA LA PLAYLIST",
                    "public": false
                })
            });

            if (!playlistResponse.ok) {
                throw new Error('Error al crear la playlist');
            }

            const playlist = await playlistResponse.json();

            const addTracksResponse = await fetch(`https://api.spotify.com/v1/playlists/${playlist.id}/tracks?uris=${tracksUri.join(',')}`, {
                method: "POST",
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });

            if (!addTracksResponse.ok) {
                throw new Error('Error al agregar pistas a la playlist');
            }

            return playlist;
        } catch (error) {
            console.error('Error al crear la playlist:', error);
            redirectToHomePage();
            return null;
        }
    }
</script>
@endsection
