@extends('layouts.user')
@section('title', 'View Student')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h1 mt-2">View Student</h1>
    <button onclick="goBack()" class="btn btn-primary mt-3">Go Back</button>
</div>

@if (session('success'))
<div id="success-alert" class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif
<div class="card">
    <div class="card-header bg-secondary text-white">Student Information</div>
    <div class="card-body">
        <form id="studentForm">
            <div class="row">
                <h3>Personal Information</h3>
                <hr style="border: 3px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="first_name" class="form-label" style="font-weight: bold;">First Name</label>
                        <input type="text" class="form-control"
                            name="first_name" value="{{ old('first_name', $students->first_name) }}">
                    </div>
                    <div class="mb-4">
                        <label for="last_name" class="form-label" style="font-weight: bold;">Last Name</label>
                        <input type="text" class="form-control"
                            name="last_name" value="{{ old('last_name', $students->last_name)}}">
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="middle_name" class="form-label" style="font-weight: bold;">Middle Name</label>
                        <input type="text" class="form-control"
                            name="middle_name" value="{{ old('middle_name', $students->middle_name) }}">
                    </div>
                    <div class="mb-4">
                        <label for="nick_name" class="form-label" style="font-weight: bold;">Nick Name</label>
                        <input type="text" class="form-control"
                            name="nick_name" value="{{ old('nick_name', $students->nick_name) }}">
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="birthdate" class="form-label" style="font-weight: bold;">Birthdate</label>
                        <input type="date" class="form-control"
                            name="birthdate" value="{{ old('birthdate', $students->birthdate) }}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="gender_id" class="form-label" style="font-weight: bold;">Gender</label>
                        <select class="form-control"
                            name="gender_id" value="{{ old('gender_id') }}">
                            <option value="" disabled selected>Select Gender</option>
                            @foreach ($genders as $gender)
                            <option value="{{$gender->id}}" {{$students->gender_id == $gender->id ? 'selected' : ''}}>
                                {{$gender->gender_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="birth_order_among_sibling" class="form-label" style="font-weight: bold;">Birth Order Among Siblings?</label>
                        <input type="text" class="form-control"
                            name="birth_order_among_sibling" value="{{ old('birth_order_among_sibling', $students->birth_order_among_sibling) }}" id="birth_order_among_sibling">

                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="place_of_birth" class="form-label" style="font-weight: bold;">Place of Birth</label>
                        <textarea type="text" class="form-control"
                            name="place_of_birth" rows="3">{{ old('place_of_birth', $students->place_of_birth) }}</textarea>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="current_address" class="form-label" style="font-weight: bold;">Current Address</label>
                        <textarea type="text" class="form-control"
                            name="current_address" rows="3">{{ old('current_address', $students->current_address) }}</textarea>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="permanent_address" class="form-label" style="font-weight: bold;">Permanent Address</label>
                        <textarea type="text" class="form-control"
                            name="permanent_address" rows="3">{{ old('permanent_address', $students->permanent_address) }}</textarea>
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="contact_no" class="form-label" style="font-weight: bold;">Contact No.</label>
                        <input type="text" class="form-control"
                            name="contact_no" value="{{ old('contact_no', $students->contact_no) }}" id="contact_no">
                        <small id="contactNoError" style="color:red"></small>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="email_address" class="form-label" style="font-weight: bold;">Email Accout</label>
                        <input type="email" class="form-control" id="email_address"
                            name="email_address" value="{{ old('email_address', $students->email_address) }}">


                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="facebook_account" class="form-label" style="font-weight: bold;">Facebook Acount</label>
                        <input type="text" class="form-control"
                            name="facebook_account" value="{{ old('facebook_account', $students->facebook_account) }}">
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="dialect_id" class="form-label" style="font-weight: bold;">Languages/Dialects Spoken at Home</label>
                        <select class="form-control"
                            name="dialect_id" value="{{ old('dialect_id') }}">
                            <option value="" disabled selected>Select Dialect</option>
                            @foreach ($dialects as $dialect)
                            <option value="{{$dialect->id}}" {{$students->dialect_id == $dialect->id ? 'selected' : ''}}>
                                {{$dialect->dialect_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="pwd" class="form-label" style="font-weight: bold;">Are you PWD?</label>
                        <select class="form-control" id="pwd" name="pwd"
                            onchange="toggleRemarks('pwd_remarks', this.value)">
                            <option value="" disabled selected>Select</option>
                            <option value="No" {{old('pwd', $students->pwd) == "No" ? 'selected' : ''}}>No</option>
                            <option value="Yes" {{old('pwd', $students->pwd) == "Yes" ? 'selected' : ''}}>Yes</option>
                        </select>
                    </div>

                    <div class="mb-4" id="pwd_remarks" style="display: none;">
                        <label for="pwd_remarksInput" class="form-label">Remarks:</label>
                        <input type="text" class="form-control"
                            value="{{old('pwd_remarks', $students->pwd_remarks)}}"
                            id="pwd_remarksInput" name="pwd_remarks">
                    </div>
                    <div class="mb-4">
                        <label for="solo_parent" class="form-label" style="font-weight: bold;">Are you a Solo Parent?</label>
                        <select class="form-control"
                            id="solo_parent" name="solo_parent">
                            <option value="" disabled selected>Select</option>
                            <option value="No" {{old('solo_parent', $students->solo_parent) == "No" ? 'selected' : ''}}>No</option>
                            <option value="Yes" {{old('solo_parent', $students->solo_parent) == "Yes" ? 'selected' : ''}}>Yes</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="student_religion_id" class="form-label" style="font-weight: bold;">Religion</label>
                        <select class="form-control"
                            name="student_religion_id" value="{{ old('student_religion_id') }}">
                            <option value="" disabled selected>Select Religion</option>
                            @foreach ($religions as $religion)
                            <option value="{{$religion->id}}" {{$students->StudentsReligion && $students->StudentsReligion->id == $religion->id ? 'selected' : ''}}>
                                {{$religion->religion_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="ips" class="form-label" style="font-weight: bold;">Are you IPs?</label>
                        <select class="form-control" id="ips" name="ips"
                            onchange="toggleRemarks('ips_remarks', this.value)">
                            <option value="" disabled selected>Select</option>
                            <option value="No" {{old('ips', $students->ips) == "No" ? 'selected' : ''}}>No</option>
                            <option value="Yes" {{old('ips', $students->ips) == "Yes" ? 'selected' : ''}}>Yes</option>
                        </select>
                    </div>

                    <div class="mb-4" id="ips_remarks" style="display: none;">
                        <label for="ips_remarksInput" class="form-label">Remarks:</label>
                        <input type="text" class="form-control"
                            value="{{old('ips_remarks', $students->ips_remarks)}}"
                            id="ips_remarksInput" name="ips_remarks">
                    </div>
                    <div class="mb-4">
                        <label for="stay_id" class="form-label" style="font-weight: bold;">Who are you staying?</label>
                        <select class="form-control"
                            name="stay_id" value="{{ old('stay_id') }}">
                            <option value="" disabled selected>Please Select</option>
                            @foreach ($stays as $stay)
                            <option value="{{$stay->id}}" {{$students->stay_id == $stay->id ? 'selected' : ''}}>
                                {{$stay->stay_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="id_no" class="form-label" style="font-weight: bold;">ID No</label>
                        <input type="text" class="form-control"
                            id="id_no" name="id_no" value="{{ old('id_no', $students->id_no) }}" id="id_no">

                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="school_year_id" class="form-label" style="font-weight: bold;">School Year</label>
                        <select class="form-control"
                            name="school_year_id" value="{{ old('school_year_id') }}">
                            <option value="" disabled selected>Select School Year</option>
                            @foreach ($school_years as $school_year)
                            <option value="{{$school_year->id}}" {{$students->school_year_id == $school_year->id ? 'selected' : ''}}>
                                {{$school_year->school_year_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="semester_id" class="form-label" style="font-weight: bold;">Semester</label>
                        <select class="form-control"
                            name="semester_id" value="{{ old('semester_id') }}">
                            <option value="" disabled selected>Select Semester</option>
                            @foreach ($semesters as $semester)
                            <option value="{{$semester->id}}" {{$students->semester_id == $semester->id ? 'selected' : ''}}>
                                {{$semester->semester_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr style="border: 1px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="course_id" class="form-label" style="font-weight: bold;">Course</label>
                        <select class="form-control"
                            name="course_id" value="{{ old('course_id') }}">
                            <option value="" disabled selected>Select Course</option>
                            @foreach ($courses as $course)
                            <option value="{{$course->id}}" {{$students->course_id == $course->id ? 'selected' : ''}}>
                                {{$course->course_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="year_id" class="form-label" style="font-weight: bold;">Year Level</label>
                        <select class="form-control"
                            name="year_id" value="{{ old('year_id') }}">
                            <option value="" disabled selected>Select Year</option>
                            @foreach ($years as $year)
                            <option value="{{$year->id}}" {{$students->year_id == $year->id ? 'selected' : ''}}>
                                {{$year->year_name}}
                            </option>
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
                        <input type="text" class="form-control"
                            name="fathers_name" value="{{ old('fathers_name', $students->fathers_name) }}">
                    </div>
                    <div class="mb-4">
                        <label for="fathers_address" class="form-label" style="font-weight: bold;">Address</label>
                        <textarea type="text" class="form-control"
                            name="fathers_address" rows="2">{{ old('fathers_address', $students->fathers_address) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="fathers_contact_no" class="form-label" style="font-weight: bold;">Contact No.</label>
                        <input type="text" class="form-control"
                            name="fathers_contact_no" value="{{ old('fathers_contact_no', $students->fathers_contact_no) }}" id="fathers_contact_no">
                        <small id="fathers_contactNoError" style="color:red"></small>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="fathers_birthdate" class="form-label" style="font-weight: bold;">Birthdate</label>
                        <input type="date" class="form-control"
                            name="fathers_birthdate" value="{{ old('fathers_birthdate', $students->fathers_birthdate) }}">
                    </div>
                    <div class="mb-4">
                        <label for="fathers_place_of_birth" class="form-label" style="font-weight: bold;">Place of Birth</label>
                        <textarea type="text" class="form-control"
                            name="fathers_place_of_birth" rows="2">{{ old('fathers_place_of_birth', $students->fathers_place_of_birth) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="fathers_religion_id" class="form-label" style="font-weight: bold;">Religion</label>
                        <select class="form-control"
                            name="fathers_religion_id" value="{{ old('fathers_religion_id') }}">
                            <option value="" disabled selected>Choose Religion</option>
                            @foreach ($religions as $religion)
                            <option value="{{$religion->id}}"
                                {{$students->FathersReligion && $students->FathersReligion->id == $religion->id ? 'selected' : ''}}>
                                {{$religion->religion_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr style="border: 1px solid;stroke: black;" />
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="fathers_highest_education_id" class="form-label" style="font-weight: bold;">Highest Education Attainment</label>
                        <select class="form-control"
                            name="fathers_highest_education_id" value="{{ old('fathers_highest_education_id') }}">
                            <option value="" disabled selected>Choose Highest Education Attainment</option>
                            @foreach ($highest_educations as $highest_education)
                            <option value="{{$highest_education->id}}"
                                {{$students->FathersHighestEducation && $students->FathersHighestEducation->id == $highest_education->id ? 'selected' : ''}}>
                                {{$highest_education->highest_education_level}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="fathers_occupation" class="form-label" style="font-weight: bold;">Occupation</label>
                        <input type="text" class="form-control"
                            placeholder="Farmer" name="fathers_occupation" value="{{ old('fathers_occupation', $students->fathers_occupation) }}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="number_of_fathers_sibling" class="form-label" style="font-weight: bold;">Numbers of Siblings</label>
                        <input type="text" class="form-control"
                            name="number_of_fathers_sibling" value="{{ old('number_of_fathers_sibling', $students->number_of_fathers_sibling) }}" id="number_of_fathers_sibling">
                        <small id="number_of_fathers_sibling_Error" style="color:red;"></small>
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <h5 style="text-decoration: underline;">Mother</h5>
                <hr style="border: 1px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="mothers_name" class="form-label" style="font-weight: bold;">Name</label>
                        <input type="text" class="form-control"
                            name="mothers_name" value="{{ old('mothers_name', $students->mothers_name) }}">
                    </div>
                    <div class="mb-4">
                        <label for="mothers_address" class="form-label" style="font-weight: bold;">Address</label>
                        <textarea type="text" class="form-control"
                            placeholder="" name="mothers_address" rows="2">{{ old('mothers_address',$students->mothers_address) }}
                        </textarea>
                    </div>
                    <div class="mb-4">
                        <label for="mothers_contact_no" class="form-label" style="font-weight: bold;">Contact No.</label>
                        <input type="text" class="form-control"
                            name="mothers_contact_no" value="{{ old('mothers_contact_no', $students->mothers_contact_no) }}" id="mothers_contact_no">
                        <small id="mothers_contactNoError" style="color:red"></small>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="mothers_birthdate" class="form-label" style="font-weight: bold;">Birthdate</label>
                        <input type="date" class="form-control"
                            name="mothers_birthdate" value="{{ old('mothers_birthdate',$students->mothers_birthdate) }}">
                    </div>
                    <div class="mb-4">
                        <label for="mothers_place_of_birth" class="form-label" style="font-weight: bold;">Place of Birth</label>
                        <textarea type="text" class="form-control"
                            name="mothers_place_of_birth" rows="2">{{ old('mothers_place_of_birth',$students->mothers_place_of_birth) }}
                        </textarea>
                    </div>
                    <div class="mb-4">
                        <label for="mothers_religion_id" class="form-label" style="font-weight: bold;">Religion</label>
                        <select class="form-control"
                            name="mothers_religion_id" value="{{ old('mothers_religion_id') }}">
                            <option value="" disabled selected>Choose Religion</option>
                            @foreach ($religions as $religion)
                            <option value="{{$religion->id}}"
                                {{$students->MothersReligion && $students->MothersReligion->id == $religion->id ? 'selected' : ''}}>
                                {{$religion->religion_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr style="border: 1px solid;stroke: black;" />
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="mothers_highest_education_id" class="form-label" style="font-weight: bold;">Highest Education Attainment</label>
                        <select class="form-control"
                            name="mothers_highest_education_id" value="{{ old('mothers_highest_education_id') }}">
                            <option value="" disabled selected>Choose Highest Education Attainment</option>
                            @foreach ($highest_educations as $highest_education)
                            <option value="{{$highest_education->id}}"
                                {{$students->MothersHighestEducation && $students->MothersHighestEducation->id == $highest_education->id ? 'selected' : ''}}>
                                {{$highest_education->highest_education_level}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="mothers_occupation" class="form-label" style="font-weight: bold;">Occupation</label>
                        <input type="text" class="form-control"
                            name="mothers_occupation" value="{{ old('mothers_occupation', $students->mothers_occupation) }}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="mb-4">
                        <label for="number_of_mothers_sibling" class="form-label" style="font-weight: bold;">Numbers of Siblings</label>
                        <input type="text" class="form-control"
                            name="number_of_mothers_sibling" value="{{ old('number_of_mothers_sibling', $students->number_of_mothers_sibling) }}" id="number_of_mothers_sibling">
                        <small id="number_of_mothers_sibling_Error" style="color: red;"></small>
                    </div>
                </div>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="income_id" class="form-label" style="font-weight: bold;">Monthly Family Income (Combined)</label>
                        <select class="form-control"
                            name="income_id" value="{{ old('income_id') }}">
                            <option value="" disabled selected>Choose Income Base</option>
                            @foreach ($incomes as $income)
                            <option value="{{$income->id}}"
                                {{$students->income_id == $income->id ? 'selected' : ''}}>
                                {{$income->income_base}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="parents_status_id" class="form-label" style="font-weight: bold;">Parents Status</label>
                        <select class="form-control"
                            name="parents_status_id" value="{{ old('parents_status_id') }}">
                            <option value="" disabled selected>Choose Parent Status</option>
                            @foreach ($parents_status as $parent_statu)
                            <option value="{{$parent_statu->id}}"
                                {{$students->parents_status_id == $parent_statu->id ? 'selected' : ''}}>
                                {{$parent_statu->status}}
                            </option>
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
                        <input type="text" class="form-control"
                            name="incase_of_emergency_name" value="{{ old('incase_of_emergency_name', $students->incase_of_emergency_name) }}">
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="incase_of_emergency_contact" class="form-label" style="font-weight: bold;">Contact No.</label>
                        <input type="text" class="form-control"
                            name="incase_of_emergency_contact" value="{{ old('incase_of_emergency_contact', $students->incase_of_emergency_contact) }}" id="incase_of_emergency_contact">

                    </div>
                </div>
                <hr style="border: 3px solid;stroke: black;" />
                <h3>Educational Background</h3>
                <hr style="border: 2px solid;stroke: black;" />
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="kindergarten" class="form-label" style="font-weight: bold;">Kindergarten</label>
                        <input type="text" class="form-control"
                            name="kindergarten" value="{{ old('kindergarten', $students->kindergarten) }}">
                    </div>
                    <div class="mb-4">
                        <label for="elementary" class="form-label" style="font-weight: bold;">Elementary</label>
                        <input type="text" class="form-control "
                            name="elementary" value="{{ old('elementary', $students->elementary) }}">
                    </div>
                    <div class="mb-4">
                        <label for="junior_high" class="form-label" style="font-weight: bold;">Junior High</label>
                        <input type="text" class="form-control"
                            name="junior_high" value="{{ old('junior_high', $students->junior_high) }}">
                    </div>
                    <div class="mb-4">
                        <label for="senior_high" class="form-label" style="font-weight: bold;">Senior High</label>
                        <input type="text" class="form-control"
                            name="senior_high" value="{{ old('senior_high', $students->senior_high) }}">
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="mb-4">
                        <label for="kindergarten_year_attended" class="form-label" style="font-weight: bold;">Kindergarten Year Attended</label>
                        <input type="text" class="form-control"
                            name="kindergarten_year_attended" value="{{ old('kindergarten_year_attended', $students->kindergarten_year_attended) }}">
                    </div>
                    <div class="mb-4">
                        <label for="elementary_year_attended" class="form-label" style="font-weight: bold;">Elementary Year Attended</label>
                        <input type="text" class="form-control"
                            name="elementary_year_attended" value="{{ old('elementary_year_attended', $students->elementary_year_attended) }}">
                    </div>
                    <div class="mb-4">
                        <label for="junior_high_year_attended" class="form-label" style="font-weight: bold;">Junior High Year Attended</label>
                        <input type="text" class="form-control"
                            name="junior_high_year_attended" value="{{ old('junior_high_year_attended', $students->junior_high_year_attended) }}">
                    </div>
                    <div class="mb-4">
                        <label for="senior_high_year_attended" class="form-label" style="font-weight: bold;">Senior High Year Attended</label>
                        <input type="text" class="form-control"
                            name="senior_high_year_attended" value="{{ old('senior_high_year_attended', $students->senior_high_year_attended) }}">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setFieldsReadOnly();
    });

    function setFieldsReadOnly() {
        const inputs = document.querySelectorAll('#studentForm input, #studentForm select, #studentForm textarea');

        inputs.forEach(function(input) {
            if (input.tagName === 'INPUT') {

                if (input.type === 'text' || input.type === 'date') {
                    input.readOnly = true;
                }
            } else if (input.tagName === 'SELECT') {
                input.disabled = true;
            } else if (input.tagName === 'TEXTAREA') {
                input.readOnly = true;
            }
        });
    }

    function goBack() {
        window.history.back();
    }
</script>
@endsection