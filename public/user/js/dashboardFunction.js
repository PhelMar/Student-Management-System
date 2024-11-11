
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

    countPWDStudents();
    countSoloParentStudents();
    countIpsStudents();
    countActiveStudents();

    setInterval(function () {
        countPWDStudents();
        countSoloParentStudents();
        countIpsStudents();
        countActiveStudents();
    }, 5000);
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

