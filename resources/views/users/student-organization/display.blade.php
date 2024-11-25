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
        <table id="datatablesSimple">
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
                @foreach ($organizationData as $organizations)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$organizations->student->id_no ?? 'N/A'}}</td>
                    <td>{{$organizations->student ? $organizations->student->last_name . ', ' . $organizations->student->first_name : 'N/A'}}</td>
                    <td>{{$organizations->course->course_name ?? 'N/A'}}</td>
                    <td>{{$organizations->year->year_name ?? 'N/A'}}</td>
                    <td>{{$organizations->semester->semester_name ?? 'N/A'}}</td>
                    <td>{{$organizations->school_year->school_year_name ?? 'N/A'}}</td>
                    <td>{{$organizations->organizationType->organization_name ?? 'N/A'}}</td>
                    <td>{{$organizations->position->positions_name ?? 'N/A'}}</td>
                    <td>{{$organizations->organization_date}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>

</script>


@endsection