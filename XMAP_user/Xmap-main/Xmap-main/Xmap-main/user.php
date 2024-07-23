<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Campus Navigation</title>
  <link href='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css' rel='stylesheet' />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <style>
            * {
            box-sizing: border-box;
        }
        body {
            color: #404040;
            font: 400 15px/22px 'Source Sans Pro', 'Helvetica Neue', sans-serif;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        h1 {
            font-size: 22px;
            margin: 0;
            font-weight: 400;
            line-height: 20px;
            padding: 20px 2px;
        }

        a {
            color: #404040;
            text-decoration: none;
        }

        a:hover {
            color: #101010;
        }

        /* The page is split between map and sidebar - the sidebar gets 1/3, map gets 2/3 of the page. You can adjust this to your personal liking. */
        .sidebar {
            position: absolute;
            width: 33.3333%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            border-right: 1px solid rgb(0 0 0 / 25%);
            
        }

        #map {
            position: absolute;
            left: 33.3333%;
            width: 66.6666%;
            top: 0;
            bottom: 0;
        }
        #imMenuBox{
            position: absolute;
            z-index:999 ;
            border-bottom-right-radius:20px;
            width:50px;
            height:50px;
            cursor:pointer;
            transition:0.6s opacity;
            display: none;
            background-color:white; 
            box-shadow: rgba(0, 73, 144, 0.5) 1px 6px 11px;
            top:0;       
        }
        #imMenu{
            width:40px;
        }
        .heading {
            background: #fff;
            border-bottom: 1px solid #eee;
            height: 60px;
            line-height: 60px;
            padding: 0 10px;
        }

        .listings {
            height: 100%;
            overflow: auto;
            padding-bottom: 60px;
        }

        .listings .item {
            border-bottom: 1px solid #eee;
            padding: 10px;
            text-decoration: none;
        }

        .listings .item:last-child {
            border-bottom: none;
        }

        .listings .item .title {
            display: block;
            color: rgba(0, 73, 144);
            font-weight: 700;
        }

        .listings .item .title small {
            font-weight: 400;
        }

        .listings .item.active .title,
        .listings .item .title:hover {
            color: rgba(0, 73, 144);
            
        }

        .listings .item.active {
            background-color: #f8f8f8;
            
        }

        ::-webkit-scrollbar {
            width: 3px;
            height: 3px;
            border-left: 0;
            background: rgba(0 0 0 0.1);
        }

        ::-webkit-scrollbar-track {
            background: none;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 73, 144);
            border-radius: 0;
        }

        /* Marker tweaks */
        .mapboxgl-popup-close-button {
            display: none;
        }

        .mapboxgl-popup-content {
            font: 400 15px/22px 'Source Sans Pro', 'Helvetica Neue', sans-serif;
            padding: 0;
            width: 180px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px,
            rgba(0, 73, 144, 0.5) 1px 6px 11px;
            cursor: pointer;
            user-select: none;
        }

        .mapboxgl-popup-content h3 {
            background-color: rgba(0, 73, 144);
 

            color: #fff;
            margin: 0;
            padding: 10px;
            border-radius: 3px 3px 0 0;
            font-weight: 700;
            margin-top: -15px;
        }

        .mapboxgl-popup-content h4 {
            margin: 0;
            padding: 10px;
            font-weight: 400;
            
        }

        .mapboxgl-popup-content div {
            padding: 10px;
        }

        .mapboxgl-popup-anchor-top > .mapboxgl-popup-content {
            margin-top: 15px;
        }

        .mapboxgl-popup-anchor-top > .mapboxgl-popup-tip {
            border-bottom-color: #91c949;
        }

        .mapboxgl-ctrl {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .mapboxgl-ctrl button {
            background-color: #00853e;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .mapboxgl-ctrl button:hover {
            background-color: #005f2a;
        }
        #mainpage{
            width: 100vw;
            height: 100vh;
            display: flex;

            align-items: center;
            justify-content: center;
        }
      
        #popI{
            position: fixed;
            top: 50%;
            left: 50%;
            width: auto;
            height: auto;
            transform: translate(-50%,-50%);
            z-index: 1000;
            background-color:transparent;
        }
        #pop{
            width: 50vw;
            height: 80vh;
            background-color: rgba(168, 168, 168,0.4 );
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.223);
            color: rgb(133, 133, 133);
            font-weight: 600;
            border-radius: 20px;
            display:grid;
            grid-template-columns: 25vw 25vw;
            font: 400 15px/22px 'Source Sans Pro', 'Helvetica Neue', sans-serif;
        }
        #imone{
            width: 25vw;
            height:80vh;
            border-radius:20px;
        }
        #popmain{
            display:block;
            
        }
        #popvone{
            display:flex;
            align-items:center;
            justify-content:center;
            
        }
        #controls { position: absolute; top: -100px; left: 10px; background: white; padding: 10px; z-index: -1000; }
        #closebtn{
            width: 50px;
            height:50px;

            border-radius:50px;
            background-color:transparent;
            outline:none;
            font-weight:bold;
            font-size:20px;
            border:none;
            color:red;
            cursor:pointer;
        }
        #prevBtn,#nextBtn{background-color:rgba(0, 73, 144);border-radius:20px;width:200px;color:white;outline:none;padding:5px;}
        /*Below style Codes for heading,description */
        #popvtwo,#popvthree{
            padding:10px;

            font-size:20px;
        }
        /**grid divide dont't touch it.**/
        #popM{
            display:grid;
            grid-template-rows: 40vh 40vh;
        }

        @media screen and (max-width: 769px) {
            #pop{
            width: 60vw;
            height: 80vh;
            border-radius: 20px;
            display:grid;
            grid-template-columns: 60vw;
            grid-template-rows: 40vh 40vh;
            
        }
        #imone{
            width: 60vw;
            height:40vh;
            border-radius:20px;
        }
        /**grid divide dont't touch it.**/
        #popM{
            display:grid;
            grid-template-rows: 20vh 20vh;
        }
        .sidebar {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0%;
            overflow: hidden;
            border-right: 1px solid rgb(0 0 0 / 25%);
            z-index: 950;
            background-color:white;
            display: none;
        }

        #map {
            position: absolute;
            left: 0%;
            width: 100%;
            top: 0;
            bottom: 0;
        }
        #imMenuBox{
            display: block;
            

        }
        .heading{
            margin-top:50px;
        }
        #prevBtn,#nextBtn{background-color:rgba(0, 73, 144);border-radius:20px;width:150px;}
        }
        
 
  </style>
</head>
<body>
<div class="sidebar">
  <div class="heading">
    <h1>Stalls</h1>
  </div>
  <div id="page-bgbtm">
    <div class="container">
      <div id="listings" class="listings">
        <!-- Items will be inserted here by JavaScript -->
      </div>
      <div class="pagination">
        <button id="prevBtn" onclick="changePage(-1)" >Previous</button>
        <span id="pageIndicator"></span>
        <button id="nextBtn" onclick="changePage(1)">Next</button>
      </div>
    </div>
  </div>
</div>

<div id="imMenuBox">
  <img src="Images/icons8-menu-30.png" alt="menu" id="imMenu">
</div>
<div id="map" class="map"></div>
<div class="mapboxgl-ctrl">
  <button id="stop-animations" style="background-color:rgba(0, 73, 144);border-radius:20px;width:200px;">Stop Animations</button>
  <button id="reset" style="background-color:rgba(0, 73, 144);border-radius:20px;width:200px;">Reset</button>
</div>
  <div id="controls">
    <label for="start">Start:</label>
    <input type="text" id="start" placeholder="Enter start coordinates" value="80.00604808283589, 7.092531367818253"><br>
    <label for="end">End:</label>
    <input type="text" id="end" placeholder="Enter destination coordinates" value="80.00647114447446, 7.092212198348719"><br>
    <button id="navigateButton">Navigate</button>
  </div>
  <script src='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js'></script>
  <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.0/mapbox-gl-directions.js'></script>
  <link href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.0/mapbox-gl-directions.css' rel='stylesheet' />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Turf.js/6.5.0/turf.min.js"></script>
  <script>
        //trasition for slidebar

        $(document).ready(function(){
    $("#imMenuBox").click(function(){
        $(".sidebar").toggle();
    });
});

    //for map(Live tracking)
    mapboxgl.accessToken = 'pk.eyJ1IjoiY3lwaGVyZGV2IiwiYSI6ImNseHZlaXluZzBtbmUya3ByOGY4NWhycGIifQ.pm9qlZiuaZm-RNwK6P3JVQ';
    const campusCenter = [80.0063, 7.0922];

    const map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/cypherdev/clyldm8zb005m01plc6xm0rlc/draft', // Use default Mapbox style for testing
      center: campusCenter,
      zoom: 15
    });

    map.addControl(new mapboxgl.NavigationControl());

    const directions = new MapboxDirections({
      accessToken: mapboxgl.accessToken,
      unit: 'metric',
      profile: 'mapbox/driving',
    });
    
    map.addControl(directions, 'top-left');
    const pointsOfInterest = {
  "type": "FeatureCollection",
  "features": [
    { "type": "Feature", "properties": { "address": "You Are Here" }, "geometry": { "coordinates": [0,0], "type": "Point" }, "id": 8 },
    { "type": "Feature", "properties": { "address": "Mahindodaya Technical Lab", "city": "Test" }, "geometry": { "coordinates": [80.00574674807206, 7.092723826805624], "type": "Point" }, "id": 1 },
    { "type": "Feature", "properties": { "address": "Main Hall" }, "geometry": { "coordinates": [80.00647114447446, 7.092212198348719], "type": "Point" }, "id": 1 },
    { "type": "Feature", "properties": { "address": "Science Labs" }, "geometry": { "coordinates": [80.00637827086848, 7.092696455083924], "type": "Point" }, "id": 2 },
    { "type": "Feature", "properties": { "address": "Science Section" }, "geometry": { "coordinates": [80.00608511203308, 7.091732004582838], "type": "Point" }, "id": 3 },
    { "type": "Feature", "properties": { "address": "BCCS" }, "geometry": { "coordinates": [80.00609159066869, 7.0914512637026235], "type": "Point" }, "id": 4 },
    { "type": "Feature", "properties": { "address": "Class Rooms" }, "geometry": { "coordinates": [80.00584296440519, 7.091446088836932], "type": "Point" }, "id": 5 },
    { "type": "Feature", "properties": { "address": "6-11 Labs" }, "geometry": { "coordinates": [80.00595069963299, 7.0917579857526505], "type": "Point" }, "id": 6 },
    { "type": "Feature", "properties": { "address": "Auditorium" }, "geometry": { "coordinates": [80.00574307629938, 7.092116542554379], "type": "Point" }, "id": 7 }
  ]
};

// Iterate over the features array

pointsOfInterest.features.forEach(feature => {
  new mapboxgl.Marker()
    .setLngLat(feature.geometry.coordinates)
    .setPopup(new mapboxgl.Popup().setHTML(`<h3>${feature.properties.address}</h3>`))
    .addTo(map);
});
    document.getElementById('navigateButton').addEventListener('click', () => {
      const start = document.getElementById('start').value.split(',').map(Number);
      const end = document.getElementById('end').value.split(',').map(Number);
      directions.setOrigin(start);
      directions.setDestination(end);
    });

    
    let userMarker;
    let lastPosition;

    if (navigator.geolocation) {
  navigator.geolocation.watchPosition(position => {
    const userLocation = [position.coords.longitude, position.coords.latitude];
    console.log(userLocation);
         // Update the 0th index with the live user location
         pointsOfInterest.features[0].geometry.coordinates = userLocation;

// Center the map to the user's location
map.setCenter(userLocation);

// Add or update the user marker
if (userMarker) {
  userMarker.setLngLat(userLocation);
} else {
  userMarker = new mapboxgl.Marker({ color: 'Red' })
    .setLngLat(userLocation)
    .setPopup(new mapboxgl.Popup().setHTML("<h3>You are here</h3>"))
    .addTo(map);
}

// Optionally set the origin for directions (if using Mapbox Directions API)
if (typeof directions !== 'undefined') {
  directions.setOrigin(userLocation);
}

// Adjust the map's bearing if lastPosition is available
if (lastPosition) {
  const bearing = turf.bearing(
    turf.point([lastPosition.coords.longitude, lastPosition.coords.latitude]),
    turf.point(userLocation)
  );
  map.setBearing(bearing);
}


   

    lastPosition = position;
  }, error => {
    console.error(error);
  }, {
    enableHighAccuracy: true,
    timeout: 10000,
    maximumAge: 0
  });
} else {
  alert("Geolocation is not supported by this browser.");
}

    //for map (mainly)
    let rotating = true;
        let initialView = {
            center: [80.0063, 7.0922],
            zoom: 18.5,
            pitch: 55,
            bearing: -12.6,
            essential: true // Ensure smooth animation even when zooming in repeatedly
        };

        /* Assign a unique ID to each store */
        pointsOfInterest.features.forEach(function (store, i) {
            store.properties.id = i;
        });

        map.on('load', () => {
            /* Add the data to your map as a layer */
            map.addLayer({
                id: 'locations',
                type: 'circle',
                source: {
                    type: 'geojson',
                    data: pointsOfInterest
                }
            });
            renderItems(); // Render the first page of items
        });

        map.on('click', (event) => {
            const features = map.queryRenderedFeatures(event.point, {
                layers: ['locations']
            });

            if (!features.length) return;

            const clickedPoint = features[0];

            flyToStore(clickedPoint);
            createPopUp(clickedPoint);

            const activeItem = document.getElementsByClassName('active');
            if (activeItem[0]) {
                activeItem[0].classList.remove('active');
            }

            const listing = document.getElementById(`listing-${clickedPoint.properties.id}`);
            listing.classList.add('active');

            rotating = false;
            resetButton.disabled = false;

            document.getElementById('reset').style.display = 'block';
        });
        function isMobile() {
    return window.innerWidth <= 768; // or any breakpoint you consider for mobile
}

        const itemsPerPage = 5;
        let currentPage = 1;
        const items = pointsOfInterest.features; // Use the features as items

        function buildLocationList(pointsOfInterest) {
    const listings = document.getElementById('listings');
    listings.innerHTML = ''; // Clear previous listings

    for (const store of pointsOfInterest) {
        const listing = listings.appendChild(document.createElement('div'));
        listing.id = `listing-${store.properties.id}`;
        listing.className = 'item';

        const link = listing.appendChild(document.createElement('a'));
        link.href = '#';
        link.className = 'title';
        link.id = `link-${store.properties.id}`;
        link.innerHTML = `${store.properties.address}`;

        const details = listing.appendChild(document.createElement('div'));
        details.innerHTML = `${store.properties.city}`;

        link.addEventListener('click', function () {
            for (const feature of items) {
                if (this.id === `link-${feature.properties.id}`) {
                    flyToStore(feature);
                    createPopUp(feature);

                    // Set the destination coordinates
                    const endCoordinates = feature.geometry.coordinates;
                    directions.setDestination(endCoordinates);
                    
                    // Optionally set the origin if needed
                    directions.setOrigin(userMarker.getLngLat());

                    // Update the active item
                    const activeItem = document.getElementsByClassName('active');
                    if (activeItem[0]) {
                        activeItem[0].classList.remove('active');
                    }
                    this.parentNode.classList.add('active');
                    
                    // Make sure the sidebar is visible
                    document.querySelector('.sidebar').style.display = 'block';
                    if (isMobile()) {
                        document.querySelector('.sidebar').style.display = 'none';
                    }
                }
            }
        });
    }
}


        function renderItems() {
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const paginatedItems = items.slice(start, end);

            buildLocationList(paginatedItems);

            document.getElementById('pageIndicator').textContent = `Page ${currentPage} of ${Math.ceil(items.length / itemsPerPage)}`;
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === Math.ceil(items.length / itemsPerPage);
        }

        function changePage(direction) {
            currentPage += direction;
            renderItems();
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderItems();
        });

        

        function flyToStore(currentFeature) {
            map.flyTo({
                center: currentFeature.geometry.coordinates,
                zoom: 20,
                essential: true // Ensure smooth animation even when zooming in repeatedly
            });
        }

        function createPopUp(currentFeature) {
            const popUps = document.getElementsByClassName('mapboxgl-popup');
            /** Check if there is already a popup on the map and if so, remove it */
            if (popUps[0]) popUps[0].remove();

            const popup = new mapboxgl.Popup({ closeOnClick: false })
                .setLngLat(currentFeature.geometry.coordinates)
                .setHTML(`<h3>XMAP - Powered by TEAMBCCS</h3><h4>${currentFeature.properties.address}</h4>`)
                .addTo(map);
        }

        // Rotate animation
        let rotationFrame;

        function rotateCamera(timestamp) {
            if (rotating) {
                map.rotateTo((timestamp / 100) % 360, { duration: 0 });
                rotationFrame = requestAnimationFrame(rotateCamera);
            }
        }
        rotateCamera(0);

        //Stop Animation
        const stopAnimationsButton = document.getElementById('stop-animations');
        stopAnimationsButton.addEventListener('click', () => {
            rotating = false;
            cancelAnimationFrame(rotationFrame);
        });

        //reset
        const resetButton = document.getElementById('reset');
        resetButton.addEventListener('click', () => {

            const popUps = document.getElementsByClassName('mapboxgl-popup');            
            const activeItem = document.getElementsByClassName('active');
            if (activeItem[0]) {
                activeItem[0].classList.remove('active');
            }
            if (popUps[0]) popUps[0].remove();//remove popup with reset
            rotating = true;
            map.setZoom(initialView.zoom); // Reset zoom level
            map.setCenter(initialView.center); // Reset center
            rotateCamera(0); // Restart rotation
            resetButton.disabled = false;
            document.getElementById('reset').style.display='bock';
        });
        //refresh the popup(ads)
        var popMain = document.getElementById('popI');
    setInterval(function() {
        $('#popI').load(location.href + ' #popI');
    }, 1000); // Refresh the popI after 1 seconds :1000

    //when button click close the button.
    function remove(){  
        popMain.style.display='none';
        setTimeout(function() {
            popMain.style.display='block';
        }, 9000);// Refresh the popI for display status after 9 seconds :9000
    }


  </script>
</body>
</html>

