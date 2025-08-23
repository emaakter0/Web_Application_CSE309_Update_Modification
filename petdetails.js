document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('petDetailsForm');
    const petDetailsDiv = document.getElementById('petDetails');
    const editButton = document.getElementById('editPetDetails');

    // Load pet details from local storage on page load
    loadPetDetails();

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        savePetDetails();
    });

    editButton.addEventListener('click', function() {
        toggleForm(true);
    });

    function savePetDetails() {
        const petName = document.getElementById('petName').value;
        const petBreed = document.getElementById('petBreed').value;
        const petAge = document.getElementById('petAge').value;
        const petWeight = document.getElementById('petWeight').value;

        const petDetails = {
            name: petName,
            breed: petBreed,
            age: petAge,
            weight: petWeight
        };

        localStorage.setItem('petDetails', JSON.stringify(petDetails));
        alert('Pet details saved successfully!');
        loadPetDetails();
        toggleForm(false);
    }

    function loadPetDetails() {
        const petDetails = JSON.parse(localStorage.getItem('petDetails'));

        if (petDetails) {
            document.getElementById('petNameDisplay').innerText = petDetails.name;
            document.getElementById('petBreedDisplay').innerText = petDetails.breed;
            document.getElementById('petAgeDisplay').innerText = petDetails.age;
            document.getElementById('petWeightDisplay').innerText = petDetails.weight;
            
            // Set form values for editing
            document.getElementById('petName').value = petDetails.name;
            document.getElementById('petBreed').value = petDetails.breed;
            document.getElementById('petAge').value = petDetails.age;
            document.getElementById('petWeight').value = petDetails.weight;

            petDetailsDiv.classList.remove('hidden');
            form.classList.add('hidden');
            editButton.classList.remove('hidden');
        } else {
            petDetailsDiv.classList.add('hidden');
            form.classList.remove('hidden');
            editButton.classList.add('hidden');
        }
    }

    function toggleForm(show) {
        if (show) {
            form.classList.remove('hidden');
            petDetailsDiv.classList.add('hidden');
            editButton.classList.add('hidden');
        } else {
            form.classList.add('hidden');
            petDetailsDiv.classList.remove('hidden');
            editButton.classList.remove('hidden');
        }
    }
});
