document.addEventListener('DOMContentLoaded', function() {
    // 1. Fetch Cart Count
    fetch('/cart/count')
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('cart-badge');
            if (badge) {
                badge.style.display = data.cart_count > 0 ? 'block' : 'none';
            }
        })
        .catch(() => {});

    // 2. Initialize location detection if no branch is selected
    const isCustomerRoute = window.location.pathname.includes('/pelanggan') || 
                            window.location.pathname === '/';
    if (!selectedCabangId && isCustomerRoute) {
        detectUserLocation();
    }
});

let selectedCabangId = document.querySelector('meta[name="selected-cabang-id"]')?.getAttribute('content') || '';
let globalSelectorMap = null;
let globalBranchMarkers = [];
let detectedLat = null;
let detectedLng = null;
let detectedAccuracy = null;
let userMarker = null;
let userCircle = null;

function detectUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            pos => {
                detectedLat = pos.coords.latitude;
                detectedLng = pos.coords.longitude;
                detectedAccuracy = pos.coords.accuracy;
                processLocationRecommendation(detectedLat, detectedLng);
            },
            () => {
                // If location is blocked, directly show the map modal so they choose manually
                openBranchSelectorModal();
            },
            { enableHighAccuracy: true, timeout: 8000 }
        );
    } else {
        openBranchSelectorModal();
    }
}

async function processLocationRecommendation(lat, lng) {
    try {
        const res = await fetch('/api/cabangs');
        const branches = await res.json();
        
        branches.forEach(b => {
            b.distance = getHaversineDistance(lat, lng, parseFloat(b.lat), parseFloat(b.lng));
        });
        branches.sort((a, b) => a.distance - b.distance);

        const nearest = branches[0];
        if (nearest) {
            document.getElementById('recommend-branch-name').textContent = nearest.nama;
            document.getElementById('recommend-branch-distance').textContent = formatDistanceText(nearest.distance);
            
            // Hook up confirm button
            document.getElementById('btn-confirm-recommend').onclick = function() {
                saveSelectedCabang(nearest.id, nearest.distance);
            };
            
            // Show recommendation modal
            const recModal = document.getElementById('branchRecommendModal');
            recModal.classList.remove('hidden');
            setTimeout(() => {
                recModal.querySelector('.bg-white').classList.add('scale-100', 'opacity-100');
            }, 50);
        }
    } catch (err) {
        console.error('Error in location recommendation:', err);
    }
}

// Make globally accessible since referenced in inline onclick attributes in Blade templates
window.rejectRecommendBranch = function() {
    const recModal = document.getElementById('branchRecommendModal');
    recModal.classList.add('hidden');
    openBranchSelectorModal();
};

window.openBranchSelectorModal = function() {
    // Hide recommendation if open
    document.getElementById('branchRecommendModal').classList.add('hidden');
    
    const mapModal = document.getElementById('branchMapModal');
    mapModal.classList.remove('hidden');
    setTimeout(() => {
        mapModal.querySelector('.bg-white').classList.add('scale-100', 'opacity-100');
    }, 50);
    
    // Initialize map inside modal
    setTimeout(() => {
        initModalSelectorMap();
    }, 100);

    // Call Leaflet invalidateSize when transition completes
    setTimeout(() => {
        if (globalSelectorMap) {
            globalSelectorMap.invalidateSize();
        }
    }, 350);
};

window.closeBranchSelectorModal = function() {
    const mapModal = document.getElementById('branchMapModal');
    mapModal.classList.add('hidden');
    if (globalSelectorMap) {
        globalSelectorMap.remove();
        globalSelectorMap = null;
        globalBranchMarkers = [];
        userMarker = null;
        userCircle = null;
    }
};

async function initModalSelectorMap() {
    if (globalSelectorMap) return;
    
    const defaultLat = -6.917464;
    const defaultLng = 107.619123;
    const centerLat = detectedLat || defaultLat;
    const centerLng = detectedLng || defaultLng;

    globalSelectorMap = L.map('modal-selector-map', {
        zoomControl: true,
        attributionControl: false
    }).setView([centerLat, centerLng], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(globalSelectorMap);

    const bormaIcon = L.divIcon({
        className: 'borma-marker',
        html: '<div class="bg-primary-700 w-8 h-8 rounded-full flex items-center justify-center border-[3px] border-secondary-400 shadow-[0_2px_8px_rgba(51,17,108,0.4)]"><span class="text-secondary-400 font-extrabold text-[12px]">B</span></div>',
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });

    try {
        const res = await fetch('/api/cabangs');
        const branches = await res.json();

        // Add markers
        branches.forEach(b => {
            const marker = L.marker([parseFloat(b.lat), parseFloat(b.lng)], { icon: bormaIcon })
                .addTo(globalSelectorMap)
                .bindPopup(`
                    <div class="font-sans min-w-[160px] text-center">
                        <p class="font-extrabold text-[13px] m-0 mb-1 text-primary-700">${b.nama}</p>
                        <p class="text-[11px] text-neutral-500 m-0 mb-2">${b.alamat}</p>
                        <button onclick="saveSelectedCabang(${b.id})" class="bg-primary-700 text-white font-bold text-[11px] py-1.5 px-3 rounded-lg cursor-pointer w-full border-none">Belanja di Sini</button>
                    </div>
                `);
            globalBranchMarkers[b.id] = marker;
        });

        if (detectedLat && detectedLng) {
            await updateModalSelectorMapWithUserLocation(detectedLat, detectedLng, detectedAccuracy);
        } else {
            // Calculate default distances
            branches.forEach(b => {
                b.distance = getHaversineDistance(defaultLat, defaultLng, parseFloat(b.lat), parseFloat(b.lng));
            });
            branches.sort((a, b) => a.distance - b.distance);
            renderSidebarList(branches);

            const bounds = L.latLngBounds();
            branches.slice(0, 3).forEach(b => bounds.extend([parseFloat(b.lat), parseFloat(b.lng)]));
            globalSelectorMap.fitBounds(bounds.pad(0.3));
        }

        setTimeout(() => {
            globalSelectorMap.invalidateSize();
        }, 300);

    } catch (err) {
        console.error('Error initializing map selector branches:', err);
    }
}

async function updateModalSelectorMapWithUserLocation(lat, lng, accuracy) {
    if (!globalSelectorMap) return;

    // Custom user pulse icon using Tailwind
    const userIcon = L.divIcon({
        className: 'user-marker',
        html: `<div class="relative w-11 h-11">
            <div class="absolute top-3 left-3 bg-tertiary-400 w-5 h-5 rounded-full border-3 border-white shadow-[0_2px_10px_rgba(235,59,2,0.6)] z-20"></div>
            <div class="absolute top-0.5 left-0.5 w-10 h-10 rounded-full border-2 border-tertiary-400/30 animate-[userPulse_2s_ease-out_infinite] z-10"></div>
            <div class="absolute top-[7px] left-[7px] w-[30px] h-[30px] rounded-full bg-tertiary-400/12 animate-[userPulse_2s_ease-out_infinite_0.5s] z-0"></div>
        </div>`,
        iconSize: [44, 44],
        iconAnchor: [22, 22]
    });

    if (userMarker) globalSelectorMap.removeLayer(userMarker);
    if (userCircle) globalSelectorMap.removeLayer(userCircle);

    userMarker = L.marker([lat, lng], { icon: userIcon, zIndexOffset: 1000 }).addTo(globalSelectorMap);
    userCircle = L.circle([lat, lng], {
        radius: accuracy || 100,
        color: '#EB3B02',
        fillColor: '#EB3B02',
        fillOpacity: 0.08,
        weight: 1.5,
        opacity: 0.3
    }).addTo(globalSelectorMap);

    try {
        const res = await fetch('/api/cabangs');
        const branches = await res.json();

        // Calculate distance
        branches.forEach(b => {
            b.distance = getHaversineDistance(lat, lng, parseFloat(b.lat), parseFloat(b.lng));
        });
        branches.sort((a, b) => a.distance - b.distance);

        // Update branch popups with distance info
        branches.forEach(b => {
            const marker = globalBranchMarkers[b.id];
            if (marker) {
                marker.bindPopup(`
                    <div class="font-sans min-w-[160px] text-center">
                        <p class="font-extrabold text-[13px] m-0 mb-1 text-primary-700">${b.nama}</p>
                        <p class="text-[11px] text-neutral-500 m-0 mb-1">${b.alamat}</p>
                        <p class="text-[11px] font-bold text-primary-500 m-0 mb-2">Jarak: ${formatDistanceText(b.distance)}</p>
                        <button onclick="saveSelectedCabang(${b.id}, ${b.distance})" class="bg-primary-700 text-white font-bold text-[11px] py-1.5 px-3 rounded-lg cursor-pointer w-full border-none">Belanja di Sini</button>
                    </div>
                `);
            }
        });

        renderSidebarList(branches);

        // Fit map bounds to show user and closest branches
        const bounds = L.latLngBounds([[lat, lng]]);
        branches.slice(0, 3).forEach(b => bounds.extend([parseFloat(b.lat), parseFloat(b.lng)]));
        globalSelectorMap.fitBounds(bounds.pad(0.3));
        globalSelectorMap.invalidateSize();

    } catch (err) {
        console.error('Error updating map user location:', err);
    }
}

function renderSidebarList(branches) {
    const listEl = document.getElementById('modal-branches-list');
    listEl.innerHTML = '';

    branches.forEach((b, i) => {
        const isSelected = (selectedCabangId == b.id);
        const card = document.createElement('div');
        
        card.className = `flex items-center justify-between p-4 bg-white rounded-2xl border transition-all duration-300 cursor-pointer gap-4 group relative ${
            isSelected 
                ? 'border-primary-500 bg-primary-50/20 shadow-md shadow-primary-700/5 ring-1 ring-primary-500 hover:bg-primary-50/35 hover:shadow-lg' 
                : 'border-neutral-200 hover:border-primary-300 hover:shadow-md hover:bg-neutral-50/30'
        }`;
        
        card.innerHTML = `
            <div class="flex items-center gap-5 min-w-0 flex-1">
                <!-- Styled pin icon -->
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300 ${
                    isSelected 
                        ? 'bg-primary-700 text-white shadow-md shadow-primary-700/20 group-hover:bg-primary-800' 
                        : 'bg-neutral-50 border border-neutral-100 text-neutral-500 group-hover:bg-primary-50 group-hover:border-primary-100 group-hover:text-primary-700'
                }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h5 class="font-heading font-extrabold text-[14px] text-neutral-800 group-hover:text-primary-700 transition-colors leading-tight">${b.nama}</h5>
                        <span class="inline-flex items-center text-[10px] font-extrabold text-amber-700 bg-amber-50 border border-amber-200/50 px-2 py-0.5 rounded-full shrink-0">
                            ${b.distance !== undefined ? formatDistanceText(b.distance) : '-'}
                        </span>
                    </div>
                    <p class="text-[11px] text-neutral-400 mt-1 truncate leading-tight">${b.alamat}</p>
                </div>
            </div>
            <div class="shrink-0">
                <button onclick="saveSelectedCabang(${b.id}, ${b.distance})" 
                        class="py-1.5 px-3.5 text-[11px] leading-none inline-flex items-center justify-center gap-1 font-extrabold rounded-full transition-all duration-300 cursor-pointer select-none ${
                            isSelected 
                                ? 'bg-primary-700 text-white border border-transparent shadow-sm group-hover:bg-primary-800' 
                                : 'bg-white text-primary-700 border border-primary-200 group-hover:bg-primary-700 group-hover:text-white group-hover:border-primary-700'
                        }">
                    <span>Pilih</span>
                    <svg style="width: 12px; height: 12px;" class="transform group-hover:translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        `;
        
        // Clicking card zooms map to marker
        card.addEventListener('click', (e) => {
            if (e.target.tagName !== 'BUTTON' && !e.target.closest('button')) {
                globalSelectorMap.setView([parseFloat(b.lat), parseFloat(b.lng)], 15);
                globalBranchMarkers[b.id]?.openPopup();
            }
        });
        
        listEl.appendChild(card);
    });
}

window.detectLocationInModal = function() {
    const btn = document.getElementById('modal-detect-location-btn');
    const originalContent = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = `<div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div><span>Mendeteksi...</span>`;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            async pos => {
                detectedLat = pos.coords.latitude;
                detectedLng = pos.coords.longitude;
                detectedAccuracy = pos.coords.accuracy;

                if (globalSelectorMap) {
                    await updateModalSelectorMapWithUserLocation(detectedLat, detectedLng, detectedAccuracy);
                }
                
                btn.disabled = false;
                btn.innerHTML = originalContent;
            },
            () => {
                alert('Akses lokasi ditolak atau tidak didukung oleh browser Anda.');
                btn.disabled = false;
                btn.innerHTML = originalContent;
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    } else {
        alert('Browser Anda tidak mendukung geolokasi.');
        btn.disabled = false;
        btn.innerHTML = originalContent;
    }
};

window.saveSelectedCabang = function(cabangId, distance = null) {
    if (selectedCabangId && selectedCabangId != cabangId) {
        if (!confirm("Apakah Anda yakin ingin mengganti cabang belanja?")) {
            return;
        }
    }
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    let finalDistance = distance;
    if (finalDistance === null) {
        const marker = globalBranchMarkers[cabangId];
        if (marker) {
            const pos = marker.getLatLng();
            const lat = detectedLat || -6.917464;
            const lng = detectedLng || 107.619123;
            finalDistance = getHaversineDistance(lat, lng, pos.lat, pos.lng);
        }
    }
    
    fetch('/api/select-cabang', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ 
            id_cabang: cabangId,
            distance: finalDistance
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert('Gagal memilih cabang.');
        }
    })
    .catch(() => {
        alert('Terjadi kesalahan jaringan.');
    });
};

function getHaversineDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon/2) * Math.sin(dLon/2);
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

function formatDistanceText(km) {
    if (km < 1) return (km * 1000).toFixed(0) + ' m';
    return km.toFixed(1) + ' km';
}
