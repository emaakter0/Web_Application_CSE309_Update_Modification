window.onload = function() {
    // Get the report ID from the URL query parameter
    const urlParams = new URLSearchParams(window.location.search);
    const reportId = urlParams.get('id');

    if (!reportId) {
        // Handle case where no report ID is provided
        document.body.innerHTML = 'Report not found.';
        return;
    }

    // Get all reports from local storage
    const reports = JSON.parse(localStorage.getItem('medicalReports')) || [];

    // Find the specific report
    const report = reports.find(r => r.id.toString() === reportId);

    if (report) {
        // Update the HTML content with the report details
        document.getElementById('reportTitle').innerText = report.name;
        document.getElementById('reportNameText').innerText = report.name;
        document.getElementById('reportNameText2').innerText = report.name;
        document.getElementById('reportDateText').innerText = report.date;

        const reportContentDiv = document.getElementById('reportContent');

        // Check if the file is an image or PDF and display accordingly
        if (report.fileName.match(/\.(jpeg|jpg|png|gif)$/i)) {
            const img = document.createElement('img');
            img.src = report.file;
            img.alt = report.name;
            img.className = "max-w-full h-auto rounded-md";
            reportContentDiv.innerHTML = '';
            reportContentDiv.appendChild(img);
        } else if (report.fileName.match(/\.pdf$/i)) {
            const embed = document.createElement('embed');
            embed.src = report.file;
            embed.type = "application/pdf";
            embed.width = "100%";
            embed.height = "600px";
            reportContentDiv.innerHTML = '';
            reportContentDiv.appendChild(embed);
        } else {
            reportContentDiv.innerHTML = `<p>This file type cannot be displayed: ${report.fileName}</p>`;
        }

    } else {
        document.body.innerHTML = 'Report not found.';
    }
};
