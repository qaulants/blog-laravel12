@extends('layouts.app')

@section('content')
<h1>Create Post</h1>
<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control rounded-3 border border-secondary" id="title" required>

  </div>
  <div class="mb-3">
    <label class="form-label">Image</label>
    <input type="file" name="image" class="form-control" accept="image/*">
  </div>

  <div class="mb-3">
    <label class="form-label">Content</label>
    <textarea name="content" rows="5" class="form-control border border-secondary" required></textarea>
  </div>
  <button class="btn btn-success">Save</button>

</form>
@endsection