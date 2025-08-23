document.addEventListener('DOMContentLoaded', () => {
    const petMedicineData = [
        {
            name: "Cat Medicine",
            icon: "fa-solid fa-cat",
            products: [
                "Flea & Tick Prevention",
                "Deworming Tablets",
                "Pain Relief Medication",
                "Antibiotic Ointment",
                "Urinary Tract Support",
                "Dental Care Chews",
                "Hairball Control Gel",
                "Anxiety Relief Drops",
                "Joint Support Supplements",
                "Wound Care Spray",
                "Allergy Relief Tablets",
                "Ear Mite Treatment",
                "Digestive Aid Probiotics",
                "Eye Drops",
                "Immune System Booster",
                "Skin & Coat Supplements",
                "Vitamins for Kittens",
                "Calming Pheromone Spray",
                "Fungal Infection Cream",
                "Anti-Diarrhea Liquid"
            ]
        },
        {
            name: "Dog Medicine",
            icon: "fa-solid fa-dog",
            products: [
                "Heartworm Prevention",
                "Flea & Tick Collar",
                "Joint & Hip Supplement",
                "Canine Aspirin",
                "Anxiety Medication",
                "Ear Cleaner",
                "Allergy Relief Chews",
                "Deworming Granules",
                "Antibiotic Powder",
                "Cough Suppressant",
                "Weight Management Aid",
                "Dental Hygiene Spray",
                "Skin Soothing Shampoo",
                "Probiotic for Digestion",
                "Eye & Ear Wipes",
                "Immune Support Chews",
                "Puppy Vitamins",
                "Wound Healing Gel",
                "Urinary Health Chews",
                "Kennel Cough Drops"
            ]
        },
        {
            name: "Rabbit Medicine",
            icon: "fa-solid fa-carrot",
            products: [
                "Deworming Paste",
                "Pain Relief Drops",
                "Critical Care Feed",
                "Anti-Bloat Liquid",
                "Gut Motility Supplement",
                "Fungal Treatment Cream",
                "Ear Mite Drops",
                "Vitamin C Supplement",
                "Probiotic Powder",
                "Wound Spray",
                "Skin Balm",
                "Antibiotic Solution",
                "Respiratory Support",
                "Joint Health Chews",
                "Eye Wash",
                "Hairball Remedy",
                "Stress Relief Drops",
                "Immune Booster",
                "Digestive Enzymes",
                "Calming Spray"
            ]
        },
        {
            name: "Bird Medicine",
            icon: "fa-solid fa-feather-pointed",
            products: [
                "Respiratory Aid Drops",
                "Feather Plucking Spray",
                "Vitamin Supplement",
                "Calcium Block",
                "Antibiotic for Colds",
                "Mite & Lice Spray",
                "Probiotic for Digestion",
                "Wound Care Ointment",
                "Egg Binding Remedy",
                "Fungal Infection Treatment",
                "Eye Drops",
                "Stress Relief Drops",
                "Immune Booster",
                "Molting Support",
                "Beak & Nail Conditioner",
                "Feather Conditioner Spray",
                "Gout Treatment",
                "Air Sac Mite Treatment",
                "Diarrhea Medicine",
                "Dehydration Solution"
            ]
        }
    ];

    const categoryList = document.getElementById('category-list');
    const productsContent = document.getElementById('products-content');
    const welcomeSection = document.getElementById('welcome-message');
    const allCategoriesTitle = document.getElementById('all-categories-title');
    const productsHeader = document.getElementById('products-header');
    const productContainer = document.getElementById('product-container');

    function hideProducts() {
        productsContent.style.display = 'none';
        welcomeSection.style.display = 'flex';
        
        document.querySelectorAll('#category-list li').forEach(item => {
            item.classList.remove('active');
        });
    }

    allCategoriesTitle.addEventListener('click', () => {
        hideProducts();
    });

    function renderCategories() {
        categoryList.innerHTML = '';
        petMedicineData.forEach(category => {
            const mainCategoryItem = document.createElement('li');
            mainCategoryItem.className = 'main-category-item';
            mainCategoryItem.innerHTML = `
                <div><i class="${category.icon}"></i>${category.name}</div>
            `;
            
            mainCategoryItem.addEventListener('click', () => {
                document.querySelectorAll('#category-list li').forEach(item => {
                    item.classList.remove('active');
                });
                mainCategoryItem.classList.add('active');
                renderProducts(category);
            });
            categoryList.appendChild(mainCategoryItem);
        });
    }

    function renderProducts(category) {
        welcomeSection.style.display = 'none';
        productsContent.style.display = 'block';

        productsHeader.textContent = category.name;
        productContainer.innerHTML = '';
        
        category.products.forEach(productName => {
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