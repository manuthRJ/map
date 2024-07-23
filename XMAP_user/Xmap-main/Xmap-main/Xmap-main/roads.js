mapboxgl.accessToken = 'pk.eyJ1IjoiY3lwaGVyZGV2IiwiYSI6ImNseHZlaXluZzBtbmUya3ByOGY4NWhycGIifQ.pm9qlZiuaZm-RNwK6P3JVQ'; // Replace with your Mapbox access token

const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/cypherdev/clybouz7s00eb01pfhk6a7lkn', // Replace with your Mapbox style URL
    center: [80.0063, 7.0922], // Initial center of the map
    zoom: 14 // Initial zoom level
});

let routes = [];
let routeIndex = 0;
let animationFrame;
let isPaused = false;

map.on('load', () => {
    // Get the roads layer data
    const roadsLayer = map.getStyle().layers.find(layer => layer.id === 'road');
    if (roadsLayer) {
        const source = map.getSource(roadsLayer.source);
        if (source) {
            map.getSource(roadsLayer.source).tiles.forEach(url => {
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        data.features.forEach(feature => {
                            if (feature.geometry.type === 'LineString') {
                                routes.push(feature.geometry.coordinates);
                            }
                        });
                    });
            });
        }
    }
});

document.getElementById('start').addEventListener('click', () => {
    isPaused = false;
    animate();
});

document.getElementById('pause').addEventListener('click', () => {
    isPaused = true;
    cancelAnimationFrame(animationFrame);
});

document.getElementById('reset').addEventListener('click', () => {
    isPaused = true;
    cancelAnimationFrame(animationFrame);
    routeIndex = 0;
    map.flyTo({ center: routes[0][0], zoom: 14 });
});

function animate() {
    if (isPaused) return;

    if (routeIndex < routes.length) {
        const coordinates = routes[routeIndex];
        routeIndex++;
        map.flyTo({ center: coordinates[0], zoom: 14 });
        animationFrame = requestAnimationFrame(animate);
    } else {
        routeIndex = 0; // Restart the animation
        animate();
    }
}
