@extends('layouts.admin')
@section('title', 'View Student')

@section('content')
<h1 class="mt-4">Student Violation List</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Student Violation List</li>
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
    <a class="btn btn-primary btn-auto" href="{{ route('admin.violations.create') }}">
        <i class="fas fa-plus me-2"></i>Add Violations</a>
</div>
<div class="card shadow mb-4">
    <div class="card-header text-white" style="background-color: #0A7075">
        <i class="fas fa-table me-1"></i> Violations Student View
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
                    <th>VIOLATIONS</th>
                    <th>VIOLATIONS LEVEL</th>
                    <th>REMARKS</th>
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
                    <th>VIOLATIONS</th>
                    <th>VIOLATIONS LEVEL</th>
                    <th>REMARKS</th>
                    <th>DATE</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#dataTables').DataTable({
            scrollX: true,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.violations.display') }}",
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
                    data: 'violation_type_name'
                },
                {
                    data: 'violations_level',
                    render: function(data, type, row) {
                        let color = '';
                        if (data === 1) color = 'yellow';
                        else if (data === 2) color = 'orange';
                        else if (data >= 3) color = 'red';

                        return `
                    <div style="width: 100%; background-color: #e9ecef; border-radius: 4px; overflow: hidden; position: relative; height: 20px;">
                        <div style="width: ${data * 33}%; background-color: ${color}; height: 100%; border-radius: 4px;"></div>
                    </div>`;
                    }
                },
                {
                    data: 'remarks'
                },
                {
                    data: 'violations_date',
                    render: function(data, type, row) {
                        if (data) {
                            const date = new Date(data);
                            return date.toLocaleDateString('en-US', {
                                month: 'short',
                                day: '2-digit',
                                year: 'numeric'
                            }).replace(',', '');
                        }
                        return 'N/A';
                    }
                },
            ],
            dom: '<"d-flex justify-content-between"lf>rt<"d-flex justify-content-between"ip>',
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [
                [10, 'desc']
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search violations..."
            }

        });

        $('#sidebarToggle').on('click', function() {
            setTimeout(function() {
                table.columns.adjust().draw();
            }, 300);
        });
    });
</script>
@endsection