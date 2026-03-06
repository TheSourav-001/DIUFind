<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Leaflet Map CSS & JS for Location Picker -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Custom CSS for this page -->
<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-border: 1px solid rgba(255, 255, 255, 0.2);
        --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05);
        --primary-gradient: linear-gradient(135deg, #006D3B 0%, #00A854 100%);
    }

    body {
        background-color: #f0f4f1;
        background-image: radial-gradient(at 0% 0%, hsla(153, 39%, 95%, 1) 0, transparent 50%), radial-gradient(at 50% 0%, hsla(115, 39%, 92%, 1) 0, transparent 50%), radial-gradient(at 100% 0%, hsla(155, 39%, 95%, 1) 0, transparent 50%);
    }

    .form-container {
        max-width: 850px;
        margin: 0 auto;
        padding-bottom: 40px;
    }

    .glass-card {
        background: var(--glass-bg);
        border: var(--glass-border);
        box-shadow: var(--glass-shadow);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-radius: 24px;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }

    .glass-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: var(--primary-gradient);
    }

    .page-header {
        text-align: center;
        margin-bottom: 32px;
        position: relative;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: #1a1c1a;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        color: #555;
        font-size: 15px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--md-sys-color-primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 32px 0 20px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e0e0e0;
    }

    .section-title i {
        background: rgba(0, 109, 59, 0.1);
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: var(--md-sys-color-primary);
    }

    .input-group {
        position: relative;
        margin-bottom: 24px;
        background: white;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .input-group:focus-within {
        border-color: var(--md-sys-color-primary);
        box-shadow: 0 4px 12px rgba(0, 109, 59, 0.08);
        transform: translateY(-2px);
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #717972;
        font-size: 18px;
        pointer-events: none;
        transition: color 0.3s ease;
        z-index: 2;
    }

    .input-group:focus-within .input-icon {
        color: var(--md-sys-color-primary);
    }

    .styled-input {
        width: 100%;
        padding: 16px 16px 16px 50px;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        background: #f9f9f9;
        font-size: 15px;
        color: #191c19;
        transition: all 0.2s ease;
        height: 56px;
        outline: none;
    }

    .styled-input:focus {
        background: white;
        border-color: transparent;
        /* Handled by wrapper */
    }

    .styled-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23717972' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 16px;
    }

    textarea.styled-input {
        padding: 16px;
        min-height: 120px;
        resize: vertical;
    }

    .file-upload-wrapper {
        border: 2px dashed #e0e0e0;
        border-radius: 16px;
        padding: 32px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fcfcfc;
        position: relative;
    }

    .file-upload-wrapper:hover {
        border-color: var(--md-sys-color-primary);
        background: rgba(0, 109, 59, 0.02);
    }

    .upload-icon {
        font-size: 48px;
        color: #bdbdbd;
        margin-bottom: 16px;
        transition: all 0.3s ease;
    }

    .file-upload-wrapper:hover .upload-icon {
        color: var(--md-sys-color-primary);
        transform: scale(1.1);
    }

    .btn-submit {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0 40px;
        height: 50px;
        border-radius: 25px;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(0, 109, 59, 0.3);
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 109, 59, 0.4);
    }

    .btn-cancel {
        color: #717972;
        font-weight: 500;
        padding: 0 24px;
    }

    .btn-cancel:hover {
        color: #191c19;
    }

    /* Animation */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-up {
        animation: slideUp 0.5s ease-out forwards;
    }
</style>

<div class="container form-container animate-up">
    <div style="margin-bottom: 24px;">
        <a href="<?php echo URLROOT; ?>/posts"
            style="display: inline-flex; align-items: center; gap: 8px; color: #555; text-decoration: none; font-weight: 500; transition: color 0.2s;">
            <i class="fa fa-arrow-left" style="font-size: 14px;"></i> Back to Feed
        </a>
    </div>

    <div class="glass-card">
        <div class="page-header">
            <h1 class="page-title">Create New Post</h1>
            <p class="page-subtitle">Report lost/found items or share announcements with the community</p>
        </div>

        <form action="<?php echo URLROOT; ?>/posts/add" method="POST" enctype="multipart/form-data">

            <!-- SECTION 1: POST TYPE -->
            <div class="section-title">
                <i class="fa-solid fa-layer-group"></i> Post Information
            </div>

            <div class="grid grid-cols-2">
                <div class="input-group">
                    <i class="fa-solid fa-tag input-icon"></i>
                    <select name="type" id="typeSelect" class="styled-input styled-select" required>
                        <option value="">Select Type</option>
                        <option value="Lost">Lost Item</option>
                        <option value="Found">Found Item</option>
                        <option value="Event">Event/Notice</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-list input-icon"></i>
                    <select name="category_id" class="styled-input styled-select">
                        <option value="">Select Category</option>
                        <option value="1">Electronics (Laptop, Phone, Charger)</option>
                        <option value="2">ID Cards (Student ID, NID, Passport)</option>
                        <option value="3">Books & Stationery</option>
                        <option value="4">Accessories (Watch, Jewelry, Wallet)</option>
                    </select>
                </div>
            </div>

            <!-- SECTION 2: PERSONAL DETAILS -->
            <div class="section-title">
                <i class="fa-solid fa-user-shield"></i> Your Details
            </div>

            <div class="grid grid-cols-2">
                <div class="input-group">
                    <i class="fa-solid fa-user-tag input-icon"></i>
                    <select name="user_role" class="styled-input styled-select" required>
                        <option value="">Select Role</option>
                        <option value="Student">Student</option>
                        <option value="Faculty">Faculty Member</option>
                        <option value="Staff">Staff/Employee</option>
                        <option value="Visitor">Visitor</option>
                    </select>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-id-card input-icon"></i>
                    <input type="text" name="id_batch" class="styled-input"
                        placeholder="Student ID / Batch (e.g., 221-15-5678)">
                </div>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-building-columns input-icon"></i>
                <select name="department" class="styled-input styled-select" required>
                    <option value="">Select Department/Faculty</option>
                    <optgroup label="Faculty of Science & Information Technology">
                        <option value="CSE">Computer Science & Engineering (CSE)</option>
                        <option value="SWE">Software Engineering (SWE)</option>
                        <option value="CIS">Computer & Information Systems (CIS)</option>
                        <option value="Multimedia">Multimedia & Creative Technology (MCT)</option>
                    </optgroup>
                    <optgroup label="Faculty of Engineering">
                        <option value="EEE">Electrical & Electronic Engineering (EEE)</option>
                        <option value="Civil">Civil Engineering</option>
                        <option value="Textile">Textile Engineering</option>
                        <option value="IPE">Industrial & Production Engineering</option>
                    </optgroup>
                    <optgroup label="Faculty of Business & Entrepreneurship">
                        <option value="BBA">Business Administration (BBA)</option>
                        <option value="MBA">Master of Business Administration (MBA)</option>
                        <option value="Tourism">Tourism & Hospitality Management</option>
                    </optgroup>
                    <optgroup label="Other Faculties">
                        <option value="English">English</option>
                        <option value="Law">Law</option>
                        <option value="Pharmacy">Pharmacy</option>
                        <option value="Public_Health">Public Health</option>
                        <option value="Nutrition">Nutrition & Food Science</option>
                        <option value="GED">General Education Department (GED)</option>
                    </optgroup>
                </select>
            </div>

            <!-- SECTION 3: LOCATION -->
            <div class="section-title">
                <i class="fa-solid fa-location-dot"></i> Location Details
            </div>

            <div class="grid grid-cols-2">
                <div class="input-group">
                    <i class="fa-solid fa-city input-icon"></i>
                    <select name="campus" id="campusSelect" class="styled-input styled-select" required>
                        <option value="">Select Campus</option>
                        <option value="DSC">Daffodil Smart City (Ashulia - Main Campus)</option>
                        <option value="Mirpur">City Campus (Mirpur)</option>
                        <option value="Dhanmondi">Dhanmondi Campus</option>
                        <option value="Uttara">Uttara Campus</option>
                    </select>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-building input-icon"></i>
                    <select name="location_id" id="locationSelect" class="styled-input styled-select">
                        <option value="">Select Building/Location</option>
                    </select>
                </div>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-map-pin input-icon"></i>
                <input type="text" name="specific_location" class="styled-input"
                    placeholder="Specific Location (Room 401, 3rd Floor, Canteen Table 5, etc.)">
            </div>

            <div class="input-group">
                <i class="fa-solid fa-users input-icon"></i>
                <select name="organization" class="styled-input styled-select">
                    <option value="">Related Club/Organization (Optional)</option>
                    <optgroup label="Academic Clubs">
                        <option value="DIU Computer Programming Club">DIU Computer Programming Club (DPC)</option>
                        <option value="DIU Robotics Club">DIU Robotics Club</option>
                        <option value="DIU Business Club">DIU Business Club</option>
                    </optgroup>
                    <optgroup label="Cultural Clubs">
                        <option value="DIU Cultural Club">DIU Cultural Club</option>
                        <option value="DIU Debate Club">DIU Debate Society</option>
                        <option value="DIU Film & Photography">DIU Film & Photography Society</option>
                    </optgroup>
                    <optgroup label="Sports & Adventure">
                        <option value="DIU Sports Club">DIU Sports Club</option>
                        <option value="DIU Adventure Club">DIU Adventure Club</option>
                        <option value="DIU Chess Club">DIU Chess Club</option>
                    </optgroup>
                    <optgroup label="Social & Welfare">
                        <option value="Red Crescent">DIU Red Crescent Society</option>
                        <option value="DIU Blood Donors">DIU Blood Donors Club</option>
                        <option value="DIU Career Club">DIU Career Club</option>
                    </optgroup>
                </select>
            </div>

            <!-- SECTION 4: MAP LOCATION PICKER -->
            <div
                style="background: #e8f5e9; border: 1px solid #c8e6c9; border-radius: 16px; padding: 20px; margin: 24px 0;">
                <h3
                    style="font-size: 16px; font-weight: 700; color: #1b5e20; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-map-location-dot"></i> Mark Exact Location on Map *
                </h3>
                <p style="font-size: 14px; color: #2e7d32; margin-bottom: 16px;">
                    Tap on the map to pin the exact location of the item/event.
                </p>

                <!-- Location Status Indicator -->
                <div id="locationStatus"
                    style="padding: 10px 14px; border-radius: 8px; margin-bottom: 12px; background: white; border: 1px solid #ffcdd2; border-left: 4px solid #ef5350; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-exclamation-circle" style="color: #ef5350; font-size: 18px;"></i>
                    <span style="color: #c62828; font-weight: 500; font-size: 14px;">Location not selected yet</span>
                </div>

                <!-- Interactive Map Container -->
                <div id="locationPickerMap"
                    style="height: 350px; border-radius: 12px; border: 1px solid #bdbdbd; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 16px;">
                </div>

                <!-- Hidden inputs for coordinates -->
                <input type="hidden" name="latitude" id="selectedLatitude" value="">
                <input type="hidden" name="longitude" id="selectedLongitude" value="">

                <!-- Selected Location Display -->
                <div id="selectedLocationInfo"
                    style="display: none; padding: 10px 14px; background: white; border-radius: 8px; border: 1px solid #c8e6c9;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-map-pin" style="color: var(--md-sys-color-primary); font-size: 18px;"></i>
                        <div>
                            <div class="label-medium" style="color: #2e7d32; font-size: 12px; font-weight: 600;">
                                Selected
                                Coordinates:</div>
                            <div id="coordsDisplay" class="body-medium"
                                style="color: #1b5e20; font-family: monospace; font-size: 14px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 5: ITEM DETAILS -->
            <div class="section-title">
                <i class="fa-solid fa-circle-info"></i> Post Details
            </div>

            <div class="input-group">
                <i class="fa-solid fa-heading input-icon"></i>
                <input type="text" name="title"
                    class="styled-input <?php echo (!empty($data['title_err'])) ? 'error' : ''; ?>"
                    placeholder="Title (Short, descriptive) *" value="<?php echo $data['title']; ?>" required>
                <?php if (!empty($data['title_err'])): ?>
                    <span class="md-error-text"
                        style="position: absolute; bottom: -20px; left: 16px;"><?php echo $data['title_err']; ?></span>
                <?php endif; ?>
            </div>

            <div class="input-group">
                <textarea name="body" class="styled-input <?php echo (!empty($data['body_err'])) ? 'error' : ''; ?>"
                    style="padding-left: 16px;"
                    placeholder="Detailed Description (Include: Color, Brand, Model, Size, Time, Distinctive Features...)*"
                    rows="6" required><?php echo $data['body']; ?></textarea>
                <?php if (!empty($data['body_err'])): ?>
                    <span class="md-error-text"><?php echo $data['body_err']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Image Upload -->
            <label style="display: block; margin-bottom: 12px; font-weight: 500; color: #444;">Upload Photo
                (Optional)</label>
            <div class="file-upload-wrapper" onclick="document.getElementById('imageUpload').click()">
                <div class="upload-icon">
                    <i class="fa-regular fa-image"></i>
                </div>
                <h4 style="font-size: 16px; margin-bottom: 8px; color: #333;">Click to upload image</h4>
                <p style="font-size: 13px; color: #888;">Supports: JPG, PNG, GIF (Max 5MB)</p>

                <input type="file" name="image" id="imageUpload" accept="image/*" style="display: none;">

                <!-- Image Preview -->
                <div id="imagePreview" style="margin-top: 16px; display: none;">
                    <img id="previewImg" src=""
                        style="max-width: 100%; height: auto; max-height: 300px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                </div>
            </div>

            <div style="display: flex; gap: 16px; justify-content: flex-end; margin-top: 40px; align-items: center;">
                <a href="<?php echo URLROOT; ?>/posts" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">
                    Submit Post <i class="fa-solid fa-paper-plane" style="margin-left: 8px;"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Dynamic location loading based on campus
    const locationData = {
        'DSC': [
            { id: '1', name: 'AB1 Building (Academic Block 1)' },
            { id: '1', name: 'AB2 Building (Academic Block 2)' },
            { id: '1', name: 'AB3 Building (Academic Block 3)' },
            { id: '1', name: 'AB4 Building (Academic Block 4)' },
            { id: '2', name: 'Knowledge Tower (Main Building)' },
            { id: '6', name: 'Innovation Lab & Maker Space' },
            { id: '3', name: 'Central Library' },
            { id: '4', name: 'Food Court & Cafeteria' },
            { id: '1', name: 'Daffodil Tower' },
            { id: '1', name: 'Younus Khan Hall (Boys Hostel)' },
            { id: '1', name: 'Rowshan Ara Hall (Girls Hostel)' },
            { id: '1', name: 'Sports Complex & Playground' },
            { id: '5', name: 'Bus Station (Campus Shuttle)' },
            { id: '1', name: 'Mosque' },
            { id: '1', name: 'Medical Center' }
        ],
        'Mirpur': [
            { id: '1', name: 'Main Building' },
            { id: '1', name: 'Annex Building' },
            { id: '3', name: 'Library' },
            { id: '4', name: 'Cafeteria' },
            { id: '1', name: 'Computer Lab' }
        ],
        'Dhanmondi': [
            { id: '1', name: 'Main Building' },
            { id: '1', name: 'DT Campus' },
            { id: '3', name: 'Library' }
        ],
        'Uttara': [
            { id: '1', name: 'Main Building' },
            { id: '4', name: 'Cafeteria' }
        ]
    };

    document.getElementById('campusSelect').addEventListener('change', function () {
        const campus = this.value;
        const locationSelect = document.getElementById('locationSelect');

        locationSelect.innerHTML = '<option value="">Select Building/Location</option>';

        if (campus && locationData[campus]) {
            locationData[campus].forEach(function (location) {
                const option = document.createElement('option');
                option.value = location.id;
                option.textContent = location.name;
                locationSelect.appendChild(option);
            });
        }
    });

    // Floating label support
    document.querySelectorAll('.md-input').forEach(input => {
        if (input.value) input.classList.add('filled');
        input.addEventListener('input', function () {
            if (this.value) this.classList.add('filled');
            else this.classList.remove('filled');
        });
    });

    // Image preview
    document.getElementById('imageUpload').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // =====================================================
    // INTERACTIVE MAP LOCATION PICKER
    // =====================================================

    // DIU Campus Center coordinates
    const DIU_CENTER = [23.876292, 90.321189];
    const DEFAULT_ZOOM = 16;

    // Initialize interactive map
    const locationMap = L.map('locationPickerMap', {
        center: DIU_CENTER,
        zoom: DEFAULT_ZOOM,
        maxZoom: 19,
        minZoom: 14
    });

    // Add Google Hybrid (Satellite + Labels) tiles for detail
    L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: '&copy; Google Maps | DIU Find'
    }).addTo(locationMap);

    // Custom marker icon (orange for selection)
    const selectionIcon = L.divIcon({
        className: 'custom-marker',
        html: '<div style="background: linear-gradient(135deg, #FF6F00, #F57C00); width: 36px; height: 36px; border-radius: 50%; border: 4px solid white; box-shadow: 0 4px 12px rgba(255,111,0,0.5); display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-map-pin" style="color: white; font-size: 18px;"></i></div>',
        iconSize: [36, 36],
        iconAnchor: [18, 18]
    });

    // Track if location is selected
    let locationSelected = false;
    let currentMarker = null;

    // Add click handler for location selection
    locationMap.on('click', function (e) {
        const lat = e.latlng.lat.toFixed(6);
        const lng = e.latlng.lng.toFixed(6);

        // Remove previous marker if exists
        if (currentMarker) {
            locationMap.removeLayer(currentMarker);
        }

        // Add new marker
        currentMarker = L.marker(e.latlng, { icon: selectionIcon }).addTo(locationMap);

        // Update hidden inputs
        document.getElementById('selectedLatitude').value = lat;
        document.getElementById('selectedLongitude').value = lng;

        // Update status indicator
        document.getElementById('locationStatus').innerHTML = `
            <i class="fa-solid fa-check-circle" style="color: #4CAF50; font-size: 20px;"></i>
            <span style="color: #2E7D32; font-weight: 500;">✅ Location selected successfully!</span>
        `;
        document.getElementById('locationStatus').style.background = '#E8F5E9';
        document.getElementById('locationStatus').style.borderLeftColor = '#4CAF50';

        // Show coordinates display
        document.getElementById('selectedLocationInfo').style.display = 'block';
        document.getElementById('coordsDisplay').textContent = `Lat: ${lat}, Lng: ${lng}`;

        locationSelected = true;
    });

    // Add DIU campus landmark markers for reference
    const landmarks = [
        { name: 'Knowledge Tower', coords: [23.8765, 90.3210] },
        { name: 'Food Court', coords: [23.877, 90.3225] },
        { name: 'Library', coords: [23.8762, 90.3212] },
        { name: 'Main Gate', coords: [23.8780, 90.3225] }
    ];

    landmarks.forEach(landmark => {
        L.circleMarker(landmark.coords, {
            radius: 6,
            fillColor: '#9E9E9E',
            color: '#616161',
            weight: 2,
            opacity: 0.8,
            fillOpacity: 0.4
        }).addTo(locationMap).bindTooltip(landmark.name, { permanent: false, direction: 'top' });
    });

    // Form validation - prevent submission without location
    document.querySelector('form').addEventListener('submit', function (e) {
        const lat = document.getElementById('selectedLatitude').value;
        const lng = document.getElementById('selectedLongitude').value;

        if (!lat || !lng) {
            e.preventDefault();

            // Show alert
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Location Required!',
                    text: 'Please click on the map to mark the exact location where the item was lost/found.',
                    icon: 'warning',
                    confirmButtonColor: '#FF6F00'
                });
            } else {
                alert('Please click on the map to mark the location!');
            }

            // Scroll to map
            document.getElementById('locationPickerMap').scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Highlight map
            document.getElementById('locationPickerMap').style.border = '3px solid #F44336';
            setTimeout(() => {
                document.getElementById('locationPickerMap').style.border = '2px solid var(--md-sys-color-outline)';
            }, 2000);

            return false;
        }
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>