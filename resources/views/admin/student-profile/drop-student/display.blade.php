@extends('layouts.admin')
@section('title', 'View Student')

@section('content')
<h1 class="mt-4">Dropped Student List</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item active">Dropped Student List</li>
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
    <button onclick="goBack()" class="btn btn-primary mt-1">Go Back</button>
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
                    <th>STUDENT NAME</th>
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
                    <th>STUDENT NAME</th>
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
                    <td>{{$student->first_name}} {{$student->last_name}}</td>
                    <td>{{$student->course->course_name ?? 'N/A'}}</td>
                    <td>{{$student->year->year_name ?? 'N/A'}}</td>
                    <td>{{$student->semester->semester_name ?? 'N/A'}}</td>
                    <td>{{$student->school_year->school_year_name ?? 'N/A'}}</td>
                    <td>
                        <a href="javascript:void(0)" onclick="confirmActivate('{{ $student->id }}')" class="btn btn-success">
                            <i class="fa fa-check me-2"></i> Activate
                        </a>
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

    function confirmActivate(studentId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This student will be activated.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, activate student!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ url('admin/students/active') }}/" + studentId;
            }
        });
    }

    function goBack() {
        window.history.back();
    }
</script>
@endsection