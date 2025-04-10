const maps = document.getElementsByClassName("osm-map");

for (const map of maps) {
    // stackoverflow.com/q/925164
    const markersElements = map.querySelectorAll(".osm-mark");
    const markersData = [];
    for (const element of markersElements) {
        const data = {
            "lat": element.getAttribute("lat"),
            "lon": element.getAttribute("lon"),
            "target": element.getAttribute("target")
        };
        markersData.push(data);
    }
    map.replaceChildren();
    let mapApi = L.map(map).setView([0, 0], 3);
    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(mapApi);
    for (const marker of markersData) {
        const target = L.latLng(marker.lat, marker.lon);
        const markerApi = L.marker(target);
        if (marker.target === "service") {
            mapApi.setView(target, 5);
            markerApi.bindPopup("This service should be here.").openPopup();
        }
        markerApi.addTo(mapApi);
    }
}
