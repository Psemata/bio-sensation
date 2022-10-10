//ID to connect to the Spotify API
let CLIENT_ID = "f80ca60a390a438896e21c2fa0a89fe8";
//Redirection to a callback page
let REDIRECT_URI = 'https://127.0.0.1/awb-g1-biosensation/Framework/app/views/callback.php';
// let REDIRECT_URI = 'https://157.26.77.161/php/Framework/app/views/callback.php';
//Base URL of the Spotify API
let baseUrl = 'https://api.spotify.com/v1';
//Access Token when user connects
let accessToken = "";
//user informations - Only used to get username
let userInfo;
//Playlist that is on the BioSensation spotify account
let playlist;
let currentPlaylist;
//Tracks on that playlist
let tracks;
//ID used to know which song is played
let i = 0;

//URL to connect the Spotify account
function getLoginURL(scopes) {
  return 'https://accounts.spotify.com/authorize?client_id=' + CLIENT_ID
  + '&redirect_uri=' + encodeURIComponent(REDIRECT_URI)
  + '&scope=' + encodeURIComponent(scopes.join(' '))
  + '&response_type=token';
}

function setAccessToken(token){
  //Sets the token in a local storage in the window
  window.localStorage.setItem("accessToken", token);
}

function isConnected(isConnected) {
  // Sets a value which show if the connection was successful
  window.localStorage.setItem("connected", isConnected);
}

function getPlaylists(){
  //Gets the token that was stocked
  accessToken = window.localStorage.getItem("accessToken");
  //ajax request on a spotify URL to get playlits of a user
  $.ajax({
    type: "GET",
    url: baseUrl + '/users/xjprkjsuhrf5y0zweztk1y2mi/playlists',
    async: false,
    headers: {
      'Authorization': 'Bearer ' + accessToken
    },
    success: function(r) {
      //console.log('got playlist', r);
      playlist = r;
    },
    error: function(err) {
      console.log('failed to get playlist', err);
    }
  });
}

function getTracks(i){
  //Gets the token that was stocked
  accessToken = window.localStorage.getItem("accessToken");
  //ajax request on a spotify URL to all tracks of the first playlist of the user
  $.ajax({
    type: "GET",
    url: playlist.items[i].tracks.href,
    async: false,
    headers: {
      'Authorization': 'Bearer ' + accessToken
    },
    success: function(r) {
      //console.log('got userinfo', r);
      tracks = r;
    },
    error: function(err) {
      console.log('failed to get userinfo', err);
    }
  });
}

function getUserInfo(){
  //Gets the token that was stocked
  accessToken = window.localStorage.getItem("accessToken");
  //ajax request on a spotify URL to user information
  $.ajax({
    type: "GET",
    url: baseUrl + '/me',
    async: false,
    headers: {
      'Authorization': 'Bearer ' + accessToken
    },
    success: function(r) {
      //console.log('got userinfo', r);
      userInfo = r;
    },
    error: function(err) {
      console.log('failed to get userinfo', err);
    }
  });
}

//Function that is launched when the button is clicked
function connect(){
  //Rights that we can do with the application
    var url = getLoginURL([
        'user-read-private',
        'playlist-read-private',
        'playlist-modify-public',
        'playlist-modify-private',
        'user-library-read',
        'user-library-modify',
        'user-follow-read',
        'user-follow-modify'
        ]);

    //Window of the spotify connection
    let width = 450, height = 730, left = (screen.width / 2) - (width / 2),	top = (screen.height / 2) - (height / 2);
    let w = window.open(url,'Spotify','menubar=no,location=no,resizable=no,scrollbars=no,status=no, width=' + width + ', height=' + height + ', top=' + top + ', left=' + left);

    w.addEventListener('beforeunload', function (e) {
      //If we were already connected
      if(window.localStorage.getItem("connected")) {
        var value = $("#playlist").css("display");
        if (value == "none") {
          $('#playlist').css('display', 'flex');
          $('#centerButton').css('display', 'none');
        }
      } else {
        return false;
      }
      //Gets the user infomations
      getUserInfo();
      //Gets all playlits of the BioSensation Spotify account
      getPlaylists();
      //Event to play tracks automatically when one ends in a different thread so window does not freeze
      document.getElementById('audio').addEventListener('ended', function(){
          parent = $("#song"+i).parent();
          parent.removeClass("current");
          i++;
          if(i >= tracks.total){
            i = 0;
          }
          //If for some reason a preview is null
          while(tracks.items[i].track.preview_url == null){
            i++;
          }
          //The song is only a preview of 30 seconds
          playSong();
          //For the next song
      },
      false);
    });
}

//When user disconnects
function disconnect(){
  window.localStorage.removeItem("accessToken");
  window.localStorage.removeItem("connected");
}

//When user choses a specific song
function chose(j){
  //Remove class current of the precedant song so it does not have the green CSS
  parent = $("#song"+i).parent();
  parent.removeClass("current");
  //Sets the curent song ID
  i = j;
  playSong();
}

//When a playlist is found with Biome
function changeToPlaylist(name){
  //If we are on the same biome we do nothing
  if(name == currentPlaylist){
    return;
  }
  currentPlaylist = name;
  musics = $(".musics");
  musics.html("");
  for(i = 0; i < playlist.total; i++){
    //Check if the playlist we are looking for is this one
    if(playlist.items[i].name == name){
      //If it is then we get all informations on the playlist and add all songs to the HTML
      getTracks(i);
      for(j = 0; j < tracks.total; j++){
        string = "<div class=\"music\">\n";
        string += "<div class=\"play\" id=\"" + ("song" + j) + "\"><img class=\"playButton\" src=\"app/views/img/play.png\" alt=\"Play button\" onclick=\"chose(\'" + j + "\')\"></div>\n";
        string += "<div class=\"id\">" + (j + 1) + "</div>\n";
        string += "<div class=\"title\">" + tracks.items[j].track.name + "</div>\n";
        string += "<div class=\"author\">" + tracks.items[j].track.artists[0].name + "</div>\n";
        string += "<div class=\"raiting\">67/100%</div>\n";
        string += "<div class=\"upvote\" id=\"" + ("song" + j) + "\"><img class=\"imgRating\" src=\"app/views/img/thumb-up.png\" alt=\"Upvote button\"></div>\n";
        string += "</div>\n";
        string += "<hr class=\"interSong\">\n";
        musics.append(string);
      }
      //Plays a song of the playlist
      audioPlayer = document.getElementById('audio');
      audioPlayer.volume = 0.05;
      playSong();
      break;
    }
  }
}

//When no playlist is found (So no Biome is found either)
function removePlaylist(){
  //Remove class current of the precedant song so it does not have the green CSS
  parent = $("#song"+i).parent();
  parent.removeClass("current");
  //Removes div elements
  currentPlaylist = "";
  musics = $(".musics");
  //Stops audio player
  audioPlayer = document.getElementById('audio');
  audioPlayer.pause();
  audioPlayer.currentTime = 0;
  musics.html("");
}

//Previous button
function previous(){
  //Remove class current of the precedant song so it does not have the green CSS
  parent = $("#song"+i).parent();
  parent.removeClass("current");
  //Gets the next song, if the precedant song was first on playlist, it goes to the end
  if(i - 1 >= 0){
    i--;
  }else{
    i = tracks.total-1;
  }
  playSong();
}

//Next button
function next(){
  //Remove class current of the precedant song so it does not have the green CSS
  parent = $("#song"+i).parent();
  parent.removeClass("current");
  //Gets the next song, if the precedant song was last on playlist, it goes to the beggining
  if(i + 1 < tracks.total){
    i++;
  }else{
    i = 0;
  }
  playSong();
}

//Factorization of the play song so code does not repeat
function playSong(){
  audioPlayer.src = tracks.items[i].track.preview_url;
  parent = $("#song"+i).parent();
  parent.addClass("current");
  //Load and play the song
  audioPlayer.load();
  audioPlayer.play();
}
