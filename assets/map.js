// Map initialization and attractions display
document.addEventListener('DOMContentLoaded', function() {
    // Check if map element exists on the page
    const mapElement = document.getElementById('map');
    if (!mapElement) {
        return;
    }

    // Get API endpoint from data attribute
    const apiEndpoint = mapElement.dataset.apiEndpoint;
    if (!apiEndpoint) {
        console.error('API endpoint not specified');
        return;
    }

    // Initialize the map centered on Ukraine
    const map = L.map('map').setView([49.0, 32.0], 6);

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);


    // Appeller le controller MapController pour obtenir les attractions en JSON
    fetch(apiEndpoint)
        .then(response => response.json())
        .then(attractions => {
            if (attractions.length === 0) {
                console.warn('Aucune attraction dans la BD');
                return;
            }

            

            attractions.forEach(attraction => {
                // Only create marker if it has valid coordinates
                if (attraction.latitude && attraction.longitude) {
                    // Create marker
                    const marker = L.marker([attraction.latitude, attraction.longitude])
                        .addTo(map);

                    // Simple popup with name
                    marker.bindPopup(`
                        <div class="marker-popup">
                            <h5>${attraction.name}</h5>
                            ${attraction.category ? `<span class="category-badge">${attraction.category}</span><br>` : ''}
                            <img src="${attraction.image}" alt="${attraction.name}" class="attraction-image">
                            <button class="btn btn-primary btn-sm mt-2" onclick="window.location.href = '/attraction/${attraction.id}';">
                                Détail
                            </button>
                        </div>
                    `);
                }
            });

            // Adjust view to show all attractions
            const markers = [];
            Object.values(map._layers).forEach(layer => {
                if (layer instanceof L.Marker) {
                    markers.push(layer);
                }
            });

            if (markers.length > 0) {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        })
        .catch(error => {
            console.error('Error cargando atracciones:', error);
        });
});
