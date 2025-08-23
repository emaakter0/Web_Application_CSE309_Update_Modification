document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('appointmentForm');
    const successMessageModal = document.getElementById('successMessage');
    const closeBtn = document.querySelector('.close-btn');
    const bookedDetails = document.getElementById('bookedDetails');

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        // নতুন ইনপুট ফিল্ডগুলোর ডেটা সংগ্রহ করা হয়েছে
        const petParentsName = document.getElementById('petParentsName').value;
        const email = document.getElementById('email').value;
        const phoneNumber = document.getElementById('phoneNumber').value;

        const petName = document.getElementById('petName').value;
        
        const petAgeYear = document.getElementById('petAgeYear').value;
        const petAgeMonth = document.getElementById('petAgeMonth').value;
        const petAgeDay = document.getElementById('petAgeDay').value;
        
        let petAge = '';
        if (petAgeYear) petAge += `${petAgeYear} Years `;
        if (petAgeMonth) petAge += `${petAgeMonth} Months `;
        if (petAgeDay) petAge += `${petAgeDay} Days`;
        if (petAge === '') petAge = 'Not specified';

        const petType = document.getElementById('petType').value;
        const problem = document.getElementById('problemDescription').value;
        const oldTreatment = document.getElementById('oldTreatment').value;
        const doctorName = document.getElementById('doctorName').value;
        const date = document.getElementById('appointmentDate').value;
        const time = document.getElementById('appointmentTime').value;

        bookedDetails.innerHTML = `
            <p><strong>Pet Parent's Name:</strong> ${petParentsName}</p>
            <p><strong>Email:</strong> ${email}</p>
            <p><strong>Phone Number:</strong> ${phoneNumber}</p>
            
            <p><strong>Pet Name:</strong> ${petName}</p>
            <p><strong>Pet Age:</strong> ${petAge}</p>
            <p><strong>Pet Type:</strong> ${petType}</p>
            <p><strong>Problem:</strong> ${problem}</p>
            <p><strong>Old Treatment:</strong> ${oldTreatment || 'None'}</p>
            <p><strong>Doctor:</strong> ${doctorName}</p>
            <p><strong>Date:</strong> ${date}</p>
            <p><strong>Time:</strong> ${time}</p>
        `;

        successMessageModal.style.display = 'block';

        form.reset();
    });

    closeBtn.addEventListener('click', () => {
        successMessageModal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === successMessageModal) {
            successMessageModal.style.display = 'none';
        }
    });
});