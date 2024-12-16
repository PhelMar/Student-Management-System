@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')


<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>
<div class="row">

    <div class="col-xl-4 col-md-6">
        <div class="card bg-primary text-white mb-4 shadow">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <i class="fas fa-users"></i> Total of Students
                </div>
                <span id="active-count" style="font-size: 20px;">0</span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card bg-warning text-white mb-4 shadow">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <i class="fas fa-people-group"></i> Total of IP's
                </div>
                <span id="ips-count" style="font-size: 20px;">0</span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('admin.students.ipsdisplay')}}">View
                    Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card bg-success text-white mb-4 shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-wheelchair"></i> Total of PWD:
                </div>
                <span id="pwd-count" style="font-size: 20px;">0</span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('admin.students.pwddisplay')}}">View
                    Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>


    <div class="col-xl-4 col-md-6">
        <div class="card bg-secondary text-white mb-4 shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-user-friends"></i> Total of Solo Parent
                </div>
                <span id="solo-parent-count" style="font-size: 20px;">0</span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('admin.students.soloparentdisplay')}}">View
                    Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card bg-warning text-white mb-4 shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-users"></i> Total of 4p's student
                </div>
                <span id="four-ps-count" style="font-size: 20px;">0</span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('admin.students.fourpsdisplay')}}">View
                    Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card bg-success text-white mb-4 shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-user-graduate"></i> Total Number of Scholar Students
                </div>
                <span id="scholar-count" style="font-size: 20px;">0</span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('admin.students.scholardisplay')}}">View
                    Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-xl-6">
        <div class="card mb-4 shadow">
            <div class="card-header text-white" style="background-color: #0A7075">
                <i class="fas fa-chart-area me-1"></i>
                Violations Chart Data Daily
            </div>
            <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card mb-4 shadow">
            <div class="card-header text-white" style="background-color: #0A7075">
                <i class="fas fa-chart-bar me-1"></i>
                Violations Chart Data Monthly
            </div>
            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
</div>
<div class="row d-flex align-items-center justify-content-center">
    <div class="col-xl-9">
        <div class="card mb-4 shadow">
            <div class="card-header text-white" style="background-color: #0A7075">
                <i class="fas fa-chart-bar me-1"></i>
                Total of Students
            </div>
            <div class="card-body"><canvas id="myAreaChartStudents" width="100%" height="40"></canvas></div>
        </div>
    </div>
</div>
<div id="municipality-cards-container">
    <div class="row">

    </div>
</div>

<script>
    const countPWDUrl = "{{ route('admin.students.countPWD') }}";
    const countSoloParentUrl = "{{ route('admin.students.countSoloParent') }}";
    const countIpsUrl = "{{ route('admin.students.countIps') }}";
    const countFourpsUrl = "{{ route('admin.students.countFourps') }}";
    const countScholarUrl = "{{ route('admin.students.countScholar') }}";
    const countTotalStudents = "{{ route('admin.students.countActive') }}";
    const violationsDataUrl = "{{ route('admin.violations.chart-data') }}";
    const totalStudentsDataUrl = "{{ route('admin.totalStudents.chart-data') }}";
    const violationsBarDataUrl = "{{ route('admin.violations.bar-data') }}";
    const countByMunicipalDataUrl = "{{ route('admin.students.getMunicipalStudentCount') }}";
</script>

<script src="{{asset('admin/js/dashboardFunction.js')}}"></script>
<script src="{{asset('admin/js/chart-area-demo-violations.js')}}"></script>
<script src="{{asset('admin/js/chart-area-demo-total-students.js')}}"></script>
<script src="{{asset('admin/js/chart-bar-demo.js')}}"></script>



@endsection