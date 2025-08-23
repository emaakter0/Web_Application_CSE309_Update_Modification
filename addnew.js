document.getElementById('addNewReportForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Get form values
    const reportName = document.getElementById('reportName').value;
    const reportDate = document.getElementById('reportDate').value;
    const reportFile = document.getElementById('reportFile').files[0];

    // Read the file as a data URL (Base64)
    const reader = new FileReader();
    reader.onload = function(e) {
        const fileContent = e.target.result;

        // Create a new report object
        const newReport = {
            id: Date.now(), // Unique ID for each report
            name: reportName,
            date: reportDate,
            file: fileContent,
            fileName: reportFile.name
        };

        // Get existing reports from local storage or create an empty array
        const reports = JSON.parse(localStorage.getItem('medicalReports')) || [];
        
        // Add the new report to the array
        reports.push(newReport);
        
        // Save the updated array back to local storage
        localStorage.setItem('medicalReports', JSON.stringify(reports));

        // Redirect back to the main dashboard
        window.location.href = 'Medical_reports_dashboard.html';
    };
    reader.readAsDataURL(reportFile);
});
