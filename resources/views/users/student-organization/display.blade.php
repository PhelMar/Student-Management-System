@extends('layouts.user')
@section('title', 'View Student Organization')

@section('content')
<h1 class="mt-4">Student Organization List</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Student Organization List</li>
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
    <a class="btn btn-primary btn-auto shadow" href="{{ route('user.organizations.create') }}">
        <i class="fa fa-user-plus me-2"></i> Add
    </a>
</div>

<div class="card card-mb-4 shadow">
    <div class="card-header text-white" style="background-color: #0A7075">
        <i class="fas fa-table me-1"></i>
        Organizations Student View
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
                    <th>ORGANIZATIONS</th>
                    <th>POSITIONS</th>
                    <th>DATE</th>
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
                    <th>ORGANIZATIONS</th>
                    <th>POSITIONS</th>
                    <th>DATE</th>
                </tr>
            </tfoot>
            <tbody>
            </tbody>
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
                url: "{{ route('user.organizations.display') }}",
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
    });
</script>
@endsection