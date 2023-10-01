@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

    <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="title" class="form-label text-secondary">Title</label>
            <input for="text" class="form-control" name="title" id="title" placeholder="Enter title here" value="{{ old('title', $post->title) }}" autofocus></input>
            @error('title')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="body" class="form-label text-secondary">Body</label>
            <textarea name="body" id="body"  rows="5" class="form-control" placeholder="Start writing...">{{ old('body', $post->body) }}</textarea>
            @error('body')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="image" class="form-label fw-bold">Image</label>
                <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="w-100 img-thumbnail">
                <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
                <div class="form-text" id="image-info">
                    Acceptable formats are jpeg, jpg, png and gif only. <br>
                    Maximun file size is 1048kb.
                </div>
                @error('image')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button class="btn btn-warning px-5">Save</button>
    </form>

@endsection