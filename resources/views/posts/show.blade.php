@extends('layouts.app')

@section('content')
<h1>{{ $post->title }}</h1>
<p class="mt-3">{{ $post->content }}</p>
<a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection