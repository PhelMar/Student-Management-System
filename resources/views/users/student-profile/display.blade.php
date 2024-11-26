@extends('layouts.user')
@section('title', 'View Student')

@section('content')
<h1 class="mt-4">Student List</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item active">Student List</li>
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
    <div class="dropdown me-2">
        <button class="btn btn-success dropdown-toggle shadow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-file-alt me-2"></i> Generate Reports
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <!-- Income Basis Report -->
            <li>
                <a class="dropdown-item" href="{{route('user.incomeFirstReport.display')}}">
                    <i class="fa fa-pound-sign me-2"></i> <span>&#8369;</span> Income Basis
                </a>
            </li>

            <!-- PWD Report -->
            <li>
                <a class="dropdown-item" href="{{route('user.students.pwddisplay')}}">
                    <i class="fa fa-wheelchair me-2"></i> PWD Report
                </a>
            </li>

            <!-- IP's Report -->
            <li>
                <a class="dropdown-item" href="{{route('user.students.ipsdisplay')}}">
                    <i class="fa fa-users me-2"></i> IP's Report
                </a>
            </li>

            <!-- Solo Parent Report -->
            <li>
                <a class="dropdown-item" href="{{route('user.students.soloparentdisplay')}}">
                    <i class="fa fa-female me-2"></i> Solo Parent Report
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{route('user.students.dropView')}}">
                    <i class="fa fa-user-times me-2"></i> Dropped Student
                </a>
            </li>
        </ul>
    </div>

    <a class="btn btn-primary btn-auto shadow" href="{{ route('user.students.create') }}">
        <i class="fa fa-user-plus me-2"></i> Add Students
    </a>
</div>
<div class="card card-mb-4 shadow">
    <div class="card-header text-white" style="background-color: #0A7075">
        <i class="fas fa-table me-1"></i>
        Student View
    </div>
    <div class="card-body">
        <table id="dataTables" class="table table-striped table-bordered">
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
            <tfoot>
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
            </tfoot>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('user.students.display') }}",
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
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton${data}" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-cogs"></i> Actions
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${data}">
                <li>
                    <a href="{{ url('user/students') }}/${data}" class="dropdown-item">
                        <i class="fa fa-eye me-2"></i> View
                    </a>
                </li>
                <li>
                    <a href="{{ url('user/edit') }}/${data}" class="dropdown-item">
                        <i class="fa fa-pencil me-2"></i> Edit
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="confirmDrop('${data}')" class="dropdown-item text-danger">
                        <i class="fa fa-trash me-2"></i> Drop
                    </a>
                </li>
            </ul>
        </div>
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
    });


    function confirmDrop(studentId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, drop student!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ url('user/students/drop') }}/" + studentId;
            }
        });
    }
</script>
@endsection