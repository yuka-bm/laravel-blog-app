@extends('layouts.app')

@section('title', 'Show Post')

@section('content')

    <div class="mt-2 border border-2 py-3 px-4 shadow-sm">
        <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">
        @if ($post->user->avatar)
            <img src="{{ asset('storage/avatars/' . $post->user->avatar) }}" alt="{{ $post->user->avatar }}" style="width: 35px;height: 35px;" class="rounded-circle">
        @else
            <i class="fa-solid fa-user fs-3 text-center"></i>
        @endif
        </a>
        <span class="h4 ms-1">{{ $post->title }}</span>
        <h3 class="h6 text-muted mt-2">by: 
            <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none">
                {{ $post->user->name }}
            </a>
        </h3>
        <p>{{ $post->body }}</p>

        <img src="{{ asset('/storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="w-100 shadow">
    </div>

    <form action="{{ route('comment.store', $post->id) }}" method="post">
        @csrf
        <div class="input-group mt-3">
            <input type="text" name="comment" id="comment" class="form-control" plageholder="Add a comment..." value="{{ old('comment') }}">
            <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
        </div>
        @error('comment')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </form>

    {{-- if the post has comments, show --}}
    @if ($post->comments)
        <div class="mt-2 mb-5">
            @foreach ($post->comments as $comment)
                <div class="row p-2">
                    <div class="col-10">
                        <span class="fw-bold">{{ $comment->user->name }}</span>
                        &nbsp
                        <span class="small text-muted">{{ $comment->created_at }}</span>
                        <div class="mb-0">{{ $comment->body }}</div>
                    </div>
                    <div class="col-2">
                        {{-- show a delete button if the Auth user is the owner of the comment --}}
                        @if ($comment->user_id === Auth::user()->id)
                        <div class="d-flex">
                            <button type="button" class="btn btn-primary btn-sm me-1" title="Edit comment" data-bs-toggle="modal" data-bs-target="#edit-comment-{{ $comment->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            @include('posts.modal.edit')
                            <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submut" class="btn btn-danger btn-sm" title="Delete comment">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
