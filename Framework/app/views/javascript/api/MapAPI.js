var geolocate;

function init() {
  //Event when window close to destroy accessToken for Spotify and connect for button
  window.addEventListener('beforeunload', function (e) {
    window.localStorage.removeItem("accessToken");
    window.localStorage.removeItem("connect");
  });
  //Spotify button part
  if(window.localStorage.getItem("connected")) {
    var value = $("#playlist").css("display");
    if (value == "none") {
      $('#playlist').css('display', 'flex');
      $('#centerButton').css('display', 'none');
    }
    connect();
  }

  //Style of the circle around user position
  var style = {
      fillColor: '#000',
      fillOpacity: 0.1,
      strokeWidth: 0
  };

  //Default lat, lon and zoom
  var lat            = 47.35387;
  var lon            = 8.43609;
  var zoom           = 18;

  //Projections used for map and defualt position
  var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
  var toProjection   = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
  var position       = new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);

  //Object that contains position of player gived by Geolocalisation
  var ev;

  //Map
  var map = new OpenLayers.Map({
    div: "mapOpenLayer",
    layers: [new OpenLayers.Layer.OSM()],
    controls: [
      new OpenLayers.Control.Navigation({
        dragPanOptions: {
          enableKinetic: true
        }
      }),
      new OpenLayers.Control.Attribution(),
      new OpenLayers.Control.Zoom({
        zoomInId: "customZoomIn",
        zoomOutId: "customZoomOut"
      })
    ],
    center: position,
    zoom: zoom
  });

  //Markrs used to show Biomes position
  var markers = new OpenLayers.Layer.Markers("Markers");
  map.addLayer(markers);
  marker = new OpenLayers.Marker(position);

  //Layer of the Geolocalisation
  var layer = new OpenLayers.Layer.OSM( "Simple OSM Map");
  var vector = new OpenLayers.Layer.Vector('vector');
  map.addLayers([layer, vector]);

  //Function to add a little animation on the circle when user moves
  //Not really important
  var pulsate = function(feature) {
    var point = feature.geometry.getCentroid(),
      bounds = feature.geometry.getBounds(),
      radius = Math.abs((bounds.right - bounds.left)/2),
      count = 0,
      grow = 'up';

    var resize = function(){
      if (count>16) {
        clearInterval(window.resizeInterval);
      }
      var interval = radius * 0.03;
      var ratio = interval/radius;
      switch(count) {
        case 4:
        case 12:
          grow = 'down'; break;
        case 8:
          grow = 'up'; break;
      }
      if (grow!=='up') {
        ratio = - Math.abs(ratio);
      }
      feature.geometry.resize(1+ratio, point);
      vector.drawFeature(feature);
      count++;
    };
    window.resizeInterval = window.setInterval(resize, 50, point, radius);
  };

  //Geolocation Control
  geolocate = new OpenLayers.Control.Geolocate({
    bind: false,
    geolocationOptions: {
      enableHighAccuracy: true,
      maximumAge: 0,
      timeout: 7000
    }
  });

  //Add the control on the map
  map.addControl(geolocate);
  var firstGeolocation = true;

  //Ajax call to get the Biome where the user is
  var getBiome = function(){
    $.ajax({
      type: "POST",
      url: "getbiome",
      data: 'posX=' + ev.point.x + '&posY=' + ev.point.y,
      dataType: 'text',
      success: function(data) {
        console.log(data);
        if(data == "erreur" || !window.localStorage.getItem("accessToken")){
          //If there is no Biome where the user is
          removePlaylist();
        }else{
          changeToPlaylist(data);
        }
      },
      error: function(data){
      }
    });
  }

  //Ajax call to get all Biomes and show where they are with markers
  var getAllBiomes = function(){
    $.ajax({
      type: "POST",
      url: "getallbiomes",
      dataType: 'json',
      success: function(data) {
        for(i = 0; i < data.length; i++){
          var pos = new OpenLayers.LonLat(data[i].pos_x, data[i].pos_y);
          var mark = new OpenLayers.Marker(pos);
          markers.addMarker(mark);
        }
      },
      error: function(data){
      }
    });
  }

  //Geolocation event
  geolocate.events.register("locationupdated",geolocate,function(e) {
    ev = e;
    vector.removeAllFeatures();
    //Circle around user
    var circle = new OpenLayers.Feature.Vector(
      OpenLayers.Geometry.Polygon.createRegularPolygon(
        new OpenLayers.Geometry.Point(e.point.x, e.point.y),
        e.position.coords.accuracy/2,
        40,
        0
      ),
      {},
      style
    );
    //Vector representing where the user is
    vector.addFeatures([
      new OpenLayers.Feature.Vector(
        e.point,
        {},
        {
          graphicName: 'cross',
          strokeColor: '#f00',
          strokeWidth: 2,
          fillOpacity: 0,
          pointRadius: 10
        }
      ),
      circle
    ]);
    if (firstGeolocation) {
      //Centering and zooming the map where the user is
      map.zoomToExtent(vector.getDataExtent());
      //Animation of circle
      pulsate(circle);
      //Check if there is a Biome where the user is located
      getBiome();
      this.bind = true;
    }
  });

  geolocate.events.register("locationfailed",this,function() {
    OpenLayers.Console.log('Location detection failed');
  });

  //Activate geolocation
  geolocate.activate();

  //When the user clicks on the map
  OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {
    defaultHandlerOptions: {
        'single': true,
        'double': false,
        'pixelTolerance': 0,
        'stopSingle': false,
        'stopDouble': false
    },

    initialize: function(options) {
        this.handlerOptions = OpenLayers.Util.extend(
            {}, this.defaultHandlerOptions
        );
        OpenLayers.Control.prototype.initialize.apply(
            this, arguments
        );
        this.handler = new OpenLayers.Handler.Click(
            this, {
                'click': this.trigger
            }, this.handlerOptions
        );
    },

    trigger: function(e) {
      //Get lon and lat of where the user clicked
      var lonlat = map.getLonLatFromPixel(e.xy);
      //Sets the lonlat on the object given by geolocation
      ev.point.bounds.top = lonlat.lat;
      ev.point.bounds.bottom = lonlat.lat;
      ev.point.bounds.left = lonlat.lon;
      ev.point.bounds.right = lonlat.lon;
      ev.point.x = lonlat.lon;
      ev.point.y = lonlat.lat;
      //Deactivate the geolocation
      geolocate.deactivate();
      //Same as geolocation
      vector.removeAllFeatures();
      var circle = new OpenLayers.Feature.Vector(
        OpenLayers.Geometry.Polygon.createRegularPolygon(
          new OpenLayers.Geometry.Point(ev.point.x, ev.point.y),
          ev.position.coords.accuracy/2,
          40,
          0
        ),
        {},
        style
      );
      vector.addFeatures([
        new OpenLayers.Feature.Vector(
          ev.point,
          {},
          {
            graphicName: 'cross',
            strokeColor: '#f00',
            strokeWidth: 2,
            fillOpacity: 0,
            pointRadius: 10
          }
        ),
        circle
      ]);
      //Sets center of map without zooming
      map.setCenter(lonlat);
      //Animation of circle
      pulsate(circle);
      //Get the Biome the user is in
      getBiome();
    }
  });

  //Adds the click
  var click = new OpenLayers.Control.Click();
  map.addControl(click);
  //Activates it
  click.activate();

  //Gets all Biomes to show them
  getAllBiomes();
}

//Activates the geolocation when button is pressed
function activate(){
  geolocate.activate();
}
