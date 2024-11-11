@extends('layouts.admin')
@section('title', 'Add Student')

@section('content')
<h1 class="mt-4">Add Students</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Add Students</li>
</ol>
@if (session('success'))
<div id="success-alert" class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif
<div class="card">
    <div class="card-header bg-secondary text-white">Add Student Information</div>
    <div class="card-body">
        <form action="{{ route('admin.students.store') }}" method="post" id="addStudentForm">
            @csrf
            <div class="row">
                <h3>Personal Information</h3>
                <hr style="border: 3px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="first_name" class="form-label" style="font-weight: bold;">First Name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                            name="first_name" value="{{ old('first_name') }}">
                    </div>
                    <div class="mb-4">
                        <label for="last_name" class="form-label" style="font-weight: bold;">Last Name</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                            name="last_name" value="{{ old('last_name') }}">
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="middle_name" class="form-label" style="font-weight: bold;">Middle Name</label>
                        <input type="text" class="form-control @error('middle_name') is-invalid @enderror"
                            name="middle_name" value="{{ old('middle_name') }}">
                    </div>
                    <div class="mb-4">
                        <label for="nick_name" class="form-label" style="font-weight: bold;">Nick Name</label>
                        <input type="text" class="form-control @error('nick_name') is-invalid @enderror"
                            name="nick_name" value="{{ old('nick_name') }}">
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="birthdate" class="form-label" style="font-weight: bold;">Birthdate</label>
                        <input type="date" class="form-control @error('birthdate') is-invalid @enderror"
                            name="birthdate" value="{{ old('birthdate') }}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="gender_id" class="form-label" style="font-weight: bold;">Gender</label>
                        <select class="form-control @error('gender_id') is-invalid @enderror"
                            name="gender_id" value="{{ old('gender_id') }}">
                            <option value="" disabled selected>Select Gender</option>
                            @foreach ($genders as $gender)
                            <option value="{{$gender->id}}" {{ (old('gender_id') == $gender->id) ? 'selected' : ''}}>
                                {{$gender->gender_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="birth_order_among_sibling" class="form-label" style="font-weight: bold;">Birth Order Among Siblings?</label>
                        <input type="text" class="form-control @error('birth_order_among_sibling') is-invalid @enderror"
                            name="birth_order_among_sibling" value="{{ old('birth_order_among_sibling') }}" id="birth_order_among_sibling">
                        <small id="birth_order_Error" style="color:red"></small>
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="place_of_birth" class="form-label" style="font-weight: bold;">Place of Birth</label>
                        <textarea type="text" class="form-control @error('place_of_birth') is-invalid @enderror"
                            name="place_of_birth" rows="3">{{ old('place_of_birth') }}</textarea>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="current_address" class="form-label" style="font-weight: bold;">Current Address</label>
                        <textarea type="text" class="form-control @error('current_address') is-invalid @enderror"
                            name="current_address" rows="3">{{ old('current_address') }}</textarea>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="permanent_address" class="form-label" style="font-weight: bold;">Permanent Address</label>
                        <textarea type="text" class="form-control @error('permanent_address') is-invalid @enderror"
                            name="permanent_address" value="{{ old('permanent_address') }}" rows="3"></textarea>
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="contact_no" class="form-label" style="font-weight: bold;">Contact No.</label>
                        <input type="text" class="form-control @error('contact_no') is-invalid @enderror"
                            name="contact_no" value="{{ old('contact_no') }}" id="contact_no">
                        <small id="contactNoError" style="color:red"></small>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="email_address" class="form-label" style="font-weight: bold;">Email Accout</label>
                        <input type="email" class="form-control @error('email_address') is-invalid @enderror" id="email_address"
                            name="email_address" value="{{ old('email_address') }}">
                        <small id="email_address_error" style="color:red"></small>
                        <div id="email_error" class="invalid-feedback" style="display: none;">Email is already in use.</div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="facebook_account" class="form-label" style="font-weight: bold;">Facebook Acount</label>
                        <input type="text" class="form-control @error('facebook_account') is-invalid @enderror"
                            name="facebook_account" value="{{ old('facebook_account') }}">
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="dialect_id" class="form-label" style="font-weight: bold;">Languages/Dialects Spoken at Home</label>
                        <select class="form-control @error('dialect_id') is-invalid @enderror"
                            name="dialect_id" value="{{ old('dialect_id') }}">
                            <option value="" disabled selected>Select Dialect</option>
                            @foreach ($dialects as $dialect)
                            <option value="{{$dialect->id}}" {{old('dialect_id') == $dialect->id ? 'selected' : ''}}>
                                {{$dialect->dialect_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="pwd" class="form-label" style="font-weight: bold;">Are you PWD?</label>
                        <select class="form-control @error('pwd') is-invalid @enderror" id="pwd" name="pwd"
                            onchange="toggleRemarks('pwd_remarks', this.value)">
                            <option value="" disabled selected>Select</option>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>

                    <div class="mb-4" id="pwd_remarks" style="display: none;">
                        <label for="pwd_remarksInput" class="form-label">Remarks:</label>
                        <input type="text" class="form-control @error('pwd_remarks') is-invalid @enderror"
                            id="pwd_remarksInput" name="pwd_remarks">
                    </div>
                    <div class="mb-4">
                        <label for="solo_parent" class="form-label" style="font-weight: bold;">Are you a Solo Parent?</label>
                        <select class="form-control @error('solo_parent') is-invalid @enderror"
                            id="solo_parent" name="solo_parent">
                            <option value="" disabled selected>Select</option>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="student_religion_id" class="form-label" style="font-weight: bold;">Religion</label>
                        <select class="form-control @error('student_religion_id') is-invalid @enderror"
                            name="student_religion_id" value="{{ old('student_religion_id') }}">
                            <option value="" disabled selected>Select Religion</option>
                            @foreach ($religions as $religion)
                            <option value="{{$religion->id}}"
                                {{old('student_religion_id') == $religion->id ? 'selected' : '' }}>
                                {{$religion->religion_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="ips" class="form-label" style="font-weight: bold;">Are you IPs?</label>
                        <select class="form-control @error('ips') is-invalid @enderror" id="ips" name="ips"
                            onchange="toggleRemarks('ips_remarks', this.value)">
                            <option value="" disabled selected>Select</option>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>

                    <div class="mb-4" id="ips_remarks" style="display: none;">
                        <label for="ips_remarksInput" class="form-label">Remarks:</label>
                        <input type="text" class="form-control @error('ips_remarks') is-invalid @enderror"
                            id="ips_remarksInput" name="ips_remarks">
                    </div>
                    <div class="mb-4">
                        <label for="stay_id" class="form-label" style="font-weight: bold;">Who are you staying?</label>
                        <select class="form-control @error('stay_id') is-invalid @enderror"
                            name="stay_id" value="{{ old('stay_id') }}">
                            <option value="" disabled selected>Please Select</option>
                            @foreach ($stays as $stay)
                            <option value="{{$stay->id}}">{{$stay->stay_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="id_no" class="form-label" style="font-weight: bold;">ID No</label>
                        <input type="text" class="form-control @error('id_no') is-invalid @enderror"
                            id="id_no" name="id_no" value="{{ old('id_no') }}" id="id_no">
                        <small id="idNoError" style="color: red;"></small>
                        @error('id_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="idNoError" class="invalid-feedback" style="display: none;">ID No. is already in exist.</div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="school_year_id" class="form-label" style="font-weight: bold;">School Year</label>
                        <select class="form-control @error('school_year_id') is-invalid @enderror"
                            name="school_year_id" value="{{ old('school_year_id') }}">
                            <option value="" disabled selected>Select School Year</option>
                            @foreach ($school_years as $school_year)
                            <option value="{{$school_year->id}}">{{$school_year->school_year_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="semester_id" class="form-label" style="font-weight: bold;">Semester</label>
                        <select class="form-control @error('semester_id') is-invalid @enderror"
                            name="semester_id" value="{{ old('semester_id') }}">
                            <option value="" disabled selected>Select Semester</option>
                            @foreach ($semesters as $semester)
                            <option value="{{$semester->id}}">{{$semester->semester_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr style="border: 1px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="course_id" class="form-label" style="font-weight: bold;">Course</label>
                        <select class="form-control @error('course_id') is-invalid @enderror"
                            name="course_id" value="{{ old('course_id') }}">
                            <option value="" disabled selected>Select Course</option>
                            @foreach ($courses as $course)
                            <option value="{{$course->id}}">{{$course->course_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="year_id" class="form-label" style="font-weight: bold;">Year Level</label>
                        <select class="form-control @error('year_id') is-invalid @enderror"
                            name="year_id" value="{{ old('year_id') }}">
                            <option value="" disabled selected>Select Year</option>
                            @foreach ($years as $year)
                            <option value="{{$year->id}}">{{$year->year_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr style="border: 3px solid;stroke: black;" />
                <h3>Family Background</h3>
                <hr style="border: 1px solid;stroke: black;" />
                <h5 style="text-decoration: underline;">Father</h5>
                <hr style="border: 1px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="fathers_name" class="form-label" style="font-weight: bold;">Name</label>
                        <input type="text" class="form-control @error('fathers_name') is-invalid @enderror"
                            name="fathers_name" value="{{ old('fathers_name') }}">
                    </div>
                    <div class="mb-4">
                        <label for="fathers_address" class="form-label" style="font-weight: bold;">Address</label>
                        <textarea type="text" class="form-control @error('fathers_address') is-invalid @enderror"
                            name="fathers_address" value="{{ old('fathers_address') }}" rows="2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="fathers_contact_no" class="form-label" style="font-weight: bold;">Contact No.</label>
                        <input type="text" class="form-control @error('fathers_contact_no') is-invalid @enderror"
                            name="fathers_contact_no" value="{{ old('fathers_contact_no') }}" id="fathers_contact_no">
                        <small id="fathers_contactNoError" style="color:red"></small>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="fathers_birthdate" class="form-label" style="font-weight: bold;">Birthdate</label>
                        <input type="date" class="form-control @error('fathers_birthdate') is-invalid @enderror"
                            name="fathers_birthdate" value="{{ old('fathers_birthdate') }}">
                    </div>
                    <div class="mb-4">
                        <label for="fathers_place_of_birth" class="form-label" style="font-weight: bold;">Place of Birth</label>
                        <textarea type="text" class="form-control @error('fathers_place_of_birth') is-invalid @enderror"
                            name="fathers_place_of_birth" value="{{ old('fathers_place_of_birth') }}" rows="2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="fathers_religion_id" class="form-label" style="font-weight: bold;">Religion</label>
                        <select class="form-control @error('fathers_religion_id') is-invalid @enderror"
                            name="fathers_religion_id" value="{{ old('fathers_religion_id') }}">
                            <option value="" disabled selected>Choose Religion</option>
                            @foreach ($religions as $religion)
                            <option value="{{$religion->id}}">{{$religion->religion_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr style="border: 1px solid;stroke: black;" />
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="fathers_highest_education_id" class="form-label" style="font-weight: bold;">Highest Education Attainment</label>
                        <select class="form-control @error('fathers_highest_education_id') is-invalid @enderror"
                            name="fathers_highest_education_id" value="{{ old('fathers_highest_education_id') }}">
                            <option value="" disabled selected>Choose Highest Education Attainment</option>
                            @foreach ($highest_educations as $highest_education)
                            <option value="{{$highest_education->id}}">{{$highest_education->highest_education_level}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="fathers_occupation" class="form-label" style="font-weight: bold;">Occupation</label>
                        <input type="text" class="form-control @error('fathers_occupation') is-invalid @enderror"
                            placeholder="Farmer" name="fathers_occupation" value="{{ old('fathers_occupation') }}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="number_of_fathers_sibling" class="form-label" style="font-weight: bold;">Numbers of Siblings</label>
                        <input type="text" class="form-control @error('number_of_fathers_sibling') is-invalid @enderror"
                            name="number_of_fathers_sibling" value="{{ old('number_of_fathers_sibling') }}" id="number_of_fathers_sibling">
                        <small id="number_of_fathers_sibling_Error" style="color:red;"></small>
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <h5 style="text-decoration: underline;">Mother</h5>
                <hr style="border: 1px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="mothers_name" class="form-label" style="font-weight: bold;">Name</label>
                        <input type="text" class="form-control @error('mothers_name') is-invalid @enderror"
                            name="mothers_name" value="{{ old('mothers_name') }}">
                    </div>
                    <div class="mb-4">
                        <label for="mothers_address" class="form-label" style="font-weight: bold;">Address</label>
                        <textarea type="text" class="form-control @error('mothers_address') is-invalid @enderror"
                            placeholder="Poblacion, Compostela" name="mothers_address" value="{{ old('mothers_address') }}" rows="2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="mothers_contact_no" class="form-label" style="font-weight: bold;">Contact No.</label>
                        <input type="text" class="form-control @error('mothers_contact_no') is-invalid @enderror"
                            name="mothers_contact_no" value="{{ old('mothers_contact_no') }}" id="mothers_contact_no">
                        <small id="mothers_contactNoError" style="color:red"></small>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="mothers_birthdate" class="form-label" style="font-weight: bold;">Birthdate</label>
                        <input type="date" class="form-control @error('mothers_birthdate') is-invalid @enderror"
                            name="mothers_birthdate" value="{{ old('mothers_birthdate') }}">
                    </div>
                    <div class="mb-4">
                        <label for="mothers_place_of_birth" class="form-label" style="font-weight: bold;">Place of Birth</label>
                        <textarea type="text" class="form-control @error('mothers_place_of_birth') is-invalid @enderror"
                            name="mothers_place_of_birth" value="{{ old('mothers_place_of_birth') }}" rows="2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="mothers_religion_id" class="form-label" style="font-weight: bold;">Religion</label>
                        <select class="form-control @error('mothers_religion_id') is-invalid @enderror"
                            name="mothers_religion_id" value="{{ old('mothers_religion_id') }}">
                            <option value="" disabled selected>Choose Religion</option>
                            @foreach ($religions as $religion)
                            <option value="{{$religion->id}}">{{$religion->religion_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr style="border: 1px solid;stroke: black;" />
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="mothers_highest_education_id" class="form-label" style="font-weight: bold;">Highest Education Attainment</label>
                        <select class="form-control @error('mothers_highest_education_id') is-invalid @enderror"
                            name="mothers_highest_education_id" value="{{ old('mothers_highest_education_id') }}">
                            <option value="" disabled selected>Choose Highest Education Attainment</option>
                            @foreach ($highest_educations as $highest_education)
                            <option value="{{$highest_education->id}}">{{$highest_education->highest_education_level}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="mothers_occupation" class="form-label" style="font-weight: bold;">Occupation</label>
                        <input type="text" class="form-control @error('mothers_occupation') is-invalid @enderror"
                            name="mothers_occupation" value="{{ old('mothers_occupation') }}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="number_of_mothers_sibling" class="form-label" style="font-weight: bold;">Numbers of Siblings</label>
                        <input type="text" class="form-control @error('number_of_mothers_sibling') is-invalid @enderror"
                            name="number_of_mothers_sibling" value="{{ old('number_of_mothers_sibling') }}" id="number_of_mothers_sibling">
                        <small id="number_of_mothers_sibling_Error" style="color: red;"></small>
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="income_id" class="form-label" style="font-weight: bold;">Monthly Family Income (Combined)</label>
                        <select class="form-control @error('income_id') is-invalid @enderror"
                            name="income_id" value="{{ old('income_id') }}">
                            <option value="" disabled selected>Choose Income Base</option>
                            @foreach ($incomes as $income)
                            <option value="{{$income->id}}">{{$income->income_base}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="parents_status_id" class="form-label" style="font-weight: bold;">Parents Status</label>
                        <select class="form-control @error('parents_status_id') is-invalid @enderror"
                            name="parents_status_id" value="{{ old('parents_status_id') }}">
                            <option value="" disabled selected>Choose Parent Status</option>
                            @foreach ($parents_status as $parent_statu)
                            <option value="{{$parent_statu->id}}">{{$parent_statu->status}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <h5>Incase of Emergency</h5>
                <hr style="border: 1px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="incase_of_emergency_name" class="form-label" style="font-weight: bold;">Name</label>
                        <input type="text" class="form-control @error('incase_of_emergency_name') is-invalid @enderror"
                            name="incase_of_emergency_name" value="{{ old('incase_of_emergency_name') }}">
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="incase_of_emergency_contact" class="form-label" style="font-weight: bold;">Contact No.</label>
                        <input type="text" class="form-control @error('incase_of_emergency_contact') is-invalid @enderror"
                            name="incase_of_emergency_contact" value="{{ old('incase_of_emergency_contact') }}" id="incase_of_emergency_contact">
                        <small id="incase_of_emergency_contact_Error" style="color:red"></small>
                    </div>
                </div>
                <hr style="border: 3px solid;stroke: black;" />
                <h3>Educational Background</h3>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="kindergarten" class="form-label" style="font-weight: bold;">Kindergarten</label>
                        <input type="text" class="form-control @error('kindergarten') is-invalid @enderror"
                            name="kindergarten" value="{{ old('kindergarten') }}">
                    </div>
                    <div class="mb-4">
                        <label for="elementary" class="form-label" style="font-weight: bold;">Elementary</label>
                        <input type="text" class="form-control @error('elementary') is-invalid @enderror"
                            name="elementary" value="{{ old('elementary') }}">
                    </div>
                    <div class="mb-4">
                        <label for="junior_high" class="form-label" style="font-weight: bold;">Junior High</label>
                        <input type="text" class="form-control @error('junior_high') is-invalid @enderror"
                            name="junior_high" value="{{ old('junior_high') }}">
                    </div>
                    <div class="mb-4">
                        <label for="senior_high" class="form-label" style="font-weight: bold;">Senior High</label>
                        <input type="text" class="form-control @error('senior_high') is-invalid @enderror"
                            name="senior_high" value="{{ old('senior_high') }}">
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="kindergarten_year_attended" class="form-label" style="font-weight: bold;">Kindergarten Year Attended</label>
                        <input type="text" class="form-control @error('kindergarten_year_attended') is-invalid @enderror"
                            name="kindergarten_year_attended" value="{{ old('kindergarten_year_attended') }}">
                    </div>
                    <div class="mb-4">
                        <label for="elementary_year_attended" class="form-label" style="font-weight: bold;">Elementary Year Attended</label>
                        <input type="text" class="form-control @error('elementary_year_attended') is-invalid @enderror"
                            name="elementary_year_attended" value="{{ old('elementary_year_attended') }}">
                    </div>
                    <div class="mb-4">
                        <label for="junior_high_year_attended" class="form-label" style="font-weight: bold;">Junior High Year Attended</label>
                        <input type="text" class="form-control @error('junior_high_year_attended') is-invalid @enderror"
                            name="junior_high_year_attended" value="{{ old('junior_high_year_attended') }}">
                    </div>
                    <div class="mb-4">
                        <label for="senior_high_year_attended" class="form-label" style="font-weight: bold;">Senior High Year Attended</label>
                        <input type="text" class="form-control @error('senior_high_year_attended') is-invalid @enderror"
                            name="senior_high_year_attended" value="{{ old('senior_high_year_attended') }}">
                    </div>
                </div>
            </div>
            <button class="btn btn-primary ms-auto d-block w-25">Save</button>
        </form>
    </div>
</div>
<script>
    const checkEmailUrl = "{{ route('admin.students.checkEmail') }}";
    const csrfToken = '{{ csrf_token() }}';

    const checkIDNoUrl = "{{ route('admin.students.checkIDNo') }}";
</script>
<script src="{{asset('admin/js/createFunction.js')}}"></script>
@endsection