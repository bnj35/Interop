'use strict';

var map = L.map("map").setView([48, 6], 13);
let userLocation = navigator.geolocation;
var VeloUrl = "https://api.cyclocity.fr/contracts/nancy/gbfs/gbfs.json";
var EauUSeeUrl ="https://www.data.gouv.fr/fr/datasets/r/2963ccb5-344d-4978-bdd3-08aaf9efe514";

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

function myGeolocator() {
  if (userLocation) {
    userLocation.getCurrentPosition(success);
    
  } else {
    ("Geolocalisation pas supporté.");
  }
}


function success(data) {
  let lat = data.coords.latitude;
  let long = data.coords.longitude;
  map.setView([lat, long], 13);
}

function convertir_radian(nb) {
  return (Math.PI * nb) / 180;
}

function GetPlaces() {
  try {
    fetch(VeloUrl)
      .then((response) => response.json())
      .then((data) => {
        let StationsInfoUrl = data.data.fr.feeds[1].url;
        let StationsStatusUrl = data.data.fr.feeds[3].url;
        try {
          fetch(StationsInfoUrl)
            .then((response) => response.json())
            .then((data) => {
              console.log(data);
                let stations = data.data.stations;
                stations.forEach(e => {
                    e.lat = parseFloat(e.lat);
                    e.lon = parseFloat(e.lon);
                    var stationid = e.station_id;

                    let marker = L.marker([e.lat, e.lon]).addTo(map);
                    marker.bindPopup(e.name);
                    marker.on('click', function (e) {
                      console.log(e);
                      fetch(StationsStatusUrl)
                        .then((response) => response.json())
                        .then((data) => {
                          let stationsInfo = data.data.stations;
                          let station = stationsInfo.find(s => s.station_id == stationid);
                          marker.bindPopup("Nom: " + e.name + "<br> Vélos disponibles: " + station.num_bikes_available + "<br> Emplacements disponibles: " + station.num_docks_available).openPopup();
                        });
                    });
                    
                });
            });
        } catch (e) {
          console.log(e);
        }
      });
  } catch (e) {
    console.log(e);
  }
}

GetPlaces();
myGeolocator();
