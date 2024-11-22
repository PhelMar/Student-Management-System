@extends('layouts.guard')
@section('title', 'Add Student Violation')

@section('content')
<h1 class="mt-4">Add Students Violation</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Add Students Violation</li>
</ol>
@if (session('success'))
<div id="success-alert" class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif
<div class="card shadow">
    <div class="card-header text-white" style="background-color: #0A7075">Student Violation</div>
    <div class="card-body">
        <form action="{{ route('guard.violations.store') }}" method="post" id="addStudentViolationForm">
            @csrf
            <div class="row">
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="" class="form-label">ID NO</label>
                        <input type="text" class="form-control @error('student_id') is-invalid @enderror" name="student_id" id="student_id">
                        <div id="error-message"></div>
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">Violations</label>
                        <select name="violations_type_id" id="violations_type_id" class="form-control @error('violations_type_id') is-invalid @enderror">
                            <option value="" disabled selected>Select Violation</option>
                            @foreach ($violationsType as $violations)
                            <option value="{{$violations->id}}">{{$violations->violation_type_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">Remarks</label>
                        <textarea class="form-control" name="remarks" id="remarks" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <div class="mb-4">
                            <label for="" class="form-label">Course</label>
                            <input type="text" class="form-control" name="course_name" id="course_name" readonly>
                            <input class="form-control" name="course_id" id="course_id" type="hidden">
                        </div>
                        <div class="mb-4">
                            <label for="" class="form-label">Year</label>
                            <input type="text" class="form-control" name="year_name" id="year_name" readonly>
                            <input class="form-control" name="year_id" id="year_id" type="hidden">
                        </div>
                        <div class="mb-4">
                            <label for="" class="form-label">Semester</label>
                            <input type="text" class="form-control" name="semester_name" id="semester_name" readonly>
                            <input class="form-control" name="semester_id" id="semester_id" type="hidden">
                        </div>
                        <div class="mb-4">
                            <label for="" class="form-label">School Year</label>
                            <input type="text" class="form-control" name="school_year_name" id="school_year_name" readonly>
                            <input class="form-control" name="school_year_id" id="school_year_id" type="hidden">
                        </div>
                        <div class="mb-4">
                            <label for="" class="form-label">Pick Date</label>
                            <input type="date" class="form-control @error('violations_date') is-invalid @enderror" name="violations_date" id="violations_date">
                        </div>
                        
                    </div>
                </div>
                <button class="btn btn-primary ms-auto d-block w-25 btn-md">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#student_id').on('change', function() {
            const id_no = $(this).val();

            $.ajax({
                url: '/guard/get-student', // Adjust this URL based on your route
                method: 'GET',
                data: {
                    id_no: id_no
                },
                success: function(response) {
                    $('#error-message').text('');

                    $('#first_name').val(response.student.first_name);
                    $('#last_name').val(response.student.last_name);
                    $('#course_name').val(response.student.course.course_name);
                    $('#year_name').val(response.student.year.year_name);
                    $('#semester_name').val(response.student.semester.semester_name);
                    $('#school_year_name').val(response.student.school_year.school_year_name);

                    $('#course_id').val(response.student.course_id);
                    $('#year_id').val(response.student.year_id);
                    $('#semester_id').val(response.student.semester_id);
                    $('#school_year_id').val(response.student.school_year_id);
                },
                error: function(xhr) {
                    if (xhr.status === 404) {
                        $('#error-message').text(xhr.responseJSON.message).css('color', 'red');

                        $('#first_name').val('');
                        $('#last_name').val('');
                        $('#course_name').val('');
                        $('#year_name').val('');
                        $('#semester_name').val('');
                        $('#school_year_name').val('');
                        $('#remarks').val('');

                        $('#course_id').val('');
                        $('#year_id').val('');
                        $('#semester_id').val('');
                        $('#school_year_id').val('');
                    }
                }
            });
        });
    });


    $(document).ready(function() {
        const successAlert = $('#success-alert');
        if (successAlert.length) {
            setTimeout(function() {
                successAlert.fadeOut();
                $('#addStudentViolationForm')[0].reset();
            }, 3000);
        }
    });
</script>
@endsection