// public/js/main.js

document.addEventListener('DOMContentLoaded', function () {
    // 1. Preloader Logic
    const preloader = document.getElementById('preloader');
    if (preloader) {
        window.addEventListener('load', function () {
            preloader.style.opacity = '0';
            setTimeout(function () {
                preloader.style.display = 'none';
            }, 500);
        });
        // Fallback incase load event misfires (e.g. cached)
        setTimeout(function () {
            preloader.style.opacity = '0';
            setTimeout(function () {
                preloader.style.display = 'none';
            }, 500);
        }, 1000); // 1 second max load simulation for user experience
    }

    // 2. Dynamic Location Logic (Add Post Page)
    const campusSelect = document.getElementById('campusSelect');
    const buildingSelect = document.getElementById('buildingSelect');

    const campusData = {
        'Daffodil Smart City (Ashulia)': ['AB1', 'AB2', 'AB3', 'AB4', 'Innovation Lab', 'Library', 'Food Court', 'Daffodil Tower', 'Boys Hostel', 'Girls Hostel', 'Playground'],
        'City Campus (Mirpur)': ['Main Building', 'Annex Building', 'Canteen', 'Library'],
        'Dhanmondi': ['Main Building', 'DT', 'Library'],
        'Uttara': ['Main Building']
    };

    if (campusSelect && buildingSelect) {
        campusSelect.addEventListener('change', function () {
            const campus = this.value;
            // Clear existing options
            buildingSelect.innerHTML = '<option value="">Select Building/Location</option>';

            if (campus && campusData[campus]) {
                campusData[campus].forEach(function (building) {
                    const option = document.createElement('option');
                    option.value = building;
                    option.textContent = building;
                    buildingSelect.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.value = "Other";
                option.textContent = "Other";
                buildingSelect.appendChild(option);
            }
        });
    }

    // 3. Others Type Logic
    const typeSelect = document.getElementById('typeSelect');
    const otherInputDiv = document.getElementById('otherInputDiv');

    if (typeSelect && otherInputDiv) {
        typeSelect.addEventListener('change', function () {
            if (this.value === 'Others') {
                otherInputDiv.style.display = 'block';
            } else {
                otherInputDiv.style.display = 'none';
            }
        });
    }
});
