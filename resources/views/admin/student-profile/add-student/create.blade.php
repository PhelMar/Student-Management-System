@extends('layouts.admin')
@section('title', 'Add Student')

@section('content')
<h3 class="mt-2">Add Students</h3>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Add Students</li>
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
@elseif (session('error'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: 'Error!',
            text: "{{session('error')}}",
            icon: 'error',
            confirmButtonText: 'OK',
            timer: 1200
        });
    });
</script>
@endif
<div class="card shadow-xl">
    <div class="card-header text-white" style="background-color: #0A7075">Add Student Information</div>
    <div class="card-body overflow-auto" style="max-height: 500px;">
        <form action="{{ route('admin.students.store') }}" method="post" id="addStudentForm">
            @csrf
            <div class="step" data-step="1">
                @include('admin.student-profile.add-student.step1')
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
            <div class="step" data-step="2">
                @include('admin.student-profile.add-student.step2')
                <button type="button" class="btn btn-secondary back">Back</button>
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
            <div class="step" data-step="3">
                @include('admin.student-profile.add-student.step3')
                <button type="button" class="btn btn-secondary back">Back</button>
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
            <div class="step" data-step="4">
                @include('admin.student-profile.add-student.step4')
                <button type="button" class="btn btn-secondary back">Back</button>
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
            <div class="step" data-step="5">
                @include('admin.student-profile.add-student.step5')
                <button type="button" class="btn btn-secondary back">Back</button>
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
            <div class="step" data-step="6">
                @include('admin.student-profile.add-student.step6')
                <button type="button" class="btn btn-secondary back">Back</button>
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
            <div class="step" data-step="7">
                @include('admin.student-profile.add-student.step7')
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
    const muncipalitiesUrl = "{{ route('admin.municipalities', ':province_id') }}";
    const barangaysUrl = "{{ route('admin.barangays', ':municipality_id') }}";
</script>
<script src="{{asset('admin/js/createFunction.js')}}"></script>
@endsection