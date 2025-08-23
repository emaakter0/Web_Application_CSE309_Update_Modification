window.onload = function() {
    // Get the reports container element
    const reportsList = document.getElementById('reportsList');
    
    // Get reports from local storage
    const reports = JSON.parse(localStorage.getItem('medicalReports')) || [];

    if (reports.length > 0) {
        reportsList.innerHTML = ''; // Clear placeholder content

        // Sort reports by date in descending order
        reports.sort((a, b) => new Date(b.date) - new Date(a.date));

        reports.forEach(report => {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item d-flex justify-content-between align-items-center';

            listItem.innerHTML = `
                <div class="d-flex flex-column">
                    <strong>${report.name}</strong>
                    <small class="text-muted">Date: ${report.date}</small>
                </div>
                <a href="view-report.html?id=${report.id}" class="btn btn-sm btn-outline-secondary">View Report</a>
            `;
            reportsList.appendChild(listItem);
        });
    } else {
        reportsList.innerHTML = '<p class="text-center text-muted">No reports found.</p>';
    }
};
