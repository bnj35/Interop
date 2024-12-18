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
                    let marker = L.marker([e.lat, e.lon]).addTo(map);
                    marker.bindPopup(e.name);
                    
                });
            });
        } catch (e) {
          console.log(e);
        }
        try {
          fetch(StationsStatusUrl)
            .then((response) => response.json())
            .then((data) => {
              let stationsInfo = data.data.stations;
              console.log(stationsInfo);
            });
        }
        catch (e) {
          console.log(e);
        }
      });
  } catch (e) {
    console.log(e);
  }
}

GetPlaces();
myGeolocator();



//////////////////////////////////////////////////////////
// const ctx = document.getElementById('myChart');

// new Chart(ctx, {
//   type: 'bar',
//   data: {
//     labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
//     datasets: [{
//       label: '# of Votes',
//       data: [12, 19, 3, 5, 2, 3],
//       borderWidth: 1
//     }]
//   },
//   options: {
//     scales: {
//       y: {
//         beginAtZero: true
//       }
//     }
//   }
// });