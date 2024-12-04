let between10to20ThousandTable;

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    between10to20ThousandTable = $('#between10to20ThousandTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        ajax: {
            url: between10to20Thousand,
            type: "GET",
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'student_name' },
            { data: 'course_name', defaultContent: 'N/A' },
            { data: 'year_name', defaultContent: 'N/A' },
            { data: 'school_year_name', defaultContent: 'N/A' },
        ],
        dom: '<"d-flex justify-content-between"lf>rt<"d-flex justify-content-between"ip>',
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        order: [[1, 'asc']],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search students...",
        },
    });

    $('#sidebarToggle').on('click', function () {
        setTimeout(function () {
            between10to20ThousandTable.columns.adjust().draw();
        }, 300);
    });

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
        if ($('#between10to20ThousandTable').is(':visible')) {
            between10to20ThousandTable.columns.adjust().draw();
        }
    });
});
