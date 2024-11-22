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
        <table id="datatablesSimple">
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
                @foreach ($pwdData as $pwddata)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$pwddata->last_name}}</td>
                    <td>{{$pwddata->first_name}}</td>
                    <td>{{$pwddata->course->course_name}}</td>
                    <td>{{$pwddata->year->year_name}}</td>
                    <td>{{$pwddata->semester->semester_name}}</td>
                    <td>{{$pwddata->school_year->school_year_name}}</td>
                    <td>{{$pwddata->pwd_remarks}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
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