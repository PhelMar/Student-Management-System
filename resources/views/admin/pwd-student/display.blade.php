@extends('layouts.admin')
@section('title', 'PWD Student')

@section('content')
<h1 class="mt-4">PWD Students List</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">PWD Students List</li>
</ol>
@if (session('success'))
<div id="success-alert" class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif
<div class="row justify-content-end align-items-center mb-3">
    <div class="col-sm-4">
        <select name="school_year_id" id="school_year_id" class="form-control">
            <option value="" selected>Select School Year</option>
            @foreach ($school_years as $school_year)
            <option value="{{$school_year->id}}">{{$school_year->school_year_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-auto">
        <a id="printButton" href="{{ route('admin.pwd-student.print') }}" target="_blank" class="btn btn-primary">Print</a>
        <button id="pdfDownload" class="btn btn-success">PDF</button>
    </div>
</div>


<div class="card card-mb-4 shadow">
    <div class="card-header text-white" style="background-color: #0A7075">
        <i class="fas fa-table me-1"></i>
        PWD Students
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
                url: "{{ route('admin.students.pwddisplay') }}",
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
                    data: 'pwd_remarks',
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

    document.getElementById('pdfDownload').addEventListener('click', function() {
        var schoolYearId = document.getElementById('school_year_id').value;
        if (schoolYearId) {
            window.location.href = "{{ route('admin.export.Pwdpdf') }}?school_year_id=" + schoolYearId;
        } else {
            alert("Please select a school year.");
        }
    });

    document.getElementById('printButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default href behavior
        var schoolYearId = document.getElementById('school_year_id').value;
        if (schoolYearId) {
            window.open("{{ route('admin.pwd-student.print') }}?school_year_id=" + schoolYearId);
        } else {
            alert("Please select a school year.");
        }
    });
</script>

@endsection