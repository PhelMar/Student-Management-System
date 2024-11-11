@extends('layouts.admin')
@section('title', 'View Student Organization')

@section('content')
<h1 class="mt-4">Student Organization List</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Student Organization List</li>
</ol>
@if (session('success'))
<div id="success-alert" class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif
<div class="card card-mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Organizations Student View
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID NO</th>
                    <th>NAME</th>
                    <th>COURSE</th>
                    <th>YEAR LEVEL</th>
                    <th>SEMESTER</th>
                    <th>SCHOOL YEAR</th>
                    <th>ORGANIZATIONS</th>
                    <th>POSITIONS</th>
                    <th>DATE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>ID NO</th>
                    <th>NAME</th>
                    <th>COURSE</th>
                    <th>YEAR LEVEL</th>
                    <th>SEMESTER</th>
                    <th>SCHOOL YEAR</th>
                    <th>ORGANIZATIONS</th>
                    <th>POSITIONS</th>
                    <th>DATE</th>
                    <th>ACTION</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($organizationData as $organizations)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$organizations->student->id_no ?? 'N/A'}}</td>
                    <td>{{$organizations->student ? $organizations->student->last_name . ', ' . $organizations->student->first_name : 'N/A'}}</td>
                    <td>{{$organizations->course->course_name ?? 'N/A'}}</td>
                    <td>{{$organizations->year->year_name ?? 'N/A'}}</td>
                    <td>{{$organizations->semester->semester_name ?? 'N/A'}}</td>
                    <td>{{$organizations->school_year->school_year_name ?? 'N/A'}}</td>
                    <td>{{$organizations->organizationType->organization_name ?? 'N/A'}}</td>
                    <td>{{$organizations->position->positions_name ?? 'N/A'}}</td>
                    <td>{{$organizations->organization_date}}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{$organizations->id}}')">Delete</a>
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

    function confirmDelete(organizationId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete student!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ url('admin/organizations/delete') }}/" + organizationId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', 'Organization has been deleted.', 'success');
                    location.reload();
                } else {
                    Swal.fire('Error', 'There was an issue deleting the organization.', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'There was an issue deleting the organization.', 'error');
                console.error('Error:', error);
            });
        }
    });
}

</script>


@endsection