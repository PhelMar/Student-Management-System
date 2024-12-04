$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const table = $('#dataTables').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        ajax: {
            url: organizationUrl,
            type: "GET",
        },
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'id_no'
            },
            {
                data: 'name'
            },
            {
                data: 'course_name'
            },
            {
                data: 'year_name'
            },
            {
                data: 'semester_name'
            },
            {
                data: 'school_year_name'
            },
            {
                data: 'organization_name'
            },
            {
                data: 'position_name'
            },
            {
                data: 'organization_date',
                render: function(data) {
                    const date = new Date(data);
                    return date.toLocaleDateString('en-US', {
                        month: 'short',
                        day: '2-digit',
                        year: 'numeric'
                    }).replace(',', '');
                }
            }
        ],
        dom: '<"d-flex justify-content-between"lf>rt<"d-flex justify-content-between"ip>',
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        order: [
            [9, 'desc']
        ], // Order by the date column (the 9th one)
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search organizations..."
        }
    });
    $('#sidebarToggle').on('click', function() {
        setTimeout(function() {
            table.columns.adjust().draw();
        }, 300);
    });
});