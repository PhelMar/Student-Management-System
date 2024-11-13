@extends('layouts.admin')
@section('title', 'IPs Student')

@section('content')
<h1 class="mt-4">IP's Students List</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">IP's Students List</li>
</ol>
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
        <button id="printButton" class="btn btn-primary">Print</button>
        <button id="pdfDownload" class="btn btn-success">PDF</button>
    </div>
</div>


<div class="card card-mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        IP's Students
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
                @foreach ($ipsData as $ipsdata)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$ipsdata->last_name}}</td>
                    <td>{{$ipsdata->first_name}}</td>
                    <td>{{$ipsdata->course->course_name}}</td>
                    <td>{{$ipsdata->year->year_name}}</td>
                    <td>{{$ipsdata->semester->semester_name}}</td>
                    <td>{{$ipsdata->school_year->school_year_name}}</td>
                    <td>{{$ipsdata->ips_remarks}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="{{asset('admin/js/ipsFunction.js')}}"></script>
<script>
    document.getElementById('pdfDownload').addEventListener('click', function() {
        var schoolYearId = document.getElementById('school_year_id').value;
        if (schoolYearId) {
            window.location.href = "{{ route('admin.export.IpsPdf') }}?school_year_id=" + schoolYearId;
        } else {
            alert("Please select a school year.");
        }
    });
</script>

@endsection