<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify</title>


</head>

<body>
    <h1>Display your Spotify profile data</h1>

    <section id="profile">
        <h2>Logged in as <span id="displayName"></span></h2>
        <span id="avatar"></span>
        <ul>
            <li>User ID: {{ $userData['id'] }}</li>
            <li>Email: {{ $userData['email'] }}</li>
            <li>Spotify URI: <a id="uri" href="{{ $userData['uri'] }}">{{ $userData['uri'] }}</a></li>
            <li>Link: <a id="url" href="{{ $userData['href'] }}">{{ $userData['href'] }}</a></li>
            <li>Profile Image: <img src="{{ $userData['images'][0]['url'] }}" alt="Profile"></img></li>

        </ul>
    </section>
</body>

</html>