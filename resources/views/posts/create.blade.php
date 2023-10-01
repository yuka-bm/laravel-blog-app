@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label text-secondary">Title</label>
            <input for="text" class="form-control" name="title" id="title" placeholder="Enter title here" value="{{ old('title') }}" autofocus></input>
            @error('title')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="body" class="form-label text-secondary">Body</label>
            <textarea name="body" id="body"  rows="5" class="form-control" placeholder="Start writing...">{{ old('title') }}</textarea>
            @error('body')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label fw-bold">Image</label>
            <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
            <div class="form-text" id="image-info">
                Acceptable formats are jpeg, jpg, png and gif only. <br>
                Maximun file size is 1048kb.
            </div>
            @error('image')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <button class="btn btn-primary px-5">Post</button>
    </form>


@endsection