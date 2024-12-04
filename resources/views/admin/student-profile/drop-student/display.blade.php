@extends('layouts.admin')
@section('title', 'Dropped Students')

@section('content')
<h1 class="mt-4">Dropped Students</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item active">Dropped Students</li>
</ol>

@if (session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK',
            timer: 1200
        });
    });
</script>
@endif

<div class="d-flex justify-content-end mb-3">
    <button onclick="goBack()" class="btn btn-primary shadow">Go Back</button>
</div>

<div class="card card-mb-4 shadow">
    <div class="card-header text-white" style="background-color: #0A7075">
        <i class="fas fa-table me-1"></i>
        Dropped Students
    </div>
    <div class="card-body">
        <table id="dataTables" class="table table-striped table-hover table-bordered table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID NO</th>
                    <th>NAME</th>
                    <th>COURSE</th>
                    <th>YEAR LEVEL</th>
                    <th>SEMESTER</th>
                    <th>SCHOOL YEAR</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
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
                url: "{{ route('admin.students.dropView') }}",
                type: "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'id_no',
                    defaultContent: 'N/A'
                },
                {
                    data: 'name',
                    defaultContent: 'N/A'
                },
                {
                    data: 'course_name',
                    defaultContent: 'N/A'
                },
                {
                    data: 'year_name',
                    defaultContent: 'N/A'
                },
                {
                    data: 'semester_name',
                    defaultContent: 'N/A'
                },
                {
                    data: 'school_year_name',
                    defaultContent: 'N/A'
                },
                {
                    data: 'hashed_id',
                    render: function(data, type, row) {
                        return `
                            <a href="javascript:void(0)" onclick="confirmActivate('${data}')" class="btn btn-success">
                                <i class="fa fa-check me-2"></i> Activate
                            </a>
                        `;
                    }
                }
            ],
            dom: '<"d-flex justify-content-between"lf>rt<"d-flex justify-content-between"ip>',
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [
                [0, 'desc']
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search students..."
            }
        });
        $('#sidebarToggle').on('click', function() {
            setTimeout(function() {
                table.columns.adjust().draw();
            }, 300);
        });
    });

    function confirmActivate(studentId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This student will be activated.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, activate student!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('admin.students.active', ':hashId') }}".replace(':hashId', studentId);
            }
        });
    }


    function goBack() {
        window.history.back();
    }
</script>
@endsection