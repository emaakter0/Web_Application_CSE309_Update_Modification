<?php  
require("db.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitty Pups - Pet Care & Shop</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

    <header>
        <div class="clinic-title" style="text-align: center; font-size: 24px; font-weight: bold; color: white; margin-bottom: 10px;">
        Veterinary Clinic Management System
    </div>
        <div class="top-bar">
            <div class="container">
                <div class="left-links">
                    <a href="https://maps.app.goo.gl/VVHL3sAgMWqzh357A" target="_blank" class="map-location">
    <i class="fa-solid fa-location-dot"></i> KittyPups Location
</a>
                    <a href="#">Track my order</a>
                     
                 <?php if(isset($_SESSION['user_id'])): ?>
                        <?php if($_SESSION['role'] === "customer"): ?>
                            <a href="client_dashboard.php">My Account</a>
                        <?php elseif($_SESSION['role'] === "admin"): ?>
                            <a href="admin_dashboard.php">My Dashboard</a>
                        <?php elseif($_SESSION['role'] === "doctor"): ?>
                            <a href="doctor_dashboard.php">My Account</a>
                        <?php endif; ?>
                        <!-- Show when logged in -->
                        <a href="logout.php">Logout</a>
                <?php else: ?>
                        <!-- Show when not logged in -->
                        <a href="signup.html">Sign Up</a>
                        <a href="login.php">Login</a>
                 <?php endif; ?>
                                    
               
                </div>
                <div class="right-info">
                    <a href="tel:+8801767675206" class="emergency-contact">Emergency Contact Number: +8801767675206</a>
                </div>
            </div>
        </div>
        <nav class="main-nav">
            <div class="container">
                <div class="logo">
                    <img src="WhatsApp Image 2025-08-09 at 17.06.15_24840d36.jpg" alt="Kitty Pups Logo">
                    <div class="logo-text">
                        <span>KittyPups</span>
                        <p>Every Life Counts</p>
                    </div>
                </div>
                
                <div class="nav-links">
    <ul>
        <li><a href="index.php"> Pet Home</a></li>
        <li><a href="#pet-lifestyle">Pet Lifestyle</a></li>
        <li><a href="pet_categories.php">Pet Categories</a></li>
        <li><a href="pet_medicines.php"> Pet Pharmacy</a></li>
        <li><a href="pet_services.html"> Pet Treatment Services</a></li>
        <li><a href="aboutus.html">About Us</a></li>
        <li><a href="contractus.html">Contact Us</a></li>
    </ul>
</div>
                <div class="nav-actions">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" placeholder="Search food, medicine, services...">
                    </div>
                    <a href="cart.php" class="cart-icon position-relative">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Cart</span>
                        <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">
                            0
                        </span>
                    </a>
                </div>
            </div>
        </nav>
    </header>
    

    <main>
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <p class="tagline">Caring since 2015</p>
                    <h1>We care your pet</h1>
                    <p class="description">Compassionate veterinary services, 24/7 pharmacy, and trusted products under one roof.</p>
                    <div class="hero-buttons">
                        <a href="book_appointment.php" class="btn btn-primary">Book an Appointment</a>
                        <a href="pet_services.html" class="btn btn-secondary">Explore Services</a>
                    </div>
                    <p class="trust-info"><i class="fa-solid fa-circle-check"></i> Trusted by 10k+ pet parents</p>
                </div>
                <div class="hero-image">
                    <img src="shutterstock_2391795695-scaled.jpg" alt="Doctor and a dog">
                </div>
            </div>
        </section>

        <section class="services-section section-gap">
            <div class="container-column">
                <div class="section-header">
                    <h2>Best Pet Care Services</h2>
                    <p>Professional and loving care for every pet.</p>
                </div>
                <div class="services-grid">
                    <div class="service-card">
                        <i class="fa-solid fa-syringe"></i>
                        <h3>Vaccinations</h3>
                        <p>Core and lifestyle vaccines.</p>
                        <!--<a href="#">Learn more</a>-->
                    </div>
                    <div class="service-card">
                        <i class="fa-solid fa-scissors"></i>
                        <h3>Grooming</h3>
                        <p>Gentle care for coat & nails.</p>
                        <!--<a href="#">Learn more</a>-->
                    </div>
                    <div class="service-card">
                        <i class="fa-solid fa-heart-pulse"></i>
                        <h3>Pet Treatment</h3>
                        <p>Diagnostics and therapy.</p>
                        <!--<a href="#">Learn more</a>-->
                    </div>
                </div>
            </div>
        </section>
        
        <section class="commitment-section section-gap">
            <div class="container-column">
                <div class="section-header">
                    <h2>We are committed for better service</h2>
                    <p>Our dedicated veterinary team provides preventive care, diagnostics, surgery, and recovery programs tailored to your pet.</p>
                </div>
                <div class="commitment-content">
                    <div class="commitment-image">
                        <img src="veterinarians-doctors-conduct-routine-examination-260nw-2391795715.jpg" alt="Commitment image placeholder">
                    </div>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <h3>15k+</h3>
                            <p>Happy Pets</p>
                        </div>
                        <div class="stat-card">
                            <h3>8k+</h3>
                            <p>Appointments</p>
                        </div>
                        <div class="stat-card">
                            <h3>350+</h3>
                            <p>Successful Treatments</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="gallery-section section-gap">
            <div class="container-column">
                <div class="section-header">
                    <h2>Gallery</h2>
                    <p>Pet treatment moments</p>
                </div>
                <div class="gallery-grid">
                    <div class="gallery-item"><img src="https://imbc.edu/wp-content/uploads/2019/11/AdobeStock_260006412-1024x684.jpg"></div>
                    <div class="gallery-item"><img src="https://trocaire.edu/academics/wp-content/uploads/sites/2/2024/04/PFI_VetTech_1200x600-1200x602-c-center.jpg" alt="Gallery image"></div>
                    <div class="gallery-item"><img src="https://www.stanleyvet.com/wp-content/uploads/sites/106/2020/05/ultrasound1-1.jpeg" alt="Cat petting"></div>
                    <div class="gallery-item"><img src="https://mydutchesscountyanimalhospital.com/wp-content/uploads/2023/06/DCAH-services-ultrasound.png" alt="Gallery image"></div>
                </div>
            </div>
        </section>

    <section class="team-section section-gap">
    <div class="container-column">
        <div class="section-header">
            <h2>Meet our Team</h2>
            <p>Veterinary doctors you can trust</p>
        </div>
        <div class="team-grid">
            <div class="team-card doctor-card">
                <img src="https://media.istockphoto.com/id/879798432/photo/doctor-veterinarian-at-clinic.jpg?s=612x612&w=0&k=20&c=VfTbSomALoDbQbzNV9MxgDxyQ8VWrX-ska6R2I63Ohg=" alt="Dr. A. Rahman">
                <h3>Dr. A. Rahman</h3>
                <p>Veterinary Surgeon</p>
            </div>
            <div class="team-card">
                <img src="https://thumbs.dreamstime.com/b/professional-female-veterinary-nurse-checking-pet-dog-eyes-29924256.jpg" alt="Dr. S. Akter">
                <h3>Dr. S. Akter</h3>
                <p>Vet Consultant</p>
            </div>
            <div class="team-card">
                <img src="https://img.freepik.com/premium-photo/young-male-veterinary-doctor-standing-by-medical-table-with-yorkshire-terrier_236854-46903.jpg" alt="Dr. M. Hasan">
                <h3>Dr. M. Hasan</h3>
                <p>Dentistry & Grooming</p>
            </div>
        </div>
    </div>
</section>



        <section class="shop-section section-gap">
    <div class="container-column">
        <div class="section-header">
            <h2>Shop</h2>
            <p>Food, accessories, and medicine. Add to cart and order online.</p>
        </div>
        <div class="shop-category">
            <div class="category-header">
                <h3>Food</h3>
                <a href="pet_categories.php" class="see-all">See all</a>
            </div>
            <div class="product-grid">

<!-- Product Cards Starts-->


<div class="product-container" style="display: flex; flex-wrap: wrap; gap: 20px; padding: 20px;">
    <?php
    // Connect to database
    $conn = mysqli_connect("localhost", "root", "", "kittypups");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Fetch products where category contains 'food'
    $sql = "SELECT * FROM products WHERE category LIKE '%food%'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while($product = mysqli_fetch_assoc($result)) {
            // Generate star ratings based on rating value
            $rating = intval($product['rating']);
            $stars = '';
            
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rating) {
                    $stars .= '<i class="fa-solid fa-star"></i>';
                } else {
                    $stars .= '<i class="fa-regular fa-star"></i>';
                }
            }
            
            echo '
            <div class="product-card" style="width: 250px; border: 1px solid #ddd; border-radius: 8px; padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <div class="product-img-placeholder" style="height: 200px; background-image: url(\'' . htmlspecialchars($product['image']) . '\'); background-size: cover; background-position: center; border-radius: 5px;"></div>
                <div class="product-info" style="margin-top: 15px;">
                    <h4 style="margin: 10px 0; font-size: 16px;">' . htmlspecialchars($product['name']) . '</h4>
                    <div class="ratings">
                        <div class="stars" style="color: #ffc107;">
                            ' . $stars . '
                        </div>
                    </div>
                    <p class="price" style="font-weight: bold; color: #dc3545; margin: 10px 0;">৳ ' . number_format($product['price'], 2) . '</p>
                    <div class="actions" style="display: flex; gap: 10px;">
                        <a href="product_details.php?id=' . $product['id'] . '" class="btn btn-primary btn-add-to-cart" data-product-id="' . $product['id'] . '" style="flex: 1; padding: 8px 12px; background: #dc3545; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Add to cart</a>
                        <a href="shipping_details.php?id=' . $product['id'] . '" class="btn btn-secondary btn-buy-now" data-product-id="' . $product['id'] . '" style="flex: 1; padding: 8px 12px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Buy now</a>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<p>No food products found.</p>';
    }
    
    mysqli_close($conn);
    ?>
</div>
                



<!-- Product Cards Ends -->

            </div>
        </div>

        <div class="shop-category">
            <div class="category-header">
                <h3>Accessories</h3>
                <a href="pet_categories.php" class="see-all">See all</a>
            </div>
            <div class="product-grid">


<!-- Product Cards Starts -->

<div class="product-container" style="display: flex; flex-wrap: wrap; gap: 20px; padding: 20px;">
    <?php
    // Connect to database
    $conn = mysqli_connect("localhost", "root", "", "kittypups");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Fetch products where category is 'accessories'
    $sql = "SELECT * FROM products WHERE category = 'accessories'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while($product = mysqli_fetch_assoc($result)) {
            // Generate star ratings based on rating value
            $rating = intval($product['rating']);
            $stars = '';
            
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rating) {
                    $stars .= '<i class="fa-solid fa-star"></i>';
                } else {
                    $stars .= '<i class="fa-regular fa-star"></i>';
                }
            }
            
            echo '
            <div class="product-card" style="width: 250px; border: 1px solid #ddd; border-radius: 8px; padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <div class="product-img-placeholder" style="height: 200px; background-image: url(\'' . htmlspecialchars($product['image']) . '\'); background-size: cover; background-position: center; border-radius: 5px;"></div>
                <div class="product-info" style="margin-top: 15px;">
                    <h4 style="margin: 10px 0; font-size: 16px;">' . htmlspecialchars($product['name']) . '</h4>
                    <div class="ratings">
                        <div class="stars" style="color: #ffc107;">
                            ' . $stars . '
                        </div>
                    </div>
                    <p class="price" style="font-weight: bold; color: #dc3545; margin: 10px 0;">৳ ' . number_format($product['price'], 2) . '</p>
                    <div class="actions" style="display: flex; gap: 10px;">
                        <a href="product_details.php?id=' . $product['id'] . '" class="btn btn-primary btn-add-to-cart" data-product-id="' . $product['id'] . '" style="flex: 1; padding: 8px 12px; background: #dc3545; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Add to cart</a>
                        <a href="shipping_details.php?id=' . $product['id'] . '" class="btn btn-secondary btn-buy-now" data-product-id="' . $product['id'] . '" style="flex: 1; padding: 8px 12px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Buy now</a>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<p>No accessory products found.</p>';
    }
    
    mysqli_close($conn);
    ?>
</div>
            

<!-- Product Cards Ends -->



            </div>
        </div>

        <div class="shop-category">
            <div class="category-header">
                <h3>Medicine</h3>
                <a href="pet_medicines.php" class="see-all">See all</a>
            </div>
            <div class="product-grid">
            <div class="product-container" style="display: flex; flex-wrap: wrap; gap: 20px; padding: 20px;">
    <?php
    // Connect to database
    $conn = mysqli_connect("localhost", "root", "", "kittypups");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Fetch products where category is 'medicine'
    $sql = "SELECT * FROM products WHERE category = 'medicine'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while($product = mysqli_fetch_assoc($result)) {
            // Generate star ratings based on rating value
            $rating = intval($product['rating']);
            $stars = '';
            
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rating) {
                    $stars .= '<i class="fa-solid fa-star"></i>';
                } else {
                    $stars .= '<i class="fa-regular fa-star"></i>';
                }
            }
            
            echo '
            <div class="product-card" style="width: 250px; border: 1px solid #ddd; border-radius: 8px; padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <div class="product-img-placeholder" style="height: 200px; background-image: url(\'' . htmlspecialchars($product['image']) . '\'); background-size: cover; background-position: center; border-radius: 5px;"></div>
                <div class="product-info" style="margin-top: 15px;">
                    <h4 style="margin: 10px 0; font-size: 16px;">' . htmlspecialchars($product['name']) . '</h4>
                    <div class="ratings">
                        <div class="stars" style="color: #ffc107;">
                            ' . $stars . '
                        </div>
                    </div>
                    <p class="price" style="font-weight: bold; color: #dc3545; margin: 10px 0;">৳ ' . number_format($product['price'], 2) . '</p>
                    <div class="actions" style="display: flex; gap: 10px;">
                        <a href="product_details.php?id=' . $product['id'] . '" class="btn btn-primary btn-add-to-cart" data-product-id="' . $product['id'] . '" style="flex: 1; padding: 8px 12px; background: #dc3545; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Add to cart</a>
                        <a href="shipping_details.php?id=' . $product['id'] . '" class="btn btn-secondary btn-buy-now" data-product-id="' . $product['id'] . '" style="flex: 1; padding: 8px 12px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Buy now</a>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<p>No medicine products found.</p>';
    }
    
    mysqli_close($conn);
    ?>
</div>
               
            </div>
        </div>
    </div>
</section>

        
    <section id="pet-lifestyle" class="lifestyle-section section-gap"></section>
    <div class="container-column">
        <div class="section-header">
            <h2>Pet Lifestyle</h2>
            <p>Guides to keep your pet happy and healthy</p>
        </div>
        <div class="lifestyle-grid">
            <div class="lifestyle-card">
                <img src="https://amarpet.blob.core.windows.net/production/97788494d0cb9c4ad37af9a76290b361/5.svg" alt="Puppy Care" class="lifestyle-img"> <!-- Image replace koro -->
                <h3>বিড়ালকে বেশি পানি পান করানোর ১০টি কার্যকরী উপায়</h3>
                <p>বিড়ালের শরীর সুস্থ রাখার জন্য পর্যাপ্ত পানি পান করা অত্যন্ত জরুরি।</p>
                <a href="puppy_care.html" class="btn btn-tertiary">Read More</a> <!-- Link to detailed page -->
            </div>
            <div class="lifestyle-card">
                <img src="https://amarpet.com/_next/image?url=https%3A%2F%2Famarpet.blob.core.windows.net%2Fproduction%2Fa0b83c02d720415dada82e08bc09e9f3%2F%E0%A6%AC%E0%A6%BF%E0%A6%A1%E0%A6%BC%E0%A6%BE%E0%A6%B2-%E0%A6%8F%E0%A6%AC%E0%A6%82-%E0%A6%95%E0%A7%81%E0%A6%95%E0%A7%81%E0%A6%B0-%E0%A6%8F%E0%A6%95%E0%A6%B8%E0%A6%BE%E0%A6%A5%E0%A7%87-%E0%A6%B0%E0%A6%BE%E0%A6%96%E0%A6%BE%E0%A6%B0-%E0%A6%AA%E0%A6%A6%E0%A7%8D%E0%A6%A7%E0%A6%A4%E0%A6%BF-768-.png&w=640&q=75" alt="Cat Enrichment" class="lifestyle-img"> <!-- Image replace koro -->
                <h3>বিড়াল এবং কুকুর একসাথে রাখার পদ্ধতি</h3>
                <p>বিড়াল এবং কুকুরের মধ্যে বন্ধুত্ব গড়ে তোলা কিছু সহজ উপায়।</p>
                <a href="cat_enrichment.html" class="btn btn-tertiary">Read More</a> <!-- Link to detailed page -->
            </div>
            <div class="lifestyle-card">
                <img src="https://amarpet.com/_next/image?url=https%3A%2F%2Famarpet.blob.core.windows.net%2Fproduction%2F779efbd24d5a7e37ce8dc93e7c04d572%2F%E0%A6%AC%E0%A6%BF%E0%A6%A1%E0%A6%BC%E0%A6%BE%E0%A6%B2%E0%A7%87%E0%A6%B0-%E0%A6%B8%E0%A6%A0%E0%A6%BF%E0%A6%95-%E0%A6%98%E0%A7%81%E0%A6%AE%E0%A7%87%E0%A6%B0-%E0%A6%B8%E0%A6%AE%E0%A6%AF%E0%A6%BC--%E0%A6%93-%E0%A6%AA%E0%A7%8D%E0%A6%B0%E0%A6%AF%E0%A6%BC%E0%A7%87%E0%A6%BE%E0%A6%9C%E0%A6%A8%E0%A7%80%E0%A6%AF%E0%A6%BC%E0%A6%A4%E0%A6%BE-768-.png&w=640&q=75" alt="Senior Pet Wellness" class="lifestyle-img"> <!-- Image replace koro -->
                <h3>বিড়ালের ঘুমের সময় এবং প্রয়োজনীয়তা</h3>
                <p>বিড়ালের ঘুমের প্রয়োজনীয়তা এবং তার শারীরিক ও মানসিক স্বাস্থ্য।</p>
                <a href="senior_pet_wellness.html" class="btn btn-tertiary">Read More</a> <!-- Link to detailed page -->
            </div>
        </div>
    </div>
</section>


        <section class="ratings-section section-gap">
    <div class="container-column">
        <div class="section-header">
            <h2>Ratings</h2>
            <p>What our clients say</p>
        </div>
        <div class="ratings-grid">
            <!-- Card 1 -->
            <div class="rating-card">
                <div class="card-content">
                    <div class="card-img">
                        <img src="https://i.pinimg.com/1200x/d5/f6/bd/d5f6bd13c328fa434323a69a406b1c23.jpg" alt="Client">
                    </div>
                    <div class="card-text">
                        <p class="testimonial">I am thoroughly impressed! The treatment and surgery were exceptional, and I felt comfortable throughout the entire process. The service was efficient, and the product selection is fantastic. The clinic environment was very clean and welcoming, making it a great experience overall.</p>
                        <h3 class="client-name">Sunny Haque</h3>
                        <div class="stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="rating-card">
                <div class="card-content">
                    <div class="card-img">
                        <img src="https://i.pinimg.com/736x/5d/ce/62/5dce620cce6065aabd9dd3bb821cfeb2.jpg" alt="Client">
                    </div>
                    <div class="card-text">
                        <p class="testimonial">I have been buying products for my cats for awhile now, and I have to say this page is definitely the best one to purchase anything for your pets. The treatment and surgery were top-notch. The service is always great, and the clinic environment is very friendly and well-kept.</p>
                        <h3 class="client-name">Zasia Tashnuva</h3>
                        <div class="stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="rating-card">
                <div class="card-content">
                    <div class="card-img">
                        <img src="https://i.pinimg.com/1200x/d5/a6/56/d5a656a44107cbd10bf6a373d44cb112.jpg" alt="Client">
                    </div>
                    <div class="card-text">
                        <p class="testimonial">I recently visited and I am absolutely delighted with my experience! The treatment and surgery were excellent. Friendly and knowledgeable staff, quick service, and an amazing product range. The clinic environment was comfortable and very well-maintained.</p>
                        <h3 class="client-name">Nadim Chowdhury</h3>
                        <div class="stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="rating-card">
                <div class="card-content">
                    <div class="card-img">
                        <img src="https://i.pinimg.com/736x/01/6f/73/016f739ffb1fafed9082fb6165e76e15.jpg" alt="Client">
                    </div>
                    <div class="card-text">
                        <p class="testimonial">The service was amazing. The staff is very caring, and they provided great help in choosing the best products for my pet. The treatment and surgery were very professional, the products were perfect, and the clinic environment was clean and inviting.</p>
                        <h3 class="client-name">Mariam Rahman</h3>
                        <div class="stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




    </main>

    <div class="chatbot-buttons">
    <a href="https://wa.me/8801767675206" target="_blank" class="chatbot-btn whatsapp-btn" title="Chat on WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    <a href="https://www.facebook.com/kittypupsbd" target="_blank" class="chatbot-btn messenger-btn" title="Chat on Messenger">
        <i class="fa-brands fa-facebook-messenger"></i>
    </a>
</div>
</a>
</a>
</div>

 <footer>
    <div class="container">
        <div class="footer-col about-footer">
            <div class="logo">
                <img src="WhatsApp Image 2025-08-09 at 17.06.15_24840d36.jpg" alt="Kitty Pups Logo">
                <div class="logo-text">
                    <span>KittyPups</span>
                    <p>Every Life Counts</p>
                </div>
            </div>
            <p>Kitty Pups is a pet hospital that provides all kinds of veterinary services with the best care. We are highly determined to help the adorable pets to be cured. We also provide pet products such as food, accessories, medication, and care items. Your visit to our clinic would be much appreciated. Thanks for being with us.</p>
            <p>Address: Basundhara Main Road, Ground Floor, 1229</p>
            <p>Phone: 01767-675206</p>
            
            <!-- Directions Box with White Background and Pink Border -->
            <div class="directions-box" style="background-color: #fff; padding: 15px; display: flex; align-items: center; border-radius: 8px; border: 2px solid #ff5a8f;">
                <i class="fa fa-map-marker-alt" style="color: #ff5a8f; font-size: 20px; margin-right: 10px;"></i>
                <a href="https://maps.app.goo.gl/VVHL3sAgMWqzh357A" target="_blank" style="color: #ff5a8f; font-weight: bold; text-decoration: none;">Get Directions</a>
            </div>
            
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <div class="footer-col">
            <h4>About</h4>
            <ul>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">FAQs</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Customer Service</h4>
            <ul>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Use</a></li>
                <li><a href="#">Return & Refund policy</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Mobile Apps</h4>
            <div class="app-links">
                <a href="#"><img src="https://amarpet.com/_next/image?url=%2Fassets%2Flogo%2Fapp-store.png&w=256&q=75=" alt="App Store"></a>
                <a href="#"><img src="https://amarpet.com/_next/image?url=%2Fassets%2Flogo%2Fplay-store.png&w=256&q=75" alt="Google Play"></a>
            </div>
        </div>
    </div>

    <!-- Payment Section -->
    <div class="bottom-bar">
        <div class="container">
            <div class="payment-icons" style="text-align: center;">
                <img src="https://amarpet.com/_next/image?url=%2Fassets%2Fbanner%2FSSLCOMMERZ-desktop.png&w=3840&q=75" alt="Payment Methods" style="width: 100%; height: auto; max-height: 200px;">
            </div>
        </div>
    </div>

    <!-- Copyright Section -->
    <div class="container" style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
        <p style="font-weight: bold; text-align: center; margin: 0;">© 2025 KittyPups. All Rights Reserved.</p>
    </div>
</footer>











</body>
</html>




<script>



</script>