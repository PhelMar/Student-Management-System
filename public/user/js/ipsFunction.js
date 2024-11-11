document.getElementById('school_year_id').addEventListener('change', function () {
    var schoolYearId = this.value;

    if (schoolYearId) {
        fetch(`/user/get-students/${schoolYearId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                const tbody = document.querySelector('#datatablesSimple tbody');
                tbody.innerHTML = '';

                data.forEach((student, index) => {
                    const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${student.last_name}</td>
                        <td>${student.first_name}</td>
                        <td>${student.course.course_name}</td>
                        <td>${student.year.year_name}</td>
                        <td>${student.semester.semester_name}</td>
                        <td>${student.school_year.school_year_name}</td>
                        <td>${student.ips_remarks}</td>
                    </tr>
                `;
                    tbody.innerHTML += row;
                });
            })
            .catch(error => {
                console.error('Error fetching students:', error);
            });
    }
});

document.getElementById('printButton').addEventListener('click', function () {
    const printWindow = window.open('', '', 'width=800,height=600');
    const tableContent = document.querySelector('#datatablesSimple').outerHTML;

    // Calculate total students based on number of rows
    const rows = document.querySelectorAll('#datatablesSimple tbody tr');
    const totalStudents = rows.length; // Count total number of students

    printWindow.document.write(`
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0; /* Reset default body margin */
                    padding: 20px; /* Add padding around the body */
                }
                .header {
                    text-align: center;
                    margin: 0; /* Remove default margin for header */
                    padding: 10px 0; /* Add a small amount of padding for spacing */
                }
                h2 {
                    margin: 5px 0; /* Adjust the margin for the heading */
                    padding: 0; /* Remove padding */
                }
                p {
                    margin: 2px 0; /* Adjust the margin for paragraphs */
                    padding: 0; /* Remove padding */
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px; /* Space between header and table */
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                .total {
                    font-weight: bold;
                    text-align: right; /* Align total to the right */
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>Legacy College of Compostela, Inc.</h2>
                <p>Purok 2 Dagohoy St. Poblacion Compostela</p>
                <p>Quality Education Within Reach</p>
                <p>Students List for ${document.getElementById('school_year_id').selectedOptions[0].text}</p>
            </div>
            ${tableContent}
            <table>
                <tr>
                    <td class="total">Total Students:</td>
                    <td class="total">${totalStudents}</td>
                </tr>
            </table>
        </body>
        </html>
    `);

    printWindow.document.close();

    printWindow.onload = function () {
        printWindow.print();
        printWindow.close();
    };
});


