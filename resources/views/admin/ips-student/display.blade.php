@extends('layouts.admin')
@section('title', 'IPs Student')

@section('content')
<h1 class="mt-4">IP's Students List</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">IP's Students List</li>
</ol>
<div class="row justify-content-end align-items-center mb-3">
    <div class="col-sm-auto">
        <a href="#" class="btn btn-primary openReportModal" data-route="{{ route('admin.ips-student.print') }}"
            data-bs-toggle="modal" data-bs-target="#reportModal">
            <i class="fas fa-file-alt me-2"></i>Generate IP's Report
        </a>
    </div>
</div>


<div class="card card-mb-4 shadow">
    <div class="card-header text-white" style="background-color: #0A7075">
        <i class="fas fa-table me-1"></i>
        IP's Students
    </div>
    <div class="card-body">
        <table id="dataTables" class="table table-striped table-hover table-bordered table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>LAST NAME</th>
                    <th>FIRST NAME</th>
                    <th>COURSE</th>
                    <th>YEAR LEVEL</th>
                    <th>SEMESTER</th>
                    <th>SCHOOL YEAR</th>
                    <th>REMARKS</th>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>LAST NAME</th>
                    <th>FIRST NAME</th>
                    <th>COURSE</th>
                    <th>YEAR LEVEL</th>
                    <th>SEMESTER</th>
                    <th>SCHOOL YEAR</th>
                    <th>REMARKS</th>

                </tr>
            </tfoot>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="reportForm" method="GET" target="_self">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Generate IP's Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="school_year_id">School Year:</label>
                        <select name="school_year_id" id="school_year_id" class="form-control" required>
                            <option value="" selected>Select School Year</option>
                            @foreach ($school_year as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="semester">Semester:</label>
                        <select name="semester_id" id="semester_id" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="1st Semester">1st Semester</option>
                            <option value="2nd Semester">2nd Semester</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="action" value="pdf" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> View PDF
                    </button>
                    <button type="submit" name="action" value="print" class="btn btn-success"
                        onclick="openInNewTab(event)">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </form>
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
                url: "{{ route('admin.students.ipsdisplay') }}",
                type: "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'last_name'
                },
                {
                    data: 'first_name'
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
                    data: 'ips_remarks',
                    defaultContent: 'N/A'
                }
            ],
            dom: '<"d-flex justify-content-between"lf>rt<"d-flex justify-content-between"ip>',
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [
                [1, 'asc']
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search IP students..."
            }
        });
        $('#sidebarToggle').on('click', function() {
            setTimeout(function() {
                table.columns.adjust().draw();
            }, 300);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.openReportModal');
        const form = document.getElementById('reportForm');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const route = this.getAttribute('data-route');
                form.setAttribute('action', route);
                form.setAttribute('target', '_self');
            });
        });

        window.openInNewTab = function(e) {
            const form = document.getElementById('reportForm');
            form.setAttribute('target', '_blank');
        };
    });
</script>

@endsection