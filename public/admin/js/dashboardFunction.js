
$(document).ready(function () {
    function countPWDStudents() {
        $.ajax({
            url: countPWDUrl,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#pwd-count').text(response.count);
            },
            error: function (xhr) {
                console.error("AJAX error:", xhr);
            }
        });
    }

    function countSoloParentStudents() {
        $.ajax({
            url: countSoloParentUrl,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#solo-parent-count').text(response.count)
            },
            error: function (xhr) {
                console.error("AJAX error:", xhr);
            }
        });
    }

    function countIpsStudents() {
        $.ajax({
            url: countIpsUrl,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#ips-count').text(response.count)
            },
            error: function (xhr) {
                console.error("AJAX error:", xhr);
            }
        });
    }

    function fetchMunicipalityStudentCounts() {
        const columnColors = ['bg-primary', 'bg-warning', 'bg-success', 'bg-secondary']; // Colors for each column

        $.ajax({
            url: countByMunicipalDataUrl,
            method: 'GET',
            success: function (response) {
                $('#municipality-cards-container').empty().append('<div class="row"></div>');

                // Loop through the response and generate cards
                response.forEach(function (municipality, index) {
                    if (municipality.count > 0) {
                        const colorClass = columnColors[index % columnColors.length];

                        let card = `
                            <div class="col-xl-3 col-md-6 mb-4"> <!-- Grid column -->
                                <div class="card ${colorClass} text-white shadow">
                                    <div class="card-body">
                                        <h5">FROM MUNICIPALITY OF ${municipality.municipality}</h5>
                                        <p class="card-text">Total Students: ${municipality.count}</p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        `;

                        $('#municipality-cards-container .row').append(card);
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", error);
            }
        });
    }



    countPWDStudents();
    countSoloParentStudents();
    countIpsStudents();
    countActiveStudents();
    fetchMunicipalityStudentCounts();
});

function countActiveStudents() {
    $.ajax({
        url: countTotalStudents,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('#active-count').text(response.count);
        },
        error: function (xhr) {
            console.error("AJAX error:", xhr);
        }
    });
}






