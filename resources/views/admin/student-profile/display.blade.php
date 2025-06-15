@extends('layouts.admin')
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
        <div class="mx-2">
            <a href="#" 
            class="btn btn-primary openStudentReportModal" 
            data-route="{{ route('admin.students.print') }}"
            data-bs-toggle="modal" 
            data-bs-target="#reportStudentModal">
            <i class="fas fa-file-alt me-2"></i>Print
        </a>
        </div>
    <div class="dropdown me-2">
        <button class="btn btn-success dropdown-toggle shadow" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="fa fa-file-alt me-2"></i> Generate Reports
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <!-- Income Basis Report -->
            <li>
                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportModal">
                <i class="fas fa-users me-2"></i> Total Students
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="{{route('admin.incomeFirstReport.display')}}">
                    <i class="fa fa-pound-sign me-2"></i> <span>&#8369;</span> Income Basis
                </a>
            </li>

            <!-- PWD Report -->
            <li>
                <a class="dropdown-item" href="{{route('admin.students.pwddisplay')}}">
                    <i class="fa fa-wheelchair me-2"></i> PWD Report
                </a>
            </li>

            <!-- IP's Report -->
            <li>
                <a class="dropdown-item" href="{{route('admin.students.ipsdisplay')}}">
                    <i class="fa fa-users me-2"></i> IP's Report
                </a>
            </li>

            <!-- Solo Parent Report -->
            <li>
                <a class="dropdown-item" href="{{route('admin.students.soloparentdisplay')}}">
                    <i class="fa fa-female me-2"></i> Solo Parent Report
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="{{route('admin.students.fourpsdisplay')}}">
                    <i class="fa fa-users"></i> 4p's Student Report
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{route('admin.students.scholardisplay')}}">
                    <i class="fas fa-user-graduate"></i> Scholar Student Report
                </a>
            </li>
            <li>
                <a class="dropdown-item text-danger" href="{{route('admin.students.dropView')}}">
                    <i class="fa fa-user-times me-2" style="color: red;"></i> Dropped Student
                </a>
            </li>
        </ul>
    </div>

    <a class="btn btn-primary btn-auto shadow" href="{{ route('admin.students.create') }}">
        <i class="fas fa-user-plus me-2"></i> Add Students
    </a>
</div>

<!--Print Student Modal-->
<div class="modal fade" id="reportStudentModal" tabindex="-1" aria-labelledby="reportStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="reportStudentForm" method="GET" target="_self">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalLabel">Print Student Records</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="mb-3">
                        <label for="course" class="form-label">Course</label>
                        <select class="form-control" id="course" name="course" required>
                            <option value="" selected disabled>Select Course</option>
                            @foreach ($courses as $course)
                            <option value="{{$course->id}}">{{$course->course_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year Level</label>
                        <select class="form-control" id="year" name="year" required>
                            <option value="" selected disabled>Select Year Level</option>
                            @foreach ($years as $year)
                            <option value="{{$year->id}}">{{$year->year_name}}</option>
                            @endforeach
                        </select>
                    </div>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="action" value="print" class="btn btn-success" onclick="openInNewTab(event)">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Generate Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <form id="reportForm" action="{{ route('admin.generateReport') }}" method="GET" target="_self">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reportModalLabel">Generate Student Report</h5>
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
          <button type="submit" name="action" value="print" class="btn btn-success" onclick="openInNewTab(event)">
            <i class="fas fa-print"></i> Print
        </button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
    function openInNewTab(e) {
        const form = document.getElementById('reportForm');
        form.target = '_blank';
    }
</script>


<div class="card card-mb-4 shadow">
    <div class="card-header text-white" style="background-color: #0A7075">
        <i class="fas fa-table me-1"></i>
        Student View
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
            url: "{{ route('admin.students.display') }}",
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
                    <a href="{{ url('admin/students') }}/${data}" class="dropdown-item">
                        <i class="fa fa-eye me-2"></i> View
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/edit') }}/${data}" class="dropdown-item">
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
    $('#sidebarToggle').on('click', function() {
        setTimeout(function() {
            table.columns.adjust().draw();
        }, 300);
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
            window.location.href = "{{ url('admin/students/drop') }}/" + studentId;
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.openStudentReportModal');
        const form = document.getElementById('reportStudentForm');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const route = this.getAttribute('data-route');
                form.setAttribute('action', route);
                form.setAttribute('target', '_self');
            });
        });

        window.openInNewTab = function (e) {
            const form = document.getElementById('reportStudentForm');
            form.setAttribute('target', '_blank');
        };
    });
</script>
@endsection