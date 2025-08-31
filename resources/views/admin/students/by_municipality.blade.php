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

    <div class="card mb-4 shadow">
    <div class="card-header text-white" style="background-color: #0A7075">
        <i class="fas fa-chart-bar me-1"></i>
        Enrollment Trend by Semester & Year
    </div>
    <div class="card-body">
        <canvas id="semesterChart"
            data-municipality-id="{{ $municipality->citymun_code }}"
            data-chart-url="{{ route('admin.students.getSemesterChartData', $municipality->citymun_code) }}"
            width="100%" height="35"></canvas>
    </div>
</div>


    <div id="barangaySummary" class="mt-3 text-dark fw-bold"></div>

    <script>
        const countmunicipalBarangayCountsDataUrl = "{{ route('admin.students.municipalBarangayCounts') }}";
        const municipalStudentListDataUrl = "{{ route('admin.students.municipalStudentsList') }}";
        const municipalityId = "{{ $municipality->citymun_code }}";
    </script>
    <script src="{{ asset('admin/js/baranggaysCount.js') }}"></script>


<script>
function renderSemesterChart() {
    const canvas = document.getElementById('semesterChart');
    const municipalityId = canvas.dataset.municipalityId;

    fetch(`/admin/students/getSemesterChartData/${municipalityId}/chart-data`)
        .then(res => res.json())
        .then(data => {
            const labels = data.map(item => `${item.school_year} - ${item.semester}`);
            const counts = data.map(item => item.count);

            const ctx = canvas.getContext('2d');

            if (window.semesterChart instanceof Chart) {
                window.semesterChart.destroy();
            }

            window.semesterChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Enrolled Students',
                        data: counts,
                        backgroundColor: 'rgba(40,167,69,0.2)',
                        borderColor: 'rgba(40,167,69,1)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 5,
                        pointBackgroundColor: 'rgba(40,167,69,1)'
                    }]
                },
                options: {
                    scales: { 
                        y: { beginAtZero: true, ticks: { stepSize: 10 } } 
                    },
                    plugins: { legend: { display: true } }
                }
            });
        })
        .catch(err => console.error('Error loading chart data:', err));
}

document.addEventListener('DOMContentLoaded', renderSemesterChart);
</script>

@endsection
