<!DOCTYPE html>
<html>
<head>
    <title>Leaflet Map with BFS Algorithm</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map { height: 600px; }
    </style>
</head>
<body>
    <div id="map"></div>
    <button onclick="findShortestPath()">Find Shortest Path</button>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var points = @json($points);

        var markers = {};
        points.forEach(function(point) {
            var marker = L.marker([point.latitude, point.longitude]).addTo(map);
            marker.bindPopup(point.name);
            markers[point.id] = marker;
        });

        function findShortestPath() {
            var start = prompt("Enter the start point ID:");
            var end = prompt("Enter the end point ID:");

            fetch('/find-shortest-path', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    start: start,
                    end: end
                })
            })
            .then(response => response.json())
            .then(data => {
                var polylinePoints = data.map(id => {
                    var point = points.find(p => p.id == id);
                    return [point.latitude, point.longitude];
                });

                var polyline = L.polyline(polylinePoints, { color: 'blue' }).addTo(map);
                map.fitBounds(polyline.getBounds());
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>
