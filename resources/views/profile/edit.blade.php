@extends('layouts.admin')
@section('title', 'Profile')
@section('content')
<x-slot name="header">
    <h2 class="fw-semibold h5 text-secondary">
        {{ __('Profile') }}
    </h2>
</x-slot>

<div class="py-5">
    <div class="container-lg space-y-4">
        <div class="p-4 p-lg-5 bg-white shadow rounded">
            <div class="w-100" style="max-width: 600px;">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 p-lg-5 bg-white shadow rounded">
            <div class="w-100" style="max-width: 600px;">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
</div>
@endsection