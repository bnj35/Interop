"use strict";

function getMeteo() {
  try {
    fetch(
      "https://www.infoclimat.fr/public-api/gfs/json?_ll=48,6&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2"
    )
      .then((response) => response.json())
      .then((data) => {
        let today = new Date().toISOString().split('T')[0];
        let times = { matin: '07:00:00', midi: '13:00:00', soir: '19:00:00' };
        let weatherData = {};

        for (let period in times) {
          let time = times[period];
          weatherData[period] = {
            temperature: data[`${today} ${time}`]?.temperature?.['2m'] ? (data[`${today} ${time}`].temperature['2m'] - 273.15).toFixed(2) + ' °C' : 'No data available',
            vent: data[`${today} ${time}`]?.vent_moyen?.['10m']  + ' km/h'|| 'No data available',
            rafale: data[`${today} ${time}`]?.vent_rafales?.['10m'] + ' km/h'|| 'No data available',
            humidite: data[`${today} ${time}`]?.humidite?.['2m'] + ' %'|| 'No data available' ,
          };
        }

        let meteoDiv = document.getElementById('meteo');
        meteoDiv.innerHTML = `
          <h2>Meteo du ${today}</h2>
          <p><strong>Matin:</strong><br/> Temperature: ${weatherData.matin.temperature}<br/> Vent: ${weatherData.matin.vent}<br/> Rafales: ${weatherData.matin.rafale}<br/> Humidité: ${weatherData.matin.humidite}</p><br/>
          <p><strong>Midi:</strong><br/> Temperature: ${weatherData.midi.temperature}<br/> Vent: ${weatherData.midi.vent}<br/> Rafales: ${weatherData.midi.rafale}<br/> Humidité: ${weatherData.midi.humidite}</p><br/>
          <p><strong>Soir:</strong><br/> Temperature: ${weatherData.soir.temperature}<br/> Vent: ${weatherData.soir.vent}<br/> Rafales: ${weatherData.soir.rafale}<br/> Humidité: ${weatherData.soir.humidite}</p><br/>
        `;

      });
  } catch (error) {
    console.error(error);
  }
}

export { getMeteo };
