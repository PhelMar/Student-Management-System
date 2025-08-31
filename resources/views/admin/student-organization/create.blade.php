@extends('layouts.admin')
@section('title', 'Add Student Organization')

@section('content')
<h1 class="mt-4">Add Students Organization</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Add Students Organization</li>
</ol>
@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function(){
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
<div class="card shadow">
    <div class="card-header text-white" style="background-color: #0A7075">Student Organization</div>
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
    $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#student_id').on('change', function () {
        const id_no = $(this).val().trim();

        if (!id_no) {
            clearStudentFields();
            return;
        }

        $.ajax({
            url: '/admin/get-organization-student',
            method: 'GET',
            data: { id_no: id_no },
            success: function (response) {
                if (response && response.student) {
                    const s = response.student;

                    // student info
                    $('#first_name').val(s.first_name || '');
                    $('#last_name').val(s.last_name || '');

                    // course
                    $('#course_name').val(s.course || '');
                    $('#course_id').val(s.course_id || '');

                    // year
                    $('#year_name').val(s.year || '');
                    $('#year_id').val(s.year_id || '');

                    // semester
                    $('#semester_name').val(s.semester || '');
                    $('#semester_id').val(s.semester_id || '');

                    // school year
                    $('#school_year_name').val(s.school_year || '');
                    $('#school_year_id').val(s.school_year_id || '');
                } else {
                    clearStudentFields();
                    alert('Student not found.');
                }
            },
            error: function () {
                clearStudentFields();
                alert('Error fetching student. Please try again.');
            }
        });
    });

    function clearStudentFields() {
        $('#first_name, #last_name, #course_name, #year_name, #semester_name, #school_year_name').val('');
        $('#course_id, #year_id, #semester_id, #school_year_id').val('');
    }
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