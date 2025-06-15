@extends('layouts.admin')
@section('title','View Student')
@section('content')
<div class="row mt-3">
    <div class="col-xl-6 col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-circle me-2"></i> Personal Information
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span>
                        <i class="fas fa-user me-2 text-primary"></i>
                        <strong>Student Name:</strong>
                        {{ $student->first_name ?? 'N/A' }}
                        {{ $student->middle_name ?? 'N/A' }}
                        {{ $student->last_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-user-tag me-2 text-secondary"></i>
                        <strong>Nick Name:</strong> {{ $student->nick_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-venus-mars me-2 text-info"></i>
                        <strong>Gender:</strong> {{ $student->gender->gender_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-birthday-cake me-2 text-warning"></i>
                        <strong>Age:</strong> {{ $student->age ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-calendar-alt me-2 text-danger"></i>
                        <strong>Birthdate:</strong> {{ $student->birthdate ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-map-marker-alt me-2 text-success"></i>
                        <strong>Birth Place:</strong> {{ $student->place_of_birth ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-sitemap me-2 text-dark"></i>
                        <strong>Birth Order Among Siblings:</strong> {{ $student->birth_order_among_sibling ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-language me-2 text-primary"></i>
                        <strong>Dialect:</strong> {{ $student->dialect->dialect_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-praying-hands me-2 text-secondary"></i>
                        <strong>Religion:</strong> {{ $student->StudentsReligion->religion_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-home me-2 text-info"></i>
                        <strong>Stay at:</strong> {{ $student->stay->stay_name ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-map-marker-alt me-2"></i> Personal Information - Address
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span>
                        <i class="fas fa-map-signs me-2 text-info"></i>
                        <strong>Current Address:</strong>
                        {{ $student->currentProvince->prov_desc ?? 'N/A' }},
                        {{ $student->currentMunicipality->citymun_desc ?? 'N/A' }},
                        {{ $student->currentBarangay->brgy_desc ?? 'N/A' }},
                        {{ $student->current_purok ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-home me-2 text-success"></i>
                        <strong>Permanent Address:</strong>
                        {{ $student->permanentProvince->prov_desc ?? 'N/A' }},
                        {{ $student->permanentMunicipality->citymun_desc ?? 'N/A' }},
                        {{ $student->permanentBarangay->brgy_desc ?? 'N/A' }},
                        {{ $student->permanent_purok ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-address-card me-2"></i> Personal Information - Contact
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span>
                        <i class="fas fa-phone-alt me-2 text-success"></i>
                        <strong>Contact No:</strong> {{ $student->contact_no ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-envelope me-2 text-primary"></i>
                        <strong>Email Address:</strong> {{ $student->email_address ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fab fa-facebook-f me-2 text-info"></i>
                        <strong>Facebook:</strong> {{ $student->facebook_account ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-user-md me-2 text-danger"></i>
                        <strong>Incase of Emergency Name:</strong> {{ $student->incase_of_emergency_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-phone-alt me-2 text-warning"></i>
                        <strong>Incase of Emergency Contact:</strong>
                        {{ $student->incase_of_emergency_contact ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-school me-2"></i> Personal Information - School Information
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span>
                        <i class="fas fa-id-card-alt me-2 text-info"></i>
                        <strong>ID NO:</strong> {{ $student->id_no ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-graduation-cap me-2 text-primary"></i>
                        <strong>Course:</strong> {{ $student->course->course_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-user-graduate me-2 text-success"></i>
                        <strong>Year Level:</strong> {{ $student->year->year_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-calendar-alt me-2 text-warning"></i>
                        <strong>Semester:</strong> {{ $student->semester->semester_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-clock me-2 text-danger"></i>
                        <strong>School Year:</strong> {{ $student->school_year->school_year_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-graduation-cap me-2 text-primary"></i>
                        <strong>Scholarship:</strong> {{ $student->scholarship ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-comment-dots me-2 text-secondary"></i>
                        <strong>Scholarship Remarks:</strong> {{ $student->scholarship_remarks ?? 'N/A' }}
                    </span>
                </div>

            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-check me-2"></i> Personal Information - Status
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span>
                        <i class="fas fa-user-shield me-2 text-info"></i>
                        <strong>Solo Parent:</strong> {{ $student->solo_parent ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-users me-2 text-info"></i>
                        <strong>4p's:</strong> {{ $student->four_ps ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-wheelchair me-2 text-primary"></i>
                        <strong>PWD:</strong> {{ $student->pwd ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-notes-medical me-2 text-secondary"></i>
                        <strong>PWD Remarks:</strong> {{ $student->pwdRemarks->pwd_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-user me-2 text-success"></i>
                        <strong>IP's:</strong> {{ $student->ips ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-comment-dots me-2 text-warning"></i>
                        <strong>IP's Remarks:</strong> {{ $student->ips_remarks ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-tie me-2"></i> Fathers Information
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span>
                        <i class="fas fa-user me-2 text-info"></i>
                        <strong>Fathers Name:</strong> {{ $student->fathers_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        <strong>Birthdate:</strong> {{ $student->fathers_birthdate ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-map-marker-alt me-2 text-secondary"></i>
                        <strong>Place of Birth:</strong> {{ $student->fathers_place_of_birth ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-home me-2 text-success"></i>
                        <strong>Address:</strong>
                        {{ $student->fathersProvince->prov_desc ?? 'N/A' }},
                        {{ $student->fathersMunicipality->citymun_desc ?? 'N/A' }},
                        {{ $student->fathersBarangay->brgy_desc ?? 'N/A' }},
                        {{ $student->fathers_purok ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-phone-alt me-2 text-warning"></i>
                        <strong>Contact No:</strong> {{ $student->fathers_contact_no ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-graduation-cap me-2 text-danger"></i>
                        <strong>Highest Education Attainment:</strong>
                        {{ $student->FathersHighestEducation->highest_education_level  ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-briefcase me-2 text-info"></i>
                        <strong>Occupation:</strong> {{ $student->fathers_occupation ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-praying-hands me-2 text-primary"></i>
                        <strong>Religion:</strong> {{ $student->FathersReligion->religion_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-user me-2 text-success"></i>
                        <strong>Number of Siblings:</strong> {{ $student->number_of_fathers_sibling ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-tie me-2"></i> Mothers Information
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span>
                        <i class="fas fa-user me-2 text-info"></i>
                        <strong>Mothers Name:</strong> {{ $student->mothers_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        <strong>Birthdate:</strong> {{ $student->mothers_birthdate ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-map-marker-alt me-2 text-secondary"></i>
                        <strong>Place of Birth:</strong> {{ $student->mothers_place_of_birth ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-home me-2 text-success"></i>
                        <strong>Address:</strong>
                        {{ $student->mothersProvince->prov_desc ?? 'N/A' }},
                        {{ $student->mothersMunicipality->citymun_desc ?? 'N/A' }},
                        {{ $student->mothersBarangay->brgy_desc ?? 'N/A' }},
                        {{ $student->mothers_purok ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-phone-alt me-2 text-warning"></i>
                        <strong>Contact No:</strong> {{ $student->mothers_contact_no ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-graduation-cap me-2 text-danger"></i>
                        <strong>Highest Education Attainment:</strong>
                        {{ $student->MothersHighestEducation->highest_education_level  ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-briefcase me-2 text-info"></i>
                        <strong>Occupation:</strong> {{ $student->mothers_occupation ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-praying-hands me-2 text-primary"></i>
                        <strong>Religion:</strong> {{ $student->MothersReligion->religion_name ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-user me-2 text-success"></i>
                        <strong>Number of Siblings:</strong> {{ $student->number_of_mothers_sibling ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i> Family Information
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span>
                        <i class="fas fa-dollar-sign me-2 text-info"></i>
                        <strong>Family Income:</strong> {{ $student->income->income_base ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-heart me-2 text-primary"></i>
                        <strong>Parent Status:</strong> {{ $student->parent_status->status ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-graduation-cap me-2"></i> Education Background
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span>
                        <i class="fas fa-school me-2 text-info"></i>
                        <strong>Kinder at:</strong> {{ $student->kindergarten ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        <strong>Year Attended:</strong> {{ $student->kindergarten_year_attended ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-school me-2 text-info"></i>
                        <strong>Elementary at:</strong> {{ $student->elementary ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        <strong>Year Attended:</strong> {{ $student->elementary_year_attended ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-school me-2 text-info"></i>
                        <strong>Junior High School at:</strong> {{ $student->junior_high ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        <strong>Year Attended:</strong> {{ $student->junior_high_year_attended ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-school me-2 text-info"></i>
                        <strong>Senior High School at:</strong> {{ $student->senior_high ?? 'N/A' }}
                    </span>
                </div>
                <div class="mb-3">
                    <span>
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        <strong>Year Attended:</strong> {{ $student->senior_high_year_attended ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>





</div>
@endsection