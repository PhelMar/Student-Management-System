@extends('layouts.admin')
@section('title', 'Profile View')

@section('content')
<h1 class="mt-4">Profile View</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Profile View</li>
</ol>
@if (session('success'))
<div id="success-alert" class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif

<div class="card card-mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Users View
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NAME</th>
                    <th>ROLE</th>
                    <th>CREATED</th>
                    <th>UPDATED</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>NAME</th>
                    <th>ROLE</th>
                    <th>CREATED</th>
                    <th>UPDATED</th>
                    <th>ACTION</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($profileData as $profile)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$profile->name}}</td>
                    <td>{{$profile->role}}</td>
                    <td>{{$profile->created_at}}</td>
                    <td>{{$profile->updated_at}}</td>
                    <td>
                        <a href="{{route('admin.profile.edit')}}" class="btn btn-warning">Edit</a>
                        <a href="javascript:void(0)" onclick="confirmDelete('{{$profile->id}}')" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function confirmDelete(profileId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete user!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ url('admin/profile/delete') }}/" + profileId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Profile User has been deleted.', 'success');
                            window.location.href = "{{ route('admin.profile.display') }}";
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the user.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the user.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>
@endsection