@extends('layouts.user')
@section('title', 'View Student')

@section('content')
<h1 class="mt-4">Student Violation List</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Student Violation List</li>
</ol>
@if (session('success'))
<div id="success-alert" class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif
<div class="card card-mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Violations Student View
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
            <tbody>
                @foreach ($violations as $violation)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$violation->student->id_no ?? 'N/A'}}</td>
                    <td>{{$violation->student ? $violation->student->last_name . ', ' . $violation->student->first_name : 'N/A'}}</td>
                    <td>{{$violation->course->course_name ?? 'N/A'}}</td>
                    <td>{{$violation->year->year_name ?? 'N/A'}}</td>
                    <td>{{$violation->semester->semester_name ?? 'N/A'}}</td>
                    <td>{{$violation->school_year->school_year_name ?? 'N/A'}}</td>
                    <td>{{$violation->violationType->violation_type_name ?? 'N/A'}}</td>
                    <td>{{ $violation->violations_level }}</td>
                    <td>{{$violation->remarks}}</td>
                    <td>{{$violation->violations_date}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        const successAlert = $('#success-alert');
        if (successAlert.length) {
            setTimeout(function() {
                successAlert.fadeOut();
            }, 3000);
        }
    });
</script>


@endsection