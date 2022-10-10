<?php
    $title = "BioSensation - Application";
    require_once('partials/header.php')
?>
    <!-- Script to get the maps widget -->
    <script src="app/views/javascript/api/OpenLayers.js"></script>
</head>
<body onload="init();">
    <!-- Top part -->
    <header id="heading">
        <div id="headingDiv">
            <img id="websiteIcon" src="app/views/img/leaf.png" alt="Website icon">
            <h1>BioSensation</h1>
        </div>
        <!-- Disconnect the current user -->
        <a href=<?= urlencode("disconnect"); ?> id="rightButton" class="btn btn-secondary rounded-circle" role="button"><img class="imgButton" src="app/views/img/logout.png" alt="Disconnect" onclick="disconnect()"></a>
    </header>

    <!-- Main part -->
    <main>
        <h2>Carte des environs</h2>
        <!-- Maps -->
        <div id="map" class="d-flex justify-content-center">
            <div id="mapOpenLayer">
                <div id="customZoom">
                    <a href="#customZoomIn" id="customZoomIn">+</a>
                    <a href="#customZoomOut" id="customZoomOut">-</a>
                    <a href="#geo" id="geo"><img onclick="activate()" src="app/views/img/gps.png" alt="Geolocalisation"></a>
                </div>
            </div>
        </div>

        <!-- <?= htmlentities($biome) ?> - Later, not yet doable -->
        <h2>Biome trouvé</h2>

        <!-- Spotify -->
        <!-- Connect to spotify -->
        <div id="centerButton">
            <button id="connectSpotify" onclick="connect()">Se connecter</button>
        </div>

        <!-- Playlist -->
        <div id="playlist" class="container">
            <div class="playlist">
                <div class="titles">
                    <div></div>
                    <div>#</div>
                    <div>Titre</div>
                    <div>Auteur</div>
                    <div>Rating</div>
                    <div></div>
                </div>
                <hr id="mainHr">

                <!-- Div which will contains the playlist songs -->
                <div class="musics">

                </div>
            </div>
        </div>
    </main>

    <!-- Bottom part -->
    <footer id="audioBottom" class="fixed-bottom">
        <!-- Player -->
        <div id="player">
            <img src="app/views/img/previous.png" alt="Previous" onclick="previous()">
            <audio id="audio" src="" controls="controls" autoplay="autoplay"> </audio>
            <img src="app/views/img/next.png" alt="Next" onclick="next()">
        </div>
    </footer>

<?php
    require_once('partials/footer.php')
?>
