@extends('layouts.user')
@section('title', 'View Student Clearance')

@section('content')
<h1 class="mt-4">Clearance Student List</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Clearance Student List</li>
</ol>
@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            Swal.fire({
                title: 'Success!',
                text: "{{session('success')}}",
                icon: 'success',
                confirmButtonText: 'OK',
                timer: 1200
            });
        });
    </script>
@endif
<div class="card card-mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Clearance Student View
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>CONTROL NO</th>
                    <th>NAME</th>
                    <th>COURSE</th>
                    <th>YEAR LEVEL</th>
                    <th>SEMESTER</th>
                    <th>SCHOOL YEAR</th>
                    <th>STATUS</th>
                    <th>DATE RELEASED</th>
                    <th>DATE CLEARED</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>CONTROL NO</th>
                    <th>NAME</th>
                    <th>COURSE</th>
                    <th>YEAR LEVEL</th>
                    <th>SEMESTER</th>
                    <th>SCHOOL YEAR</th>
                    <th>STATUS</th>
                    <th>DATE RELEASED</th>
                    <th>DATE CLEARED</th>
                    <th>ACTION</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($clearanceData as $clearance)
                <tr>
                    <td>{{$clearance->control_no}}</td>
                    <td>{{$clearance->student ? $clearance->student->last_name . ', ' . $clearance->student->first_name : 'N/A'}}</td>
                    <td>{{$clearance->course->course_name ?? 'N/A'}}</td>
                    <td>{{$clearance->year->year_name ?? 'N/A'}}</td>
                    <td>{{$clearance->semester->semester_name ?? 'N/A'}}</td>
                    <td>{{$clearance->school_year->school_year_name ?? 'N/A'}}</td>
                    <td>{{$clearance->status}}</td>
                    <td>{{$clearance->created_at}}</td>
                    <td>{{$clearance->updated_at}}</td>
                    <td>
                        @if ($clearance->status !== 'cleared')
                        <a href="javascript:void(0)" class="btn btn-warning" onclick="confirmCleared('{{$clearance->id}}')">Cleared</a>
                        @else
                        <button class="btn btn-secondary" disabled>Cleared</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        const successAlert = $('#success-alert');
        if (successAlert.length) {
            setTimeout(function() {
                successAlert.fadeOut();
            }, 3000);
        }
    });

    function confirmCleared(clearanceId) {
        Swal.fire({
            title: 'Is this student cleared?',
            text: "Make sure to check if all signatures are complete!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, clear the student!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ url('user/clearance/cleared') }}/" + clearanceId, {
                        method: 'get',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // For debugging
                        if (data.success) {
                            Swal.fire('Cleared!', data.message, 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue clearing the student.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>


@endsection