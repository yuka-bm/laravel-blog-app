@extends('layouts.app')

@section('title', 'Home')

@section('content')

    @forelse($all_posts as $post)
        <div class="mt-2 border border-2 rounded py-2 px-4">
            <div class="row">
                <div class="col-3">
                @if ($post->image)
                    <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="img-thumbnail">
                @else
                    <i class="fa-solid fa-image fa-10x d-block text-center"></i>
                @endif
                </div>

                <div class="col">
                    <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">
                    @if ($post->user->avatar)
                        <img src="{{ asset('storage/avatars/' . $post->user->avatar) }}" alt="{{ $post->user->avatar }}" style="width: 35px;height: 35px;" class="rounded-circle">
                    @else
                        <i class="fa-solid fa-user fs-3 text-center"></i>
                    @endif
                    </a>
                    <a href="{{ route('post.show', $post->id) }}">
                        <span class="fs-4 ms-1">{{ $post->title }}</span>
                    </a>

                    <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none">
                        <h3 class="h6 text-mute mt-2">{{ $post->user->name }}</h3>
                    </a>
                    @if (strlen($post->body) > 150)
                        <p class="fw-light mb-0">{{ mb_substr($post->body, 0, 150) }}
                            <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none">
                                <span class="fs-5 ms-1">...</span>
                            </a>
                        </p>
                    @else
                        <p class="fw-light mb-0">{{ $post->body }}</p>
                    @endif
                </div>
            </div>
            <div class="row">
                {{-- Numbers of Comments --}}
                <div class="col d-flex align-items-end">
                    <div class="text-muted">
                        <i class="fa-regular fa-comment me-1"></i>{{ $post->comments->count() }}
                    </div>
                </div>

                {{-- Edit/Delete Button --}}
                <div class="col">
                {{-- if the owner of the post is the Auth::user --}}
                @if (Auth::user()->id === $post->user_id)
                    <div class="mt-2 text-end col">
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        <form action="{{ route('post.destroy', $post->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-trash-can"></i> Delete
                            </button>
                        </form>
                    </div>
                @endif
                </div>

            </div>
        </div>
    @empty
        <div style="margin-top: 100px;">
            <h2 class="text-muted text-center">No posts yet</h2>
            <p class="text-center">
                <a href="{{ route('post.create') }}" class="text-decoration-none">Create a new post.</a>
            </p>
        </div>
    @endforelse

    {{-- pagination --}}
    <div class="mt-3">
        {{ $all_posts->links() }}
    </div>

@endsection