document.addEventListener('DOMContentLoaded', () => {
    const petData = [
        {
            name: "Cat Food",
            icon: "fa-solid fa-bowl-food",
            subcategories: [
                { name: "Adult Food", products: ["Monello Cat Adult Food", "Purina Pro Plan Adult", "Whiskas Chicken", "Iams Proactive Health", "Orijen Cat & Kitten"] },
                { name: "Cat Can Food", products: ["Royal Canin Pouch", "Me-O Delite", "Sheba Tuna", "Fussie Cat Premium", "Taste of the Wild"] },
                { name: "Kitten Food", products: ["Royal Canin Kitten", "Monello Cat Kitten", "Whiskas Kitten", "Iams Proactive Kitten", "Purina Friskies"] },
                { name: "Cat Dry Food", products: ["Monello Cat Salmon", "Whiskas Ocean Fish", "Me-O Seafood", "Purina Cat Chow", "Blackwood Chicken"] },
                { name: "Cat Wet Food", products: ["Me-O Tuna in Jelly", "Royal Canin Intense Beauty", "Whiskas Salmon Pouch", "Monello Wet Food", "Purina Fancy Feast"] },
                { name: "Cat Pouches", products: ["Whiskas Chicken in Gravy", "Sheba Tuna in Gravy", "Monello Cat Pouch", "Me-O Delite Tuna", "Fancy Feast Pouch"] },
                { name: "Cat Treats", products: ["Whiskas Temptations", "Me-O Creamy Treat", "Purina DentaLife", "Tempting Treats", "Wellness Kittles"] },
                { name: "Repack Food", products: ["Monello Repack", "Whiskas Repack", "Me-O Repack", "Royal Canin Repack", "Iams Repack"] },
            ]
        },
        {
            name: "Cat Toys",
            icon: "fa-solid fa-gamepad",
            subcategories: [{ name: "Cat Toys", products: ["Laser Pointer Toy", "Feather Wand", "Catnip Mouse", "Interactive Ball", "Tunnel Toy"] }]
        },
        {
            name: "Cat Litter",
            icon: "fa-solid fa-toilet",
            subcategories: [
                { name: "Clumping Cat Litter", products: ["Fresh Step", "Ever Clean", "Tidy Cats", "Dr. Elsey's", "World's Best Cat Litter"] },
                { name: "Cat Litter Accessories", products: ["Litter Mat", "Litter Scoop", "Litter Box Deodorizer", "Disposable Liners", "Storage Bin"] },
                { name: "Cat Litter Box", products: ["Enclosed Litter Box", "Open Litter Box", "Self-Cleaning Box", "Corner Litter Box", "Top-Entry Litter Box"] },
            ]
        },
        {
            name: "Cat Care and Health",
            icon: "fa-solid fa-house-medical",
            subcategories: [
                { name: "Cat Grooming", products: ["Grooming Brush", "Nail Clipper", "Shedding Comb", "Grooming Wipes", "Deshedding Tool"] },
                { name: "Cat Nip", products: ["Catnip Spray", "Dried Catnip Leaves", "Catnip Ball Toy", "Catnip Bubbles", "Organic Catnip"] },
                { name: "Cat Cleanup", products: ["Pet Stain Remover", "Odor Eliminator", "Lint Roller", "Disinfectant Spray", "Cleaning Wipes"] },
                { name: "Shampoo", products: ["Flea & Tick Shampoo", "Dry Shampoo", "Hypoallergenic Shampoo", "Oatmeal Shampoo", "Kitten Shampoo"] },
                { name: "Cat Feeding Tools", products: ["Automatic Feeder", "Food Bowl", "Water Fountain", "Slow Feeder", "Raised Bowl"] },
                { name: "Cat Bathing", products: ["Cat Shampoo", "Cat Conditioner", "Microfiber Towel", "Bathing Gloves", "Waterless Shampoo"] },
                { name: "Toothbrush", products: ["Finger Toothbrush", "Dual-Headed Toothbrush", "Dental Wipes", "Toothpaste for Cats", "Plaque Remover"] },
            ]
        },
        {
            name: "Clothing, Beds & Carrier",
            icon: "fa-solid fa-bed",
            subcategories: [
                { name: "Cat Bag", products: ["Mesh Carrier Bag", "Soft-Sided Carrier", "Hard-Sided Carrier", "Backpack Carrier", "Wheeled Carrier"] },
                { name: "Cat T-shirt and Dress", products: ["Cat Hoodie", "Winter Sweater", "T-Shirt for Cats", "Dress for Cats", "Costume"] },
                { name: "House, Bed and Carrier Bag", products: ["Cat Cave Bed", "Heated Cat Bed", "Cat House", "Pet Carrier", "Crate"] },
            ]
        },
        {
            name: "Cat Accessories",
            icon: "fa-solid fa-tag",
            subcategories: [
                { name: "Collar", products: ["Leather Collar", "Breakaway Collar", "Reflective Collar", "GPS Collar", "Bell Collar"] },
                { name: "Food Bowl", products: ["Ceramic Bowl", "Stainless Steel Bowl", "Plastic Bowl", "Raised Food Bowl", "Automatic Feeder"] },
                { name: "Harness", products: ["Vest Harness", "H-Harness", "Step-in Harness", "Escape Proof Harness", "Leash and Harness Set"] },
                { name: "Bow Tie", products: ["Fancy Bow Tie", "Adjustable Bow Tie", "Collar with Bow Tie", "Holiday Bow Tie", "Small Bow Tie"] },
                { name: "Scratcher", products: ["Cardboard Scratcher", "Scratching Post", "Cat Tree", "Wall Scratcher", "Scratcher Pad"] },
                { name: "Sunglass", products: ["Pet Sunglasses", "Cat Goggles", "Fashion Sunglasses", "Protective Eyewear", "Funky Goggles"] },
            ]
        },
        {
            name: "Dog Food",
            icon: "fa-solid fa-bone",
            subcategories: [
                { name: "Puppy Food", products: ["Royal Canin Puppy", "Purina Puppy Chow", "Pedigree Puppy", "Acana Puppy", "Orijen Puppy"] },
                { name: "Dog Adult Food", products: ["Pedigree Adult", "Drools Dog Food", "Acana Adult", "Royal Canin Medium Adult", "Blackwood Dog Food"] },
                { name: "Vitamin & Supplements", products: ["Joint Supplements", "Multivitamin Chews", "Fish Oil", "Probiotics", "Skin & Coat Supplements"] },
            ]
        },
        {
            name: "Dog Health and Accessories",
            icon: "fa-solid fa-dog",
            subcategories: [
                { name: "Dog Harness", products: ["No-Pull Harness", "Padded Harness", "Harness Vest", "Dog Vest", "Reflective Harness"] },
                { name: "Dog Shampoo", products: ["Flea & Tick Shampoo", "Oatmeal Shampoo", "De-Shedding Shampoo", "Puppy Shampoo", "Hypoallergenic Shampoo"] },
                { name: "Antifungal and Antibacterial Control", products: ["Medicated Shampoo", "Antifungal Spray", "Wound Spray", "Skin Ointment", "Topical Solution"] },
                { name: "Dog Toy", products: ["Chew Toy", "Rope Toy", "Fetch Ball", "Squeaky Toy", "Plush Toy"] },
            ]
        },
        {
            name: "Rabbit Food and Accessories",
            icon: "fa-solid fa-carrot",
            subcategories: [
                { name: "Rabbit Adult Food", products: ["Oxbow Garden Select", "Versele-Laga Cuni", "Rabbit Pellets", "Hay-Based Pellets", "Timothy Hay"] },
                { name: "Rabbit Junior Food", products: ["Oxbow Young Rabbit", "Versele-Laga Junior", "Alfalfa-Based Pellets", "Kitten Rabbit Food", "Junior Timothy"] },
            ]
        },
        {
            name: "Bird Food and Accessories",
            icon: "fa-solid fa-feather-pointed",
            subcategories: [{ name: "Bird Food", products: ["Parrot Seed Mix", "Cockatiel Food", "Canary Seed", "Pelleted Diet", "Millet Spray"] }]
        }
    ];

    const categoryList = document.getElementById('category-list');
    const productsContent = document.getElementById('products-content');
    const welcomeSection = document.getElementById('welcome-message');
    const allCategoriesTitle = document.getElementById('all-categories-title');
    const productsHeader = document.getElementById('products-header');
    const productContainer = document.getElementById('product-container');


    // Function to hide all products and show the welcome section
    function hideProducts() {
        productsContent.style.display = 'none';
        welcomeSection.style.display = 'flex';
        document.querySelectorAll('.main-category-item').forEach(item => {
            item.classList.add('collapsed');
        });
        document.querySelectorAll('.sub-category-list').forEach(list => {
            list.classList.remove('visible');
        });
        document.querySelectorAll('.sub-category-list li').forEach(item => {
            item.classList.remove('active');
        });
    }

    // Add click listener to "All Categories" title
    allCategoriesTitle.addEventListener('click', () => {
        hideProducts();
    });

    function renderCategories() {
        categoryList.innerHTML = '';
        petData.forEach(category => {
            const mainCategoryItem = document.createElement('li');
            mainCategoryItem.className = 'main-category-item collapsed';
            mainCategoryItem.innerHTML = `
                <div><i class="${category.icon}"></i>${category.name}</div>
                <i class="fa-solid fa-angle-right arrow-icon"></i>
            `;

            const subCategoryList = document.createElement('ul');
            subCategoryList.className = 'sub-category-list';

            category.subcategories.forEach(subcategory => {
                const subCategoryItem = document.createElement('li');
                subCategoryItem.textContent = subcategory.name;
                subCategoryItem.addEventListener('click', (e) => {
                    e.stopPropagation();
                    document.querySelectorAll('.sub-category-list li').forEach(item => item.classList.remove('active'));
                    subCategoryItem.classList.add('active');
                    renderProducts(subcategory);
                });
                subCategoryList.appendChild(subCategoryItem);
            });

            mainCategoryItem.addEventListener('click', () => {
                const isCollapsed = mainCategoryItem.classList.toggle('collapsed');
                subCategoryList.classList.toggle('visible');
            });

            categoryList.appendChild(mainCategoryItem);
            categoryList.appendChild(subCategoryList);
        });
    }

    function renderProducts(subcategory) {
        welcomeSection.style.display = 'none';
        productsContent.style.display = 'block';

        productsHeader.textContent = subcategory.name;
        productContainer.innerHTML = '';

        subcategory.products.forEach(productName => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card';

            const randomPrice = parseInt(Math.random() * 500 + 100);
            const randomRating = Math.floor(Math.random() * 5) + 1;
            let stars = '';
            for (let j = 0; j < 5; j++) {
                if (j < randomRating) {
                    stars += '<i class="fa-solid fa-star"></i>';
                } else {
                    stars += '<i class="fa-regular fa-star"></i>';
                }
            }

            productCard.innerHTML = `
                <div class="product-img-placeholder"></div>
                <h4>${productName}</h4>
                <div class="ratings">
                    <div class="stars">${stars}</div>
                </div>
                <p class="price">৳ ${randomPrice}</p>
                <div class="actions">
                    <a href="product_details.html" class="btn btn-add-to-cart">Add to cart</a>
                    <a href="shipping_details.html" class="btn btn-buy-now">Buy now</a>
                </div>
            `;
            productContainer.appendChild(productCard);
        });
    }

    renderCategories();
});














document.addEventListener('DOMContentLoaded', () => {

    // Helper function to update cart count across the site
    function updateCartCount() {
        const cartCountNav = document.getElementById('cart-count');
        if (cartCountNav) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const buyNowProduct = JSON.parse(localStorage.getItem('buyNowProduct'));
            let count = cart.reduce((total, item) => total + item.quantity, 0);
            if (buyNowProduct) {
                count = buyNowProduct.quantity;
            }
            cartCountNav.textContent = count;
        }
    }
    
    updateCartCount();

    // ==========================================================
    // Product Details Page Logic
    // ==========================================================
    const quantityInput = document.getElementById('quantity');
    const plusBtn = document.querySelector('.plus-btn');
    const minusBtn = document.querySelector('.minus-btn');
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const buyNowBtn = document.getElementById('buy-now-btn');
    const successMessage = document.getElementById('success-message');

    if (quantityInput && plusBtn && minusBtn) {
        plusBtn.addEventListener('click', () => {
            let currentQuantity = parseInt(quantityInput.value);
            quantityInput.value = currentQuantity + 1;
        });

        minusBtn.addEventListener('click', () => {
            let currentQuantity = parseInt(quantityInput.value);
            if (currentQuantity > 1) {
                quantityInput.value = currentQuantity - 1;
            }
        });
    }

    if (addToCartBtn) {
    addToCartBtn.addEventListener('click', () => {
        const productName = document.getElementById('product-name').textContent;
        const productPrice = parseFloat(document.getElementById('product-price').textContent.replace('৳ ', ''));
        const productQuantity = parseInt(document.getElementById('quantity').value);
        const productImage = document.getElementById('product-image').src;

        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const existingProductIndex = cart.findIndex(item => item.name === productName);
        
        if (existingProductIndex > -1) {
            cart[existingProductIndex].quantity += productQuantity;
        } else {
            const product = {
                name: productName,
                price: productPrice,
                quantity: productQuantity,
                image: productImage
            };
            cart.push(product);
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        
        if (successMessage) {
            successMessage.style.display = 'block';
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000);
        }
    });
}

    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', async (event) => {
            event.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get('product_id');
            const quantityInput = document.getElementById('quantity');
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

            try {
                const response = await fetch('buy_now_process.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ productId, quantity })
                });
                
                const result = await response.json();

                if (result.success) {
                    window.location.href = 'shipping_details.html';
                } else {
                    if (response.status === 401) {
                        alert("Please log in to proceed.");
                        window.location.href = `login.php?redirect=${encodeURIComponent(window.location.href)}`;
                    } else {
                        console.error('Failed to process buy now:', result.message);
                    }
                }
            } catch (error) {
                console.error('Error processing buy now:', error);
                alert('An error occurred. Please try again.');
            }
        });
    }

    // ==========================================================
    // Shipping Details Page Logic
    // ==========================================================
    const homeDeliveryRadio = document.getElementById('home-delivery');
    const officePickupRadio = document.getElementById('office-pickup');
    const shippingCostSpan = document.getElementById('shipping-cost');
    const subtotalSpan = document.getElementById('subtotal');
    const totalPriceSpan = document.getElementById('total-price');
    const orderItemsList = document.getElementById('order-items-list');
    const editCartBtn = document.getElementById('edit-cart-btn');
    const proceedToPaymentBtn = document.getElementById('proceed-to-payment-btn');
    const orderTotalSection = document.querySelector('.order-total-section');
    const clinicDetailsCard = document.getElementById('clinic-details-card');
    const homeDeliveryCard = document.getElementById('home-delivery-card');

    function renderOrderSummary() {
        if (!orderItemsList || !subtotalSpan || !totalPriceSpan) return;
        
        const buyNowProductString = localStorage.getItem('buyNowProduct');
        let products = [];
        if (buyNowProductString) {
            products.push(JSON.parse(buyNowProductString));
        } else {
            products = JSON.parse(localStorage.getItem('cart')) || [];
        }

        let subtotal = 0;
        orderItemsList.innerHTML = '';
        
        products.forEach(item => {
            subtotal += item.price * item.quantity;
            const itemElement = document.createElement('div');
            itemElement.className = 'order-item';
            itemElement.innerHTML = `
                <img src="${item.image}" alt="${item.name}">
                <div class="item-details">
                    <p class="item-name">${item.name}</p>
                    <p class="item-price">${item.quantity} &times; ৳${item.price}</p>
                </div>
            `;
            orderItemsList.appendChild(itemElement);
        });

        subtotalSpan.textContent = `৳ ${subtotal}`;
        updateTotal(subtotal);
    }
    
    function updateTotal(subtotal) {
        let shippingCost = parseFloat(shippingCostSpan.textContent.replace('৳ ', ''));
        let total = subtotal + shippingCost;
        totalPriceSpan.textContent = `৳ ${total}`;
        if (orderTotalSection) {
            orderTotalSection.querySelector('.order-total-price').textContent = `৳ ${total}`;
        }
    }

    if (homeDeliveryRadio && officePickupRadio) {
        homeDeliveryRadio.addEventListener('change', () => {
            if (homeDeliveryRadio.checked) {
                shippingCostSpan.textContent = `৳ 70`;
                homeDeliveryCard.style.display = 'block';
                clinicDetailsCard.style.display = 'none';
            }
            let subtotal = parseFloat(subtotalSpan.textContent.replace('৳ ', ''));
            updateTotal(subtotal);
        });
        
        officePickupRadio.addEventListener('change', () => {
            if (officePickupRadio.checked) {
                shippingCostSpan.textContent = `৳ 0`;
                homeDeliveryCard.style.display = 'none';
                clinicDetailsCard.style.display = 'block';
            }
            let subtotal = parseFloat(subtotalSpan.textContent.replace('৳ ', ''));
            updateTotal(subtotal);
        });
    }

    if (proceedToPaymentBtn) {
        proceedToPaymentBtn.addEventListener('click', () => {
            window.location.href = 'payment.html';
        });
    }

    if (editCartBtn) {
        editCartBtn.addEventListener('click', (e) => {
            e.preventDefault();
            localStorage.removeItem('buyNowProduct');
            window.location.href = 'cart.php';
        });
    }

    renderOrderSummary();

    // Dropdown Logic for Shipping Details
    const districtSelect = document.getElementById('district');
    const areaSelect = document.getElementById('area');
    
    if (districtSelect && areaSelect) {
        const locations = {
            Dhaka: ["Gulshan", "Banani", "Mohakhali", "Mirpur", "Uttara"],
            Chattogram: ["Agrabad", "Halisahar", "Pahartali"],
            Khulna: ["Khulna Sadar", "Rupsha"],
        };

        for (const district in locations) {
            const option = document.createElement('option');
            option.value = district;
            option.textContent = district;
            districtSelect.appendChild(option);
        }

        districtSelect.addEventListener('change', () => {
            areaSelect.innerHTML = '<option value="">Select Area</option>';
            const selectedDistrict = districtSelect.value;
            if (selectedDistrict && locations[selectedDistrict]) {
                locations[selectedDistrict].forEach(area => {
                    const option = document.createElement('option');
                    option.value = area;
                    option.textContent = area;
                    areaSelect.appendChild(option);
                });
            }
        });
    }

    // ==========================================================
    // Payment Page Logic
    // ==========================================================
    const termsCheckbox = document.getElementById('terms-checkbox');
    const confirmOrderBtn = document.getElementById('confirm-order-btn');
    const paymentMethods = document.querySelectorAll('.payment-method-card');

    if (paymentMethods.length > 0) {
        paymentMethods.forEach(method => {
            method.addEventListener('click', () => {
                paymentMethods.forEach(m => m.classList.remove('active'));
                method.classList.add('active');
            });
        });
    }

    if (termsCheckbox && confirmOrderBtn) {
        termsCheckbox.addEventListener('change', () => {
            confirmOrderBtn.disabled = !termsCheckbox.checked;
        });

        confirmOrderBtn.addEventListener('click', () => {
            alert('Your order has been placed successfully!');
            localStorage.removeItem('cart');
            localStorage.removeItem('buyNowProduct');
            window.location.href = 'order_confirmation.html';
        });
    }
});




















// কার্টের সংখ্যা আপডেট করার ফাংশন
function updateCartCount() {
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

// প্রোডাক্ট কার্ড তৈরি করার ফাংশন
function createProductCard(product) {
    const productCard = document.createElement('div');
    productCard.className = 'product-card';
    productCard.innerHTML = `
        <div class="product-img-placeholder" style="background-image: url('${product.imageUrl}');"></div>
        <div class="product-info">
            <h4>${product.name}</h4>
            <p class="price">৳ ${product.price}</p>
            <div class="actions">
                <a href="product_details.html" class="btn btn-primary btn-add-to-cart" data-product-id="${product.id}">Add to cart</a>
                <a href="shipping_details.html" class="btn btn-secondary btn-buy-now" data-product-id="${product.id}">Buy now</a>
            </div>
        </div>
    `;

    // Add to cart এবং Buy now বাটন ছাড়া অন্য কোথাও ক্লিক করলে product_details পেজে যাবে
    productCard.addEventListener('click', (event) => {
        if (!event.target.classList.contains('btn-add-to-cart') && !event.target.classList.contains('btn-buy-now')) {
            window.location.href = `product_details.html?product_id=${product.id}`;
        }
    });

    return productCard;
}

// বাটনগুলোর ইভেন্ট লিসেনার সেট করার ফাংশন
function setupEventListeners() {
    document.querySelectorAll('.btn-add-to-cart').forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const productId = event.target.getAttribute('data-product-id');
            // Add to cart হলে product_details.html পেজে যাবে
            window.location.href = `product_details.html?product_id=${productId}`;
        });
    });

    document.querySelectorAll('.btn-buy-now').forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const productId = event.target.getAttribute('data-product-id');
            // Buy now হলে shipping_details.html পেজে যাবে
            window.location.href = `shipping_details.html?product_id=${productId}`;
        });
    });
}










document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    
    // সার্ভার থেকে প্রোডাক্ট ডেটা লোড করার কোড
    fetch('fetch_products.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(allProducts => {
            // এখন allProducts ভেরিয়েবলটিতে ডাটাবেজ থেকে আসা ডেটা থাকবে।
            // আপনার আগের লজিকটি এই ব্লকের ভেতরেই রাখুন।

            const urlPath = window.location.pathname;
            
            // index.php, pet_categories.php এবং pet_medicines.html পেজের জন্য
            const productContainer = document.getElementById('product-container');
            if (productContainer) {
                let productsToDisplay = [];
                const productsHeader = document.getElementById('products-header');
        
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
        
            // product_details.html পেজের জন্য
            if (urlPath.includes('product_details.html')) {
                const urlParams = new URLSearchParams(window.location.search);
                const productId = urlParams.get('product_id');
                const product = allProducts.find(p => p.id == productId);
        
                if (product) {
                    document.getElementById('product-image').style.backgroundImage = `url('${product.imageUrl}')`;
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
                        successMessage.style.display = 'block';
                        setTimeout(() => {
                            successMessage.style.display = 'none';
                        }, 3000);
                    });
                    
                    document.getElementById('buy-now-btn').addEventListener('click', (event) => {
                        event.preventDefault();
                        window.location.href = `shipping_details.html?product_id=${productId}`;
                    });
                }
            }
        
            // Shipping page এর জন্য
            if (urlPath.includes('shipping_details.html')) {
                document.getElementById('payment-btn').addEventListener('click', (event) => {
                    event.preventDefault();
                    window.location.href = 'payment.html';
                });
            }
        
            // Payment page এর জন্য
            if (urlPath.includes('payment.html')) {
                document.getElementById('confirm-order-btn').addEventListener('click', (event) => {
                    event.preventDefault();
                    alert('আপনার প্রোডাক্ট অর্ডার সফল হয়েছে!');
                    localStorage.setItem('cartCount', 0);
                    updateCartCount();
                    window.location.href = 'index.php';
                });
            }
        })
        .catch(error => {
            console.error('Error fetching products:', error);
            // এখানে আপনি কোনো এরর মেসেজ দেখাতে পারেন
        });
});