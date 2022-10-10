<base href="/awb-g1-biosensation/Framework/">
<!-- <base href="/php/Framework/"> -->
<?php
    $title = "Spotify - Connexion";
    require_once("partials/header.php");
?>
    <!-- Script that is launched when the callback page is loaded -->
	<script>
        function init() {
            var hash = {};
            //Formatting of the hash with the acces token, expiring time and type
            //Credits to : possan
            //https://github.com/possan/webapi-player-example/blob/master/callback.html
            location.hash.replace(/^#\/?/, '').split('&').forEach(function(kv) {
                var spl = kv.indexOf('=');
                if (spl != -1) {
                    hash[kv.substring(0, spl)] = decodeURIComponent(kv.substring(spl+1));
                }
            });

            //If we got an access token
            if (hash.access_token) {
                //Sets the access token in the SpotifyAPI.js file
                setAccessToken(hash.access_token);
                //Set that the connection was successful
                isConnected(true);
                //Closes the window automatically
                window.close();
            } else {
                // Set that the connection was not successful
                isConnected(false);
            }
        }
	</script>
</head>
<body onload="init()">

<?php
    require_once('partials/footer.php');
?>
