@extends('layouts.app')

@section('title', 'Profile')

@section('content')

    <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="row mt-2 mb-3">
            <div class="col-4">
                @if ($user->avatar)
                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->avatar }}" class="img-thumbnail w-100">
                @else
                    <i class="fa-solid fa-image fa-10x d-block text-center"></i>
                @endif
                <input type="file" name="avatar" aria-describedby="avatar-info" class="form-control mt-1">
                <div class="form-text" id="avatar-info">
                    Accceptable formats: jpeg, jpg, png and gif only <br>
                    Maximum file size: 1048kb
                @error('avatar')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label text-muted">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
            @error('name')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label text-muted">Email Address</label>
            <input type="text" name="email" id="emailv" class="form-control" value="{{ old('email', $user->email) }}">
            @error('email')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-warning px-5">Save</button>
        <a href="{{ route('profile.edit_password', $user->id) }}" class="btn btn-outline-warning text-dark">Change Password</a>
    </form>

@endsection