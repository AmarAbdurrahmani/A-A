document.addEventListener("DOMContentLoaded", function () {
    const newsletterForm = document.querySelector(".newsletter-form");
    const popup = document.getElementById("subscribe-popup");

    newsletterForm.addEventListener("submit", function (e) {
        e.preventDefault();

        popup.style.display = "block"; // show under button

        // Hide after 2 seconds
        setTimeout(() => {
            popup.style.display = "none";
        }, 2000);

        newsletterForm.reset();
    });
});



const categorySelect = document.getElementById('category-select');
const priceSelect = document.getElementById('price-select');
const productsGrid = document.querySelector('.products-grid');

// Collect all product wrappers (either <a> or <div>)
const products = Array.from(productsGrid.children);

function filterAndSortProducts() {
    const selectedCategory = categorySelect.value;
    const selectedPrice = priceSelect.value;

    let filteredProducts = products.filter(wrapper => {
        // Each wrapper may be <a> or <div>
        const productEl = wrapper.classList.contains('product') ? wrapper : wrapper.querySelector('.product');

        if (!productEl) return false;

        // Filter by category
        if (!selectedCategory) return true;
        return productEl.dataset.category === selectedCategory;
    });

    // Sort by price
    if (selectedPrice === 'low') {
        filteredProducts.sort((a, b) => {
            const priceA = Number((a.querySelector('.product') || a).dataset.price);
            const priceB = Number((b.querySelector('.product') || b).dataset.price);
            return priceA - priceB;
        });
    } else if (selectedPrice === 'high') {
        filteredProducts.sort((a, b) => {
            const priceA = Number((a.querySelector('.product') || a).dataset.price);
            const priceB = Number((b.querySelector('.product') || b).dataset.price);
            return priceB - priceA;
        });
    }

    // Re-render products
    productsGrid.innerHTML = '';
    filteredProducts.forEach(p => productsGrid.appendChild(p));
}

// Event listeners
categorySelect.addEventListener('change', filterAndSortProducts);
priceSelect.addEventListener('change', filterAndSortProducts);


document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const selectedCategory = urlParams.get('category');

    if (selectedCategory) {
        const products = document.querySelectorAll('.product');
        products.forEach(product => {
            const parent = product.closest('.product-link') || product;
            if (product.dataset.category !== selectedCategory) {
                parent.style.display = 'none';
            } else {
                parent.style.display = 'block';
            }
        });
    }
});


document.getElementById("newsletter-form").addEventListener("submit", function(e) {
    e.preventDefault(); // Prevent page reload

    const formData = new FormData(this);

    fetch("newsletter.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const popup = document.getElementById("subscribe-popup");
        if (data.status === "success") {
            popup.textContent = data.message;
            popup.style.display = "block";
            setTimeout(() => { popup.style.display = "none"; }, 3000);
            this.reset(); // clear input
        } else {
            popup.textContent = data.message;
            popup.style.display = "block";
            setTimeout(() => { popup.style.display = "none"; }, 3000);
        }
    })
    .catch(err => console.error(err));
});





