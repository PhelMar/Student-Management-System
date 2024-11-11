@extends('layouts.user')

@section('title', 'User Dashboard')

@section('content')


<h1 class="mt-4">User Dashboard</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">User Dashboard</li>
</ol>
<div class="row">

    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
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

    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <i class="fas fa-people-group"></i> Total of IP's
                </div>
                <span id="ips-count" style="font-size: 20px;">0</span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('user.students.ipsdisplay')}}">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-wheelchair"></i> Total of PWD:
                </div>
                <span id="pwd-count" style="font-size: 20px;">0</span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>


    <div class="col-xl-3 col-md-6">
        <div class="card bg-secondary text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-user-friends"></i> Total of Solo Parent
                </div>
                <span id="solo-parent-count" style="font-size: 20px;">0</span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Area Chart Example
            </div>
            <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                Bar Chart Example
            </div>
            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
</div>

<script>
    const countPWDUrl = "{{ route('user.students.countPWD') }}";
    const countSoloParentUrl = "{{ route('user.students.countSoloParent') }}";
    const countIpsUrl = "{{ route('user.students.countIps') }}";
    const countTotalStudents = "{{ route('user.students.countActive') }}";
</script>

<script src="{{asset('user/js/dashboardFunction.js')}}"></script>



@endsection