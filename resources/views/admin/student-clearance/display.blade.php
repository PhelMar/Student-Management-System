@extends('layouts.admin')
@section('title', 'View Student Clearance')

@section('content')
<h1 class="mt-4">Clearance Student List</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Clearance Student List</li>
</ol>
@if (session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: 'Success!',
            text: "{{session('success')}}",
            icon: 'success',
            confirmButtonText: 'OK',
            timer: 1200
        });
    });
</script>
@endif
<div class="d-flex justify-content-end mb-3">
    <a class="btn btn-success btn-auto me-2 shadow" href="{{route('admin.clearedStudentDisplay.display')}}">
        <i class="fa fa-file-alt me-2"></i>View Cleared Clearance</a>
    <a class="btn btn-primary btn-auto shadow" href="{{ route('admin.clearance.create') }}">
        <i class="fa fa-user-plus me-2"></i> Add
    </a>
</div>
<div class="card card-mb-4 shadow">
    <div class="card-header text-white" style="background-color: #0A7075">
        <i class="fas fa-table me-1"></i>
        Clearance Student View
    </div>
    <div class="card-body">
        <table id="dataTables" class="table table-striped table-hover table-bordered table-responsive">
            <thead>
                <tr>
                    <th>CONTROL NO</th>
                    <th>NAME</th>
                    <th>COURSE</th>
                    <th>YEAR LEVEL</th>
                    <th>SEMESTER</th>
                    <th>SCHOOL YEAR</th>
                    <th>STATUS</th>
                    <th>DATE RELEASED</th>
                    <th>DATE CLEARED</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>CONTROL NO</th>
                    <th>NAME</th>
                    <th>COURSE</th>
                    <th>YEAR LEVEL</th>
                    <th>SEMESTER</th>
                    <th>SCHOOL YEAR</th>
                    <th>STATUS</th>
                    <th>DATE RELEASED</th>
                    <th>DATE CLEARED</th>
                    <th>ACTION</th>
                </tr>
            </tfoot>
            <tbody></tbody>
        </table>
    </div>
</div>

<script>
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
                url: "{{ route('admin.clearance.display') }}",
                type: "GET",
            },
            columns: [{
                    data: 'control_no'
                },
                {
                    data: 'student_name'
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
                    data: 'status'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'updated_at'
                },
                {
                    data: 'action'
                },
            ],
            columnDefs: [{
                targets: -1, // Action column
                data: 'action',
                render: function(data, type, row) {
                    if (row.status !== 'cleared') {
                        return `<a href="javascript:void(0)" class="btn btn-warning" onclick="confirmCleared('${row.id}')">
                            <i class="fas fa-check-circle"></i> Cleared
                        </a>`;
                    } else {
                        return '<button class="btn btn-secondary" disabled><i class="fas fa-check"></i> Cleared</button>';
                    }
                }
            }],
            dom: '<"d-flex justify-content-between"lf>rt<"d-flex justify-content-between"ip>',
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [
                [10, 'desc']
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search students..."
            }
        });

        $('#sidebarToggle').on('click', function() {
            setTimeout(function() {
                table.columns.adjust().responsive.recalc();
            }, 300);
        });
    });


    function confirmCleared(clearanceId) {
        Swal.fire({
            title: 'Is this student cleared?',
            text: "Make sure to check if all signatures are complete!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, clear the student!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ url('admin/clearance/cleared') }}/" + clearanceId, {
                        method: 'get',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            Swal.fire({
                                title: 'Cleared!',
                                text: data.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                            location.reload();
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue clearing the student.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>
@endsection