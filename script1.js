// Function to update the cart count on the page
function updateCartCount() {
    // In a real application, this would also be fetched from the server.
    // For now, we'll keep it simple by getting from localStorage.
    const cartCount = localStorage.getItem('cartCount') || 0;
    const cartIcon = document.querySelector('.cart-icon');
    if (cartIcon) {
        if (cartCount > 0) {
            let countSpan = cartIcon.querySelector('.cart-count');
            if (!countSpan) {
                countSpan = document.createElement('span');
                countSpan.className = 'cart-count';
                cartIcon.appendChild(countSpan);
            }
            countSpan.innerText = cartCount;
        } else {
            const countSpan = cartIcon.querySelector('.cart-count');
            if (countSpan) {
                countSpan.remove();
            }
        }
    }
}

// Function to create a product card element
function createProductCard(product) {
    const productCard = document.createElement('div');
    productCard.className = 'product-card';
    productCard.innerHTML = `
        <div class="product-img-placeholder" style="background-image: url('${product.image_url}');"></div>
        <div class="product-info">
            <h4>${product.name}</h4>
            <p class="price">৳ ${product.price}</p>
            <div class="actions">
                <a href="#" class="btn btn-primary btn-add-to-cart" data-product-id="${product.id}">Add to cart</a>
                <a href="#" class="btn btn-secondary btn-buy-now" data-product-id="${product.id}">Buy now</a>
            </div>
        </div>
    `;

    productCard.addEventListener('click', (event) => {
        if (!event.target.classList.contains('btn-add-to-cart') && !event.target.classList.contains('btn-buy-now')) {
            window.location.href = `product_details.html?product_id=${product.id}`;
        }
    });

    return productCard;
}

// Function to set up event listeners for product buttons
function setupEventListeners() {
    document.querySelectorAll('.btn-add-to-cart').forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const productId = event.target.getAttribute('data-product-id');
            window.location.href = `product_details.html?product_id=${productId}`;
        });
    });

    document.querySelectorAll('.btn-buy-now').forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const productId = event.target.getAttribute('data-product-id');
            window.location.href = `shipping_details.html?product_id=${productId}`;
        });
    });
}

// Main function to load products based on the page
document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    const urlPath = window.location.pathname;
    const productContainer = document.getElementById('product-container');
    const productsHeader = document.getElementById('products-header');

    // Fetch products from the server
    fetch('fetch_products.php')
        .then(response => response.json())
        .then(allProducts => {
            if (productContainer) {
                let productsToDisplay = [];
                
                if (urlPath.includes('pet_categories.php')) {
                    productsToDisplay = allProducts.filter(product => product.category === 'food' || product.category === 'accessories');
                    if (productsHeader) productsHeader.innerText = "Food & Accessories";
                } else if (urlPath.includes('pet_medicines.html')) {
                    productsToDisplay = allProducts.filter(product => product.category === 'medicine');
                    if (productsHeader) productsHeader.innerText = "Pet Medicine";
                } else if (urlPath.includes('index.php')) {
                    productsToDisplay = allProducts;
                }

                productsToDisplay.forEach(product => {
                    productContainer.appendChild(createProductCard(product));
                });
                
                setupEventListeners();
            }

            // product_details.html page logic
            if (urlPath.includes('product_details.html')) {
                const urlParams = new URLSearchParams(window.location.search);
                const productId = urlParams.get('product_id');
                const product = allProducts.find(p => p.id == productId);

                if (product) {
                    document.getElementById('product-image').style.backgroundImage = `url('${product.image_url}')`;
                    document.getElementById('product-name').innerText = product.name;
                    document.getElementById('product-price').innerText = `৳ ${product.price}`;
                    document.getElementById('product-description').innerText = product.description;

                    document.getElementById('add-to-cart-btn').addEventListener('click', (event) => {
                        event.preventDefault();
                        let cartCount = parseInt(localStorage.getItem('cartCount')) || 0;
                        cartCount += 1;
                        localStorage.setItem('cartCount', cartCount);
                        updateCartCount();

                        const successMessage = document.getElementById('success-message');
                        if (successMessage) {
                            successMessage.style.display = 'block';
                            setTimeout(() => {
                                successMessage.style.display = 'none';
                            }, 3000);
                        }
                    });
                    
                    document.getElementById('buy-now-btn').addEventListener('click', (event) => {
                        event.preventDefault();
                        window.location.href = `shipping_details.html?product_id=${productId}`;
                    });
                }
            }
        });

    // Shipping page logic
    if (urlPath.includes('shipping_details.html')) {
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('product_id');
        
        // This is a placeholder for now, we will update it later.
        const orderSummaryContainer = document.getElementById('order-summary-container');
        if (orderSummaryContainer) {
            orderSummaryContainer.innerHTML = `<p>Order for product ID: ${productId}</p>`;
        }

        document.getElementById('payment-btn').addEventListener('click', (event) => {
            event.preventDefault();
            window.location.href = 'payment.html';
        });
    }

    // Payment page logic
    if (urlPath.includes('payment.html')) {
        document.getElementById('confirm-order-btn').addEventListener('click', (event) => {
            event.preventDefault();
            alert('আপনার প্রোডাক্ট অর্ডার সফল হয়েছে!');
            localStorage.setItem('cartCount', 0);
            updateCartCount();
            window.location.href = 'index.php';
        });
    }
});