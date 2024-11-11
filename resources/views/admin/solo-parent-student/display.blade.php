@extends('layouts.admin')
@section('title', 'Solo-Parent Student')

@section('content')
<h1 class="mt-4">Solo-Parent Students List</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Solo-Parent Students List</li>
</ol>
@if (session('success'))
<div id="success-alert" class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif
<div class="row justify-content-end align-items-center mb-3">
    <div class="col-sm-4">
        <select name="school_year_id" id="school_year_id" class="form-control">
            <option value="" selected>Select School Year</option>
            @foreach ($school_years as $school_year)
            <option value="{{$school_year->id}}">{{$school_year->school_year_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-auto">
        <button id="printButton" class="btn btn-primary">Print</button>
    </div>
</div>


<div class="card card-mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Solo-Parent Students
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>LAST NAME</th>
                    <th>FIRST NAME</th>
                    <th>COURSE</th>
                    <th>YEAR LEVEL</th>
                    <th>SEMESTER</th>
                    <th>SCHOOL YEAR</th>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>LAST NAME</th>
                    <th>FIRST NAME</th>
                    <th>COURSE</th>
                    <th>YEAR LEVEL</th>
                    <th>SEMESTER</th>
                    <th>SCHOOL YEAR</th>

                </tr>
            </tfoot>
            <tbody>
                @foreach ($soloparentData as $soloparentdata)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$soloparentdata->last_name}}</td>
                    <td>{{$soloparentdata->first_name}}</td>
                    <td>{{$soloparentdata->course->course_name}}</td>
                    <td>{{$soloparentdata->year->year_name}}</td>
                    <td>{{$soloparentdata->semester->semester_name}}</td>
                    <td>{{$soloparentdata->school_year->school_year_name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="{{asset('admin/js/soloparentFunction.js')}}" ></script>

@endsection