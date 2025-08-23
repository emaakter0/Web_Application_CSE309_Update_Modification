document.addEventListener('DOMContentLoaded', function() {
    const serviceCategories = document.getElementById('service-categories');
    const serviceDetailsContainer = document.getElementById('service-details-container');
    const backButton = document.getElementById('back-button');
    const backButtonText = backButton.querySelector('.btn-primary');

    const servicesData = {
        lab: {
            icon: 'lab icon.png', // সার্ভিস কার্ডের আইকন
            image: 'lab.jpg', // ট্রিটমেন্ট প্রাইস পেজের বড় ছবি
            treatments: {
                'Laser Treatment (Physiotherapy)': [
                    { name: '(10min) Per day', price: '300/=' },
                    { name: 'Weekly', price: '2000/=' },
                    { name: 'Monthly', price: '7000/=' }
                ],
                'Microscopic Examination': [
                    { name: 'Coproscopy', price: '200/=' },
                    { name: 'Skin Scraping Test', price: '200/=' },
                    { name: 'Blood Protozoa', price: '300/=' }
                ],
                'Spot test': [
                    { name: 'FPV', price: '650/=' },
                    { name: 'FIP', price: '800/=' },
                    { name: 'EPI', price: '300/=' },
                    { name: 'Canine Parvo (CPV)', price: '650/=' },
                    { name: 'Canine Distemper (CD)', price: '650/=' },
                    { name: 'Ear Mites Test', price: '200/=' },
                    { name: 'Ocular ulcer Test (Eye Test)', price: '200/=' },
                    { name: 'Faline Calici', price: '650/=' },
                    { name: 'Rivalta Test', price: '200/=' },
                    { name: 'Toxoplasmosis', price: '650/=' },
                    { name: 'Urine R/E Test', price: '200/=' }
                ],
                'Biochemical / Serological Examinations': [
                    { name: 'Total Protem', price: '600/=' },
                    { name: 'Albumin', price: '600/=' },
                    { name: 'Glucose', price: '600/=' },
                    { name: 'Calcium', price: '600/=' },
                    { name: 'Phosphorus', price: '600/=' },
                    { name: 'Creatinine', price: '600/=' },
                    { name: 'BUN', price: '600/=' },
                    { name: 'Urea', price: '600/=' },
                    { name: 'Bilirubin', price: '600/=' },
                    { name: 'SGPT', price: '600/=' },
                    { name: 'SGOT', price: '600/=' },
                    { name: 'Alkaline Phosphatase (ALP)', price: '600/=' },
                    { name: 'Cholesterol', price: '600/=' },
                    { name: 'Potassium', price: '600/=' },
                    { name: 'Chloride', price: '600/=' },
                    { name: 'Triglyceride', price: '600/=' },
                    { name: 'Amylase', price: '1000/=' },
                    { name: 'Lipase', price: '1000/=' }
                ],
                'Hematological Examination': [
                    { name: 'CBC', price: '1200/=' }
                ],
                'Immunological EXamination': [
                    { name: 'T3', price: '800/=' },
                    { name: 'T4', price: '800/=' },
                    { name: 'TSH', price: '800/=' },
                    { name: 'IgE', price: '1000/=' },
                    { name: 'Testosterone', price: '1000/=' },
                    { name: '25-OH-VD (vit.D)', price: '1000/=' }
                ],
                'Radiology': [
                    { name: 'Ultrasonography', price: '1200/=' },
                    { name: 'X-ray (Single view)', price: '1000/=' }
                ],
                'Grooming': [
                    { name: 'Dog Nail Cut', price: '400/=' },
                    { name: 'Dog Trimming', price: '2500/=' },
                    { name: 'Dog Shower', price: '1000/=' },
                    { name: 'Cat Nail Cut', price: '200/=' },
                    { name: 'Cat Trimming', price: '2000/=' },
                    { name: 'Cat Shower', price: '600/=' }
                ]
            }
        },
        cat: {
            icon: 'cat_icon.jpg',
            image: 'catser.jpg',
            treatments: {
                'Cat Services': [
                    { name: 'Consultation Fee', price: '700/=' },
                    { name: 'Follow Up/Rescued/Student', price: '400/=' },
                    { name: 'Nebulization', price: '300/=' },
                    { name: 'Oxygen', price: '200/=' },
                    { name: 'Deworming', price: '300/=' },
                    { name: 'IV Saline/IV Infusion', price: '300/=' },
                    { name: 'Vaccine', price: '1500/=' },
                    { name: 'Enema', price: '1500/++' },
                    { name: 'Catheterization', price: '1200/++' },
                    { name: 'Wound Dressing', price: '200-1000/=' }
                ],
                'Surgical Charges': [
                    { name: 'Spay', price: '3000/=' },
                    { name: 'Neuter/Castration', price: '2000/=' },
                    { name: 'Docking', price: '3000/=' },
                    { name: 'Eye enucleation', price: '3000/=' },
                    { name: 'Cherry eye correction', price: '5000/=' },
                    { name: 'C-section', price: '4000/++' },
                    { name: 'Pyometra', price: '3500/++' },
                    { name: 'Amputation', price: '4000/++' },
                    { name: 'Rectal Prolapse', price: '2000/++' },
                    { name: 'Hernia', price: '3000/++' },
                    { name: 'Teeth scaling', price: '2500/++' },
                    { name: 'Aural Hematoma', price: '2500/++' }
                ]
            }
        },
        dog: {
            icon: 'dogicon.jpg',
            image: 'dogser.jpeg',
            treatments: {
                'Dog Services': [
                    { name: 'Consultation Fee', price: '700/=' },
                    { name: 'Follow Up/Rescued/Student', price: '400/=' },
                    { name: 'Nebulization', price: '500/=' },
                    { name: 'Oxygen', price: '300/=' },
                    { name: 'Deworming', price: '400/=' },
                    { name: 'IV Saline/IV Infusion', price: '500/=' },
                    { name: 'Vaccine', price: '1500/=' },
                    { name: 'Catheterization', price: '1500/++' },
                    { name: 'Wound Dressing', price: '400-1000/=' }
                ],
                'Surgical Charges': [
                    { name: 'Spay', price: '4000/=' },
                    { name: 'Neuter/Castration', price: '3000/=' },
                    { name: 'Docking', price: '4000/=' },
                    { name: 'Eye enucleation', price: '3000/=' },
                    { name: 'C-section', price: '5500/++' },
                    { name: 'Pyometra', price: '4500/++' },
                    { name: 'Amputation', price: '5000/++' },
                    { name: 'Rectal Prolapse', price: '3000/++' },
                    { name: 'Hernia', price: '4000/++' },
                    { name: 'Teeth scaling', price: '3500/++' },
                    { name: 'Aural Hematoma', price: '2500/++' },
                    { name: 'Ear cropping', price: '2500/++' }
                ]
            }
        },
        rabbit: {
            icon: 'rabiticon.png',
            image: 'rabbitser.jpg',
            treatments: {
                'Rabbit Services': [
                    { name: 'Consultation Fee', price: '500/=' },
                    { name: 'Deworming', price: '250/=' },
                    { name: 'Nail Trimming', price: '200/=' },
                    { name: 'Wound Care', price: '300-800/=' }
                ],
                'Surgical Charges': [
                    { name: 'Neuter', price: '2500/=' },
                    { name: 'Spay', price: '3500/=' }
                ]
            }
        },
        bird: {
            icon: 'birdicon.png',
            image: 'birds.jpg',
            treatments: {
                'Bird Services': [
                    { name: 'Consultation Fee', price: '400/=' },
                    { name: 'Follow Up', price: '250/=' },
                    { name: 'Nebulization', price: '300/=' },
                    { name: 'Oxygen', price: '200/=' },
                    { name: 'Wound Dressing', price: '200-1000/=' }
                ],
                'Surgical Charges': [
                    { name: 'Deworming', price: '300/=' },
                    { name: 'Neuter', price: '1800/=' },
                    { name: 'Spay', price: '2800/=' },
                    { name: 'Pyometra', price: '3000/++' }
                ]
            }
        }
    };
    
    // Dynamically set icons in service cards
    document.querySelectorAll('.service-card').forEach(card => {
        const serviceType = card.dataset.service;
        if (servicesData[serviceType] && servicesData[serviceType].icon) {
            const imgElement = card.querySelector('img');
            if (imgElement) {
                imgElement.src = servicesData[serviceType].icon;
            }
        }
    });

    backButtonText.textContent = "Back to Home";
    backButton.href = "index.php";
    backButton.style.display = 'block';

    serviceCategories.addEventListener('click', function(event) {
        const card = event.target.closest('.service-card');
        if (card) {
            const serviceType = card.dataset.service;
            const service = servicesData[serviceType];
            
            if (service) {
                let treatmentsHTML = '';
                for (const category in service.treatments) {
                    treatmentsHTML += `<h4>${category}</h4><ul>`;
                    service.treatments[category].forEach(treatment => {
                        treatmentsHTML += `<li><span>${treatment.name}</span><span><span class="taka-icon">৳</span> <span class="price-amount">${treatment.price}</span></span></li>`;
                    });
                    treatmentsHTML += `</ul>`;
                }

                const detailsHTML = `
                    <div class="service-details active">
                        <img src="${service.image}" alt="${serviceType} Services Image">
                        <h3>${card.querySelector('h4').textContent}</h3>
                        <div class="treatment-list">${treatmentsHTML}</div>
                    </div>
                `;

                serviceCategories.style.display = 'none';
                serviceDetailsContainer.innerHTML = detailsHTML;
                backButtonText.textContent = "Back to Services";
                backButton.href = "#"; // Disable home page link
                
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        }
    });

    backButton.addEventListener('click', function(event) {
        if (backButtonText.textContent === "Back to Services") {
            event.preventDefault();
            serviceCategories.style.display = 'flex';
            serviceDetailsContainer.innerHTML = '';
            backButtonText.textContent = "Back to Home";
            backButton.href = "index.php"; // Enable home page link
            backButton.style.display = 'block';

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    });
});