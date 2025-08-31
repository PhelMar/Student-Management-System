@extends('layouts.admin')
@section('title', 'Edit Student')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h1 mt-2">Edit Student</h1>
    <button onclick="goBack()" class="btn btn-primary mt-3">Go Back</button>
</div>
@if (session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: 'Success!',
            text: "{{session('success')}}",
            icon: 'success',
            confirmButtonText: 'OK',
            timer: 2000
        });
    });
</script>
@elseif (session('error'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: 'Error!',
            html: "{!! session('error') !!}",
            icon: 'error',
            confirmButtonText: 'OK',
            timer: 5000
        });
    });
</script>
@endif
<div class="card">
    <div class="card-header text-white" style="background-color: #0A7075">Edit Student Information</div>
    <div class="card-body">
        <form action="{{ route('admin.students.update',  Hashids::encode($students->id)) }}" method="post" id="updateStudentForm">
            @csrf
            @method('PUT')
            <div class="step" data-step="1">
                @include('admin.student-profile.edit-student.step1')
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
            <div class="step" data-step="2">
                @include('admin.student-profile.edit-student.step2')
                <button type="button" class="btn btn-secondary back">Back</button>
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
            <div class="step" data-step="3">
                @include('admin.student-profile.edit-student.step3')
                <button type="button" class="btn btn-secondary back">Back</button>
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
            <div class="step" data-step="4">
                @include('admin.student-profile.edit-student.step4')
                <button type="button" class="btn btn-secondary back">Back</button>
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
            <div class="step" data-step="5">
                @include('admin.student-profile.edit-student.step5')
                <button type="button" class="btn btn-secondary back">Back</button>
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
            <div class="step" data-step="6">
                @include('admin.student-profile.edit-student.step6')
                <button type="button" class="btn btn-secondary back">Back</button>
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
            <div class="step" data-step="7">
                @include('admin.student-profile.edit-student.step7')
                <button type="button" class="btn btn-secondary back">Back</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>
<script>
    const checkEmailUrl = "{{ route('admin.students.checkEmail') }}";
    const csrfToken = '{{ csrf_token() }}';

    const checkIDNoUrl = "{{ route('admin.students.checkIDNo') }}";

    const municipalitiesUrl = "{{ route('admin.municipalities', ':province_id') }}";
    const barangaysUrl = "{{ route('admin.barangays', ':municipality_id') }}";

    const selectedMunicipality = "{{ $students->current_municipality_id }}";
    const selectedBarangay = "{{ $students->current_barangay_id }}";

    $(document).ready(function() {
        function initFieldGroup(provinceId, municipalityId, barangayId, selectedProvince, selectedMunicipality, selectedBarangay) {
            const provinceSelect = $(provinceId);
            const municipalitySelect = $(municipalityId);
            const barangaySelect = $(barangayId);

            if (selectedProvince) {
                fetchMunicipalities(provinceSelect, municipalitySelect, barangaySelect, selectedProvince, selectedMunicipality, selectedBarangay);
            }

            provinceSelect.change(function() {
                const provinceCode = $(this).val();
                if (provinceCode) {
                    fetchMunicipalities(provinceSelect, municipalitySelect, barangaySelect, provinceCode);
                } else {
                    municipalitySelect.html('<option value="">Select Municipality</option>');
                    barangaySelect.html('<option value="">Select Barangay</option>');
                }
            });

            municipalitySelect.change(function() {
                const municipalityCode = $(this).val();
                if (municipalityCode) {
                    fetchBarangays(barangaySelect, municipalityCode);
                } else {
                    barangaySelect.html('<option value="">Select Barangay</option>');
                }
            });
        }

        function fetchMunicipalities(provinceSelect, municipalitySelect, barangaySelect, provinceCode, selectedMunicipality = null, selectedBarangay = null) {
            const url = municipalitiesUrl.replace(':province_id', provinceCode);

            municipalitySelect.html('<option value="">Loading...</option>');
            barangaySelect.html('<option value="">Select Barangay</option>');

            $.get(url, function(data) {
                let options = '<option value="">Select Municipality</option>';
                data.forEach(function(municipality) {
                    const isSelected = selectedMunicipality == municipality.citymun_code ? 'selected' : '';
                    options += `<option value="${municipality.citymun_code}" ${isSelected}>
                    ${municipality.citymun_desc}</option>`;
                });
                municipalitySelect.html(options);

                if (selectedMunicipality) {
                    fetchBarangays(barangaySelect, selectedMunicipality, selectedBarangay);
                }
            }).fail(function() {
                alert('Failed to fetch municipalities.');
            });
        }

        function fetchBarangays(barangaySelect, municipalityCode, selectedBarangay = null) {
            const url = barangaysUrl.replace(':municipality_id', municipalityCode);

            barangaySelect.html('<option value="">Loading...</option>');

            $.get(url, function(data) {
                let options = '<option value="">Select Barangay</option>';
                data.forEach(function(barangay) {
                    const isSelected = selectedBarangay == barangay.brgy_code ? 'selected' : '';
                    options += `<option value="${barangay.brgy_code}" ${isSelected}>
                    ${barangay.brgy_desc}</option>`;
                });
                barangaySelect.html(options);
            }).fail(function() {
                alert('Failed to fetch barangays.');
            });
        }

        initFieldGroup('#current_province', '#current_municipality', '#current_barangay',
            "{{ $students->current_province_id }}", "{{ $students->current_municipality_id }}", "{{ $students->current_barangay_id }}");

        initFieldGroup('#permanent_province', '#permanent_municipality', '#permanent_barangay',
            "{{ $students->permanent_province_id }}", "{{ $students->permanent_municipality_id }}", "{{ $students->permanent_barangay_id }}");

        initFieldGroup('#fathers_province', '#fathers_municipality', '#fathers_barangay',
            "{{ $students->fathers_province_id }}", "{{ $students->fathers_municipality_id }}", "{{ $students->fathers_barangay_id }}");

        initFieldGroup('#mothers_province', '#mothers_municipality', '#mothers_barangay',
            "{{ $students->mothers_province_id }}", "{{ $students->mothers_municipality_id }}", "{{ $students->mothers_barangay_id }}");
    });


    function goBack() {
        window.history.back();
    }
</script>

<script src="{{asset('admin/js/editFunction.js')}}"></script>
@endsection