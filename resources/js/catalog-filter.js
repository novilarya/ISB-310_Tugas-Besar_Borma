document.addEventListener('DOMContentLoaded', function () {
    // === Unified Filter & Sort Logic ===
    const searchInput = document.getElementById('sidebar-search');
    const priceMinInput = document.getElementById('price-min-input');
    const priceMaxInput = document.getElementById('price-max-input');
    const sortSelect = document.getElementById('sidebar-sort');
    const grid = document.getElementById('product-grid');
    const noResults = document.getElementById('no-results');

    if (grid) {
        const originalCards = Array.from(grid.querySelectorAll('.product-card'));

        // Add original index so we can revert back to 'TERBARU' / default order
        originalCards.forEach((card, index) => {
            card.setAttribute('data-original-index', index);
        });

        function applyFiltersAndSort() {
            const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const minPrice = priceMinInput ? (parseFloat(priceMinInput.value) || 0) : 0;
            const maxPrice = priceMaxInput ? (parseFloat(priceMaxInput.value) || Infinity) : Infinity;
            const sortVal = sortSelect ? sortSelect.value : 'terbaru';

            let visibleCount = 0;

            // 1. Filter cards
            originalCards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const price = parseFloat(card.getAttribute('data-price')) || 0;

                const matchSearch = !query || name.includes(query);
                const matchPrice = price >= minPrice && price <= maxPrice;

                const match = matchSearch && matchPrice;
                card.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            // 2. Sort cards
            const sortedCards = [...originalCards].sort((a, b) => {
                if (sortVal === 'harga-tertinggi') {
                    const priceA = parseFloat(a.getAttribute('data-price')) || 0;
                    const priceB = parseFloat(b.getAttribute('data-price')) || 0;
                    return priceB - priceA;
                } else if (sortVal === 'harga-terendah') {
                    const priceA = parseFloat(a.getAttribute('data-price')) || 0;
                    const priceB = parseFloat(b.getAttribute('data-price')) || 0;
                    return priceA - priceB;
                } else {
                    // 'terbaru' (default)
                    const indexA = parseInt(a.getAttribute('data-original-index')) || 0;
                    const indexB = parseInt(b.getAttribute('data-original-index')) || 0;
                    return indexA - indexB;
                }
            });

            // 3. Re-append in sorted order
            sortedCards.forEach(card => {
                grid.appendChild(card);
            });

            // 4. Handle no results
            if (noResults) {
                if (visibleCount === 0) {
                    noResults.classList.remove('hidden');
                    grid.appendChild(noResults); // make sure it's at the end
                } else {
                    noResults.classList.add('hidden');
                }
            }
        }

        // Attach event listeners
        if (searchInput) {
            searchInput.addEventListener('input', applyFiltersAndSort);
        }

        if (priceMinInput) {
            priceMinInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    applyFiltersAndSort();
                }
            });
            priceMinInput.addEventListener('change', applyFiltersAndSort);
        }

        if (priceMaxInput) {
            priceMaxInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    applyFiltersAndSort();
                }
            });
            priceMaxInput.addEventListener('change', applyFiltersAndSort);
        }

        if (sortSelect) {
            sortSelect.addEventListener('change', applyFiltersAndSort);
        }

        // Initial run
        applyFiltersAndSort();
    }
});
