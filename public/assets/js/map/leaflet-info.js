var currentPage = 1;
var lastPage = 1;
var map;
var markers = {}; // Object to store markers with their IDs

function fetchPropertiesAndUpdateMap(map, page = 1) {
    var bounds = map.getBounds();
    var boundsData = {
        northEast: bounds.getNorthEast(),
        southWest: bounds.getSouthWest()
    };

    // Show the spinners
    document.getElementById('mapSpinner').classList.add('loading');
    document.getElementById('propertySpinner').classList.add('loading');

    fetch('/api/properties/search', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
            // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ bounds: boundsData, search: '', page: page }) // Add search criteria if any
    })
        .then(response => response.json())
        .then(data => {
            clearMap(map);
            updateMapWithProperties(map, data.all_properties);
            updatePropertyCards(data.paginated_properties);
            updatePagination(data.current_page, data.last_page);
        })
        .catch(error => console.error('Error fetching properties:', error))
        .finally(() => {
            // Hide the spinners
            document.getElementById('mapSpinner').classList.remove('loading');
            document.getElementById('propertySpinner').classList.remove('loading');
        });
}

function clearMap(map) {
    map.eachLayer(function (layer) {
        if (layer instanceof L.Marker) {
            map.removeLayer(layer);
        }
    });
    markers = {}; // Clear the markers object
}

function updateMapWithProperties(map, properties) {
    properties.forEach(function (item) {
        var markerId = `marker-${item.id}`;
        var locationIcon = L.divIcon({
            className: 'user-icon',
            html: `<span id="${markerId}" class="label label-shadow price-label">${item.price_per_night} RON</span>`,
            iconSize: [30, 30], // Adjust icon size if needed
            iconAnchor: [15, 30] // Adjust icon anchor if needed
        });

        var marker = L.marker([item.latitude, item.longitude], { icon: locationIcon, title: item.title })
            .bindPopup(
                '<div class="infoBox">' +
                '<div class="marker-detail">' +
                '<img src="' + item.map_image_url + '" alt="Image"/>' +
                '<div class="label label-shadow">' + item.label + '</div>' +
                '<div class="detail-part">' +
                '<h6>' + item.name + '</h6>' +
                '<ul>' +
                // '<li>Bed : ' + item.bed + '</li>' +
                // '<li>Baths :' + item.bath + '</li>' +
                // '<li>Sq Ft :' + item.sqft + '</li>' +
                '</ul>' +
                '<span>' + item.price_per_night + ' RON</span>' +
                '<a href="' + item.url + '" target="_blank">Details</a>' +
                '</div>' +
                '</div>' +
                '</div>'
            ).addTo(map);

        markers[item.id] = marker; // Store marker by property ID
    });
}

function updatePropertyCards(properties) {
    var propertyGrid = document.querySelector('.property-grid');
    propertyGrid.innerHTML = ''; // Clear existing properties

    properties.forEach(function (item) {
        var propertyId = `property-${item.id}`;
        // Create slider images dynamically
        var sliderImagesHtml = item.slider_images_urls.map(url => `
            <a href="javascript:void(0)">
                <img src="${url}" class="bg-img" alt="">
            </a>`).join('');
        var propertyCard = `
            <div id="${propertyId}" class="col-md-4 wow fadeInUp">
                <div class="property-box">
                    <div class="property-image">
                        <div class="property-slider">
                        ${sliderImagesHtml}
                        </div>
                        <div class="labels-left">
                            <div>
                                <span class="label label-shadow">${item.label}</span>
                            </div>
                        </div>
                        <div class="seen-data">
                            <i data-feather="camera"></i>
                            <span>25</span>
                        </div>
                        <div class="overlay-property-box">
                            <a href="user-favourites.html" class="effect-round like" data-bs-toggle="tooltip" data-bs-placement="left" title="wishlist">
                                <i data-feather="heart"></i>
                            </a>
                        </div>
                    </div>
                    <div class="property-details">
                        <span class="font-roboto">${item.country}</span>
                        <a href="single-property-8.html">
                            <h3>${item.name}</h3>
                        </a>
                        <h6>${item.price_per_night} RON</h6>
                        <p class="font-roboto">${item.description}</p>
                        <div class="property-btn d-flex">
                            <span>${item.date}</span>
                            <a href="${item.url}" class="btn btn-dashed btn-pill color-2" target="_blank">Details</a>
                        </div>
                    </div>
                </div>
            </div>`;
        propertyGrid.insertAdjacentHTML('beforeend', propertyCard);

        // Add mouseover and mouseout event listeners
        var propertyElement = document.getElementById(propertyId);
        propertyElement.addEventListener('mouseover', function () {
            var markerElement = document.getElementById(`marker-${item.id}`);
            if (markerElement) {
                markerElement.style.backgroundColor = 'green';
                markerElement.style.fontSize = '16px';
            }
        });
        propertyElement.addEventListener('mouseout', function () {
            var markerElement = document.getElementById(`marker-${item.id}`);
            if (markerElement) {
                markerElement.style.backgroundColor = ''; // Reset to original color
                markerElement.style.fontSize = ''; // Reset to original font size
            }
        });
    });

    // Initialize Feather icons
    feather.replace();

    $('.property-slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        arrows: true,
        slidesToShow: 1,
        slidesToScroll: 1,
    });
}

function updatePagination(currentPage, lastPage) {
    var paginationContainer = document.querySelector('.theme-pagination');
    paginationContainer.innerHTML = ''; // Clear existing pagination

    var paginationList = document.createElement('ul');
    paginationList.classList.add('pagination', 'justify-content-center');

    var prevItem = document.createElement('li');
    prevItem.classList.add('page-item');
    if (currentPage === 1) {
        prevItem.classList.add('disabled');
    }
    var prevLink = document.createElement('a');
    prevLink.classList.add('page-link');
    prevLink.href = "javascript:void(0)";
    prevLink.innerText = "Previous";
    prevLink.addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage--;
            fetchPropertiesAndUpdateMap(map, currentPage);
        }
    });
    prevItem.appendChild(prevLink);
    paginationList.appendChild(prevItem);

    for (let page = 1; page <= lastPage; page++) {
        var pageItem = document.createElement('li');
        pageItem.classList.add('page-item');
        if (page === currentPage) {
            pageItem.classList.add('active');
        }

        var pageLink = document.createElement('a');
        pageLink.classList.add('page-link');
        pageLink.href = "javascript:void(0)";
        pageLink.innerText = page;

        pageLink.addEventListener('click', function () {
            currentPage = page;
            fetchPropertiesAndUpdateMap(map, page);
        });

        pageItem.appendChild(pageLink);
        paginationList.appendChild(pageItem);
    }

    var nextItem = document.createElement('li');
    nextItem.classList.add('page-item');
    if (currentPage === lastPage) {
        nextItem.classList.add('disabled');
    }
    var nextLink = document.createElement('a');
    nextLink.classList.add('page-link');
    nextLink.href = "javascript:void(0)";
    nextLink.innerText = "Next";
    nextLink.addEventListener('click', function () {
        if (currentPage < lastPage) {
            currentPage++;
            fetchPropertiesAndUpdateMap(map, currentPage);
        }
    });
    nextItem.appendChild(nextLink);
    paginationList.appendChild(nextItem);

    paginationContainer.appendChild(paginationList);
}

// Attach event listener to DOMContentLoaded
document.addEventListener('DOMContentLoaded', function () {
    // Initialize the map in the global scope
    map = L.map('mapleaf').setView([44.4351081, 26.0537071], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Fetch properties and update the map when the map is moved or zoomed
    map.on('zoomend', () => fetchPropertiesAndUpdateMap(map, currentPage));
    map.on('moveend', () => fetchPropertiesAndUpdateMap(map, currentPage));

    // Initial fetch to load properties when the map first loads
    fetchPropertiesAndUpdateMap(map, currentPage);
});
