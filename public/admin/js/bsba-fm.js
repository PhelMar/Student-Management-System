document.getElementById('printButton4').addEventListener('click', function () {
    const printWindow = window.open('', '', 'width=800,height=600');
    const tableContent = document.querySelector('#datatablesSimple4').outerHTML;

    // Calculate total students based on number of rows
    const rows = document.querySelectorAll('#datatablesSimple4 tbody tr');
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
                    display: flex; /* Use flexbox to align logo and text */
                    justify-content: center; /* Center content horizontally */
                    align-items: center; /* Vertically align items */
                }
                .header img {
                    height: 85px; /* Set the height of the logo */
                    width: auto; /* Maintain aspect ratio */
                    margin-right: 15px; /* Space between logo and text */
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
                <img src="/images/lccLogo.png" alt="School Logo"> <!-- School logo -->
                <div>
                    <h2>Legacy College of Compostela, Inc.</h2>
                    <p>Purok 2 Dagohoy St. Poblacion Compostela</p>
                    <p>Quality Education Within Reach</p>
                    <p>BSBA FM Cleared Student Clearance List</p>
                </div>
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