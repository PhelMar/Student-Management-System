@extends('layouts.user')
@section('title', 'View Student')

@section('content')
<h1 class="mt-4">Student List</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Student List</li>
</ol>
@if (session('success'))
<div id="success-alert" class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif
<div class="card card-mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Student View
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID NO</th>
                    <th>FIRST NAME</th>
                    <th>LAST NAME</th>
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
                    <th>FIRST NAME</th>
                    <th>LAST NAME</th>
                    <th>COURSE</th>
                    <th>YEAR LEVEL</th>
                    <th>SEMESTER</th>
                    <th>SCHOOL YEAR</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($students as $display => $student)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$student->id_no}}</td>
                    <td>{{$student->first_name}}</td>
                    <td>{{$student->last_name}}</td>
                    <td>{{$student->course->course_name ?? 'N/A'}}</td>
                    <td>{{$student->year->year_name ?? 'N/A'}}</td>
                    <td>{{$student->semester->semester_name ?? 'N/A'}}</td>
                    <td>{{$student->school_year->school_year_name ?? 'N/A'}}</td>
                    <td class="align-middle">
                        <a href="{{route('user.students.StudentView', $student->id)}}" class="btn btn-info btn-md">View</a>
                        <a href="{{route('user.students.edit', $student->id)}}" class="btn btn-warning btn-md">Edit</a>
                    </td>
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