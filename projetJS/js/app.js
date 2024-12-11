'use strict';

var map = L.map("map").setView([48, 6], 13);
let userLocation = navigator.geolocation;
var VeloUrl = "https://api.cyclocity.fr/contracts/nancy/gbfs/gbfs.json";
var EauUSeeUrl ="https://www.data.gouv.fr/fr/datasets/r/2963ccb5-344d-4978-bdd3-08aaf9efe514";

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
  console.log("lat", lat);
  console.log("long", long);
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
        let SystemUrl = data.data.fr.feeds[2].url;
        let StationsStatusUrl = data.data.fr.feeds[3].url;
        let VehicleUrl = data.data.fr.feeds[4].url;
        try {
          fetch(StationsInfoUrl)
            .then((response) => response.json())
            .then((data) => {
              console.log(data);
                let stations = data.data.stations;
                stations.forEach(e => {
                    e.lat = parseFloat(e.lat);
                    e.lon = parseFloat(e.lon);
                    let marker = L.marker([e.lat, e.lon]).addTo(map);
                    marker.bindPopup(e.name);
                    
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


//////////////////////////////////////////////////////////
const ctx = document.getElementById('myChart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});