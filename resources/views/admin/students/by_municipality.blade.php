@extends('layouts.admin')
@section('title', "Students from {$municipality->citymun_desc}")

@section('content')
    <h1>Students from {{ $municipality->citymun_desc }}</h1>
    <div class="card shadow mb-4">
        <div class="card-header text-white" style="background-color: #0A7075">
            <i class="fas fa-table me-1"></i>
            Student List
        </div>
        <div class="card-body">
            <table id="studentsTable" class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student's Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Semester</th>
                        <th>School Year</th>
                        <th>Barangay</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Student's Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Semester</th>
                        <th>School Year</th>
                        <th>Barangay</th>
                    </tr>
                </tfoot>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div id="barangaySummary" class="mt-3 text-dark fw-bold"></div>

    <script>
        const countmunicipalBarangayCountsDataUrl = "{{ route('admin.students.municipalBarangayCounts') }}";
        const municipalStudentListDataUrl = "{{ route('admin.students.municipalStudentsList') }}";
        const municipalityId = "{{ $municipality->citymun_code }}";
    </script>
    <script src="{{ asset('admin/js/baranggaysCount.js') }}"></script>
@endsection
