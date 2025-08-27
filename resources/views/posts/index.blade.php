@extends('layouts.app')

@section('content')
<h1 class="mb-4">All Posts</h1>
@auth
@if(Auth::user()->role === 'admin')
<a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">
  Create Post</a>
@endif
@endauth

<div class="row g-4">
  @foreach ($posts as $post)
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card h-100 shadow-sm">
      @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
      @endif

      <div class="card-body d-flex flex-column">
        <h2 class="card-title fw-bold">
          <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">{{ $post->title }}</a>
        </h2>
        <p class="card-text text-truncate mb-3">{{ Str::limit($post->content, 120) }}</p>

        <div class="mt-auto d-flex justify-content-between align-items-center">
          <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary btn-sm">
            Read More
          </a>

          @auth
          @if(Auth::user()->role === 'admin')
          <div class="d-flex">
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm me-1">
              <i class="bi bi-pencil-square"></i> Edit
            </a>
            <form action="{{ route('posts.destroy', $post) }}" method="POST">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i> Delete
              </button>
            </form>
          </div>
          @endif
          @endauth
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

<div class="mt-3">
  {{ $posts->links() }}
</div>
@endsection