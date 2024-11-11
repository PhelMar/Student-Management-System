@extends('layouts.admin')
@section('title', 'Add Student Organization')

@section('content')
<h1 class="mt-4">Add Students Organization</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Add Students Organization</li>
</ol>
@if (session('success'))
<div id="success-alert" class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif
<div class="card">
    <div class="card-header bg-secondary text-white">Student Organization</div>
    <div class="card-body">
        <form action="{{ route('admin.organizations.store') }}" method="post" id="addStudentOrganizationForm">
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
                        <label for="" class="form-label">Organizations</label>
                        <select name="organization_types_id" id="organization_types_id" class="form-control @error('organization_types_id') is-invalid @enderror">
                            <option value="" disabled selected>Select Organization</option>
                            @foreach ($organizationTypes as $organizations)
                            <option value="{{$organizations->id}}">{{$organizations->organization_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">Position</label>
                        <select name="positions_id" id="positions_id" class="form-control @error('positions_id') is-invalid @enderror">
                            <option value="" disabled selected>Select Position</option>
                            @foreach ($positions as $position)
                            <option value="{{$position->id}}">{{$position->positions_name}}</option>
                            @endforeach
                        </select>
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
                            <input type="date" class="form-control @error('organization_date') is-invalid @enderror" name="organization_date" id="organization_date">
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
                url: '/admin/get-student', // Adjust this URL based on your route
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
                        $('#organization_types_id').val('');
                        $('#positions_id').val('');

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
                $('#addStudentOrganizationForm')[0].reset();
            }, 3000);
        }
    });
</script>
@endsection