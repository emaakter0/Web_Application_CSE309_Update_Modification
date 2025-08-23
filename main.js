// A simple JavaScript file to handle dynamic content and modal interactions
document.addEventListener('DOMContentLoaded', () => {

    // Placeholder data for products
    const products = [
        { id: 1, name: 'Product 1', description: 'Brief description of the product. This text will tell you about its features and benefits.', price: 199.00, imageUrl: 'https://placehold.co/600x400/FCE4EC/D81B60?text=Product+1' },
        { id: 2, name: 'Product 2', description: 'Brief description of the product. This text will tell you about its features and benefits.', price: 299.00, imageUrl: 'https://placehold.co/600x400/FCE4EC/D81B60?text=Product+2' },
        { id: 3, name: 'Product 3', description: 'Brief description of the product. This text will tell you about its features and benefits.', price: 399.00, imageUrl: 'https://placehold.co/600x400/FCE4EC/D81B60?text=Product+3' },
        { id: 4, name: 'Product 4', description: 'Brief description of the product. This text will tell you about its features and benefits.', price: 499.00, imageUrl: 'https://placehold.co/600x400/FCE4EC/D81B60?text=Product+4' },
    ];

    const productsContainer = document.getElementById('productsContainer');
    const loadingSpinner = document.getElementById('loading');
    const productsSection = document.getElementById('productsSection');

    // Simulate API call to fetch products
    setTimeout(() => {
        loadingSpinner.classList.add('d-none');
        productsSection.classList.remove('d-none');
        renderProducts();
    }, 1500);

    // Function to render products dynamically
    function renderProducts() {
        productsContainer.innerHTML = '';
        products.forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'col';
            productCard.innerHTML = `
                <div class="card product-card h-100 shadow-sm">
                    <img src="${product.imageUrl}" class="card-img-top" alt="${product.name}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">${product.name}</h5>
                        <p class="card-text text-muted">${product.description}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="fs-4 fw-bold text-dark">৳${product.price}</span>
                            <button class="btn btn-primary add-to-cart-btn" data-product-id="${product.id}">Add to Cart</button>
                        </div>
                    </div>
                </div>
            `;
            productsContainer.appendChild(productCard);
        });

        // Add event listeners to the "Add to Cart" buttons
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', (event) => {
                const productId = event.target.dataset.productId;
                addToCart(productId);
            });
        });
    }

    // Cart functionality (simple in-memory cart)
    let cart = [];
    const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    const cartTotal = document.getElementById('cartTotal');
    const cartEmptyMessage = document.getElementById('cartEmptyMessage');
    const viewCartButton = document.getElementById('viewCartButton');

    function addToCart(productId) {
        const product = products.find(p => p.id == productId);
        if (product) {
            cart.push(product);
            updateCartModal();
            showMessage('Product added to cart!', 'success');
        }
    }

    function updateCartModal() {
        cartItemsContainer.innerHTML = '';
        let total = 0;

        if (cart.length === 0) {
            cartEmptyMessage.classList.remove('d-none');
            document.getElementById('checkoutButton').disabled = true;
        } else {
            cartEmptyMessage.classList.add('d-none');
            document.getElementById('checkoutButton').disabled = false;
            cart.forEach(item => {
                const cartItem = document.createElement('div');
                cartItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                cartItem.innerHTML = `
                    <span>${item.name}</span>
                    <span class="fw-bold">৳${item.price}</span>
                `;
                cartItemsContainer.appendChild(cartItem);
                total += item.price;
            });
        }
        cartTotal.textContent = `Total: ৳${total.toFixed(2)}`;
    }

    viewCartButton.addEventListener('click', () => {
        updateCartModal();
        cartModal.show();
    });

    // Generic Message Modal functionality
    const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
    const modalMessage = document.getElementById('modalMessage');

    function showMessage(message) {
        modalMessage.textContent = message;
        messageModal.show();
    }
});
