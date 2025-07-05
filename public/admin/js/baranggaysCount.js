function fetchBarangaySummary(municipalityId) {
    $.ajax({
        url: countmunicipalBarangayCountsDataUrl,
        type: "GET",
        data: { municipality_id: municipalityId },
        success: function (response) {
            let summaryHtml = '<strong>Barangay Totals:</strong> ';
            if (Object.keys(response).length === 0) {
                summaryHtml += 'No data available.';
            } else {
                summaryHtml += Object.entries(response).map(([brgy, count]) => {
                    return `${brgy ?? 'Unknown'} — ${count}`;
                }).join(', ');
            }
            $('#barangaySummary').html(summaryHtml);
        },
        error: function () {
            $('#barangaySummary').html('<span class="text-danger">Error fetching barangay totals.</span>');
        }
    });
}

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const table = $('#studentsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        ajax: {
            url: municipalStudentListDataUrl,
            type: "GET",
            data: function (d) {
                d.municipality_id = municipalityId;
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'students_name' },
            { data: 'course_name', defaultContent: 'N/A' },
            { data: 'year_name', defaultContent: 'N/A' },
            { data: 'semester_name', defaultContent: 'N/A' },
            { data: 'school_year_name', defaultContent: 'N/A' },
            { data: 'barangay_name', defaultContent: 'N/A' },
        ],
        dom: '<"d-flex justify-content-between"lf>rt<"d-flex justify-content-between"ip>',
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        order: [[2, 'asc']],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search students..."
        },
        drawCallback: function() {
            fetchBarangaySummary(municipalityId);
        }
    });

    $('#sidebarToggle').on('click', function() {
        setTimeout(function() {
            table.columns.adjust().draw();
        }, 300);
    });

    fetchBarangaySummary(municipalityId);
});
