'use strict';

function getAir(){
    try{
        fetch('https://services3.arcgis.com/Is0UwT37raQYl9Jj/arcgis/rest/services/ind_grandest/FeatureServer/0/query?where=lib_zone%3D%27Nancy%27&objectIds=&time=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&resultType=none&distance=0.0&units=esriSRUnit_Meter&returnGeodetic=false&outFields=*&returnGeometry=true&featureEncoding=esriDefault&multipatchOption=xyFootprint&maxAllowableOffset=&geometryPrecision=&outSR=&datumTransformation=&applyVCSProjection=false&returnIdsOnly=false&returnUniqueIdsOnly=false&returnCountOnly=false&returnExtentOnly=false&returnQueryGeometry=false&returnDistinctValues=false&cacheHint=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&having=&resultOffset=&resultRecordCount=&returnZ=false&returnM=false&returnExceededLimitFeatures=true&quantizationParameters=&sqlFormat=none&f=pjson&token=')
        .then((response) => response.json())
        .then((data) => {
            let date = data.features[0].attributes.date_ech;
            date = new Date(date).toISOString().substring(0, 10);
            let currentTime = new Date();

            let closestFeature = data.features.reduce((prev, curr) => {
                let prevDate = new Date(prev.attributes.date_ech);
                let currDate = new Date(curr.attributes.date_ech);
                return (Math.abs(currDate - currentTime) < Math.abs(prevDate - currentTime) ? curr : prev);
            });

            let closestDate = new Date(closestFeature.attributes.date_ech).toISOString().substring(0, 10);
            let closestColor = closestFeature.attributes.coul_qual;
            let closestQuality = closestFeature.attributes.lib_qual;
            let closestZone = closestFeature.attributes.lib_zone;

            document.getElementById('air').innerHTML = `Zone : ${closestZone}<br/> Qualitée de l'air : ${closestQuality}<br/> le ${closestDate}`;
            document.getElementById('airColor').style.backgroundColor = closestColor;
        });
    }catch (error) {
        console.error(error);
    }
}

export {getAir};