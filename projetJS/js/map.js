'use strict';

let lat = 48.692054;
let lon = 6.184417;

    navigator.geolocation.getCurrentPosition((position) => {
    console.log(position.coords.latitude, position.coords.longitude);
    lat = position.coords.latitude;
    lon = position.coords.longitude;
    });

var map = L.map("map").setView([lat, lon], 13);
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19,
}).addTo(map);



async function getStations() {
    try {
       const response = await fetch("https://api.cyclocity.fr/contracts/nancy/gbfs/station_information.json")
        const data = await response.json();
        return data.data.stations;
    }catch (error) {
        console.error(error);
    }
}

async function getStationStatut(Id) {
    try{
        const response = await fetch("https://api.cyclocity.fr/contracts/nancy/gbfs/station_status.json")
        const data = await response.json();
        return data.data.stations.find((station) => station.station_id === Id);
    }catch (error) {
        console.error(error);
    }
}

async function addPopup() {
    const stations = await getStations();
    stations.forEach(async (station) => {
        const statut = await getStationStatut(station.station_id);
        const marker = L.marker([station.lat, station.lon]).addTo(map);
        marker.bindPopup(`<b>${station.name}</b><br>Velos disponibles: ${statut.num_bikes_available}<br>Emplacements disponibles: ${statut.num_docks_available}`);
    });
}


export {addPopup};
