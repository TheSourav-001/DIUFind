<?php require APPROOT . '/views/inc/header.php'; ?>

<style>
    /* Full-screen map container */
    #map-container {
        position: relative;
        width: 100%;
        height: calc(100vh - 80px);
        margin: 0;
        padding: 0;
    }

    #map {
        width: 100%;
        height: 100%;
    }

    /* Map controls overlay */
    .map-controls {
        position: absolute;
        top: 20px;
        left: 60px;
        z-index: 1000;
        background: var(--md-sys-color-surface);
        padding: 16px;
        border-radius: var(--md-sys-shape-corner-large);
        box-shadow: var(--md-sys-elevation-2);
        max-width: 300px;
    }

    .map-legend {
        position: absolute;
        bottom: 30px;
        right: 20px;
        z-index: 1000;
        background: var(--md-sys-color-surface);
        padding: 16px;
        border-radius: var(--md-sys-shape-corner-medium);
        box-shadow: var(--md-sys-elevation-2);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .legend-marker {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid white;
    }

    .filter-buttons {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }

    /* Custom marker popup */
    .leaflet-popup-content {
        margin: 0;
        padding: 0;
        width: 250px !important;
    }

    .marker-popup {
        padding: 12px;
    }

    .marker-popup img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .marker-popup h3 {
        margin: 0 0 8px 0;
        font-size: 16px;
        color: var(--md-sys-color-on-surface);
    }

    .marker-popup p {
        margin: 4px 0;
        font-size: 13px;
        color: var(--md-sys-color-on-surface-variant);
    }

    .marker-popup .view-btn {
        margin-top: 8px;
    }
</style>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div id="map-container">
    <!-- Map Controls -->
    <div class="map-controls">
        <h3 class="title-medium" style="margin: 0 0 12px 0;">
            <i class="fa-solid fa-map-location-dot" style="color: var(--md-sys-color-primary);"></i>
            DIU Campus Map
        </h3>
        <p class="body-small" style="margin: 0 0 12px 0; color: var(--md-sys-color-on-surface-variant);">
            Real-time Lost & Found locations
        </p>

        <!-- Filter Buttons -->
        <div class="filter-buttons">
            <button id="filter-all" class="md-button md-button-filled" style="font-size: 12px; padding: 8px 12px;">
                All Items
            </button>
            <button id="filter-lost" class="md-button md-button-outlined" style="font-size: 12px; padding: 8px 12px;">
                Lost Only
            </button>
            <button id="filter-found" class="md-button md-button-outlined" style="font-size: 12px; padding: 8px 12px;">
                Found Only
            </button>
        </div>

        <!-- Stats -->
        <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--md-sys-color-outline);">
            <div class="body-small" style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                <span>Total Items:</span>
                <strong id="total-count">0</strong>
            </div>
            <div class="body-small" style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                <span style="color: #FF5252;">Lost:</span>
                <strong id="lost-count" style="color: #FF5252;">0</strong>
            </div>
            <div class="body-small" style="display: flex; justify-content: space-between;">
                <span style="color: #4CAF50;">Found:</span>
                <strong id="found-count" style="color: #4CAF50;">0</strong>
            </div>
        </div>
    </div>

    <!-- Legend -->
    <div class="map-legend">
        <h4 class="label-large" style="margin: 0 0 12px 0;">Legend</h4>
        <div class="legend-item">
            <div class="legend-marker" style="background: #FF5252;"></div>
            <span class="body-small">Lost Item</span>
        </div>
        <div class="legend-item">
            <div class="legend-marker" style="background: #4CAF50;"></div>
            <span class="body-small">Found Item</span>
        </div>
    </div>

    <!-- The Map -->
    <div id="map"></div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // ===== DIU CAMPUS MAP =====
    const DIU_CENTER = [23.876292, 90.321189]; // DIU Smart City
    const DEFAULT_ZOOM = 16;

    // Pre-defined DIU landmarks
    const diuLocations = {
        'Knowledge Tower': [23.8765, 90.3210],
        'Inspiration Building': [23.8758, 90.3205],
        'Bonmaya/Lake Side': [23.8770, 90.3220],
        'Engineering Complex': [23.8750, 90.3200],
        'Main Gate': [23.8780, 90.3225],
        'Library': [23.8762, 90.3212]
    };

    // Initialize map
    const map = L.map('map', {
        center: DIU_CENTER,
        zoom: DEFAULT_ZOOM,
        maxZoom: 19,
        minZoom: 14,
        maxBounds: [[23.870, 90.315], [23.882, 90.328]] // Campus boundary
    });

    // Add Google Hybrid (Satellite + Labels) tiles for detail
    L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: '&copy; Google Maps | DIU Find'
    }).addTo(map);

    // Custom marker icons
    const lostIcon = L.divIcon({
        className: 'custom-marker',
        html: '<div style="background: #FFCDD2; width: 30px; height: 30px; border-radius: 50%; border: 3px solid #E57373; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"></div>',
        iconSize: [30, 30],
        iconAnchor: [15, 15]
    });

    const foundIcon = L.divIcon({
        className: 'custom-marker',
        html: '<div style="background: #C8E6C9; width: 30px; height: 30px; border-radius: 50%; border: 3px solid #81C784; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"></div>',
        iconSize: [30, 30],
        iconAnchor: [15, 15]
    });


    // Check if we need to focus on a specific post
    const urlParams = new URLSearchParams(window.location.search);
    const focusPostId = urlParams.get('focus');
    // Store markers for filtering
    let allMarkers = [];
    let lostMarkers = [];
    let foundMarkers = [];

    // Fetch and display posts
    async function loadMapData() {
        try {
            const response = await fetch('<?php echo URLROOT; ?>/posts/getMapData');
            const data = await response.json();

            if (data.success) {
                displayMarkers(data.posts);
                updateStats(data.posts);
            }
        } catch (error) {
            console.error('Error loading map data:', error);
        }
    }

    // Display markers on map
    function displayMarkers(posts) {
        // Clear existing markers
        allMarkers.forEach(marker => map.removeLayer(marker));
        allMarkers = [];
        lostMarkers = [];
        foundMarkers = [];

        posts.forEach(post => {
            const isFocused = focusPostId && post.id == focusPostId;
            let icon;
            if (isFocused) {
                icon = L.divIcon({ className: 'custom-marker', html: '<div style="background: #FFD54F; width: 40px; height: 40px; border-radius: 50%; border: 4px solid #FFA000; box-shadow: 0 4px 12px rgba(255,165,0,0.6);"></div>', iconSize: [40, 40], iconAnchor: [20, 20] });
            } else {
                icon = post.type === 'Lost' ? lostIcon : foundIcon;
            }
            const marker = L.marker([post.latitude, post.longitude], { icon: icon });
            if (isFocused) { setTimeout(() => { map.setView([post.latitude, post.longitude], 18); marker.openPopup(); }, 500); }
            if (post.latitude && post.longitude) {

                const marker = L.marker([post.latitude, post.longitude], { icon: icon });

                // Create popup content
                const popupContent = `
                <div class="marker-popup">
                    ${post.image ? `<img src="<?php echo UPLOAD_URL; ?>${post.image}" alt="${post.title}">` : ''}
                    <h3>${post.title}</h3>
                    <p><i class="fa-solid fa-tag"></i> ${post.type}</p>
                    <p><i class="fa-solid fa-location-dot"></i> Last seen here</p>
                    <p class="body-small" style="color: var(--md-sys-color-on-surface-variant);">
                        ${post.created_at}
                    </p>
                    <a href="<?php echo URLROOT; ?>/posts/show/${post.id}" 
                       class="md-button md-button-filled view-btn" 
                       style="width: 100%; text-align: center;">
                        View Details
                    </a>
                </div>
            `;

                marker.bindPopup(popupContent, { maxWidth: 250 });
                marker.addTo(map);

                allMarkers.push(marker);
                if (post.type === 'Lost') {
                    lostMarkers.push(marker);
                } else {
                    foundMarkers.push(marker);
                }
            }
        });
    }

    // Update stats
    function updateStats(posts) {
        const lostCount = posts.filter(p => p.type === 'Lost').length;
        const foundCount = posts.filter(p => p.type === 'Found').length;

        document.getElementById('total-count').textContent = posts.length;
        document.getElementById('lost-count').textContent = lostCount;
        document.getElementById('found-count').textContent = foundCount;
    }

    // Filter functionality
    document.getElementById('filter-all').addEventListener('click', function () {
        allMarkers.forEach(marker => marker.addTo(map));
        updateFilterButtons('all');
    });

    document.getElementById('filter-lost').addEventListener('click', function () {
        allMarkers.forEach(marker => map.removeLayer(marker));
        lostMarkers.forEach(marker => marker.addTo(map));
        updateFilterButtons('lost');
    });

    document.getElementById('filter-found').addEventListener('click', function () {
        allMarkers.forEach(marker => map.removeLayer(marker));
        foundMarkers.forEach(marker => marker.addTo(map));
        updateFilterButtons('found');
    });

    function updateFilterButtons(active) {
        document.getElementById('filter-all').className = active === 'all' ? 'md-button md-button-filled' : 'md-button md-button-outlined';
        document.getElementById('filter-lost').className = active === 'lost' ? 'md-button md-button-filled' : 'md-button md-button-outlined';
        document.getElementById('filter-found').className = active === 'found' ? 'md-button md-button-filled' : 'md-button md-button-outlined';
    }

    // Initial load
    loadMapData();

    // Auto-refresh every 30 seconds
    setInterval(loadMapData, 30000);
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>