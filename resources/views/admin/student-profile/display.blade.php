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
            text: "{{session('success')}}",
            icon: 'success',
            confirmButtonText: 'OK',
            timer: 1200
        });
    });
</script>
@endif

<div class="d-flex justify-content-end mb-3">
    <div class="dropdown me-2">
        <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-file-alt me-2"></i> Generate Reports
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <!-- Income Basis Report -->
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
        </ul>
    </div>

    <a class="btn btn-primary btn-auto" href="{{ route('admin.students.create') }}">
        <i class="fa fa-user-plus me-2"></i> Add Students
    </a>
</div>


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
                    <td>
                        <div class="dropdown">
                            <!-- Dropdown button with an icon and color -->
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{$student->id}}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-cogs"></i> Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$student->id}}">
                                <li>
                                    <a href="{{route('admin.students.show', $student->id)}}" class="dropdown-item">
                                        <i class="fa fa-eye me-2"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.students.edit', $student->id)}}" class="dropdown-item">
                                        <i class="fa fa-pencil me-2"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" onclick="confirmDrop('{{ $student->id }}')" class="dropdown-item text-danger">
                                        <i class="fa fa-trash me-2"></i> Drop
                                    </a>
                                </li>
                            </ul>
                        </div>
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
</script>
@endsection