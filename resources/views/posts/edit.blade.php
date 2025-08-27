@extends('layouts.app')

@section('content')
<h1>Edit Post</h1>
<form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" class="form-control rounded-3 border border-secondary" name="title" value="{{ $post->title }}" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Image</label>
    @if($post->image)
    <div class="mb-2">
      <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid" style="max-height:150px;">
    </div>
    @endif
    <input type="file" name="image" class="form-control" accept="image/*">
  </div>

  <div class="mb-3">
    <label class="form-label">Content</label>
    <textarea class="form-control rounded-3 border border-secondary" name="content" rows="5" required>{{ $post->content }}</textarea>
  </div>

  <button class="btn btn-success">Update</button>
</form>
@endsection