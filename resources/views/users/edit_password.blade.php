@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <div class="container">
        <form action="{{ route('profile.update_password', $user_id) }}" method="post">
            @csrf
            @method('PATCH')
            <label for="old_password">Old Password</label>
            <input type="password" name="old_password" id="old-password" class="form-control" autofocus>
            @error('old_password')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
            <label for="new_password" class="mt-2">New Password</label>
            <input type="password" name="new_password" id="new-password" class="form-control">
            @error('new_password')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
            <label for="confirm_password" class="mt-2">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm-password" class="form-control mb-3">
            @error('confirm_password')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        
            {{-- show message --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session(('success')) }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session(('error')) }}
                </div>
            @endif
            @if(session('error2'))
                <div class="alert alert-danger">
                    {{ session(('error2')) }}
                </div>
            @endif
                   
            <button type="submit" name="save" class="btn btn-warning mt-2 px-5">Save</button>
        </form>
    </div>

@endsection