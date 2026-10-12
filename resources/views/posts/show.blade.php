@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <x-card :title="$post->title">
        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded mb-3" alt="{{ $post->title }}">
        @endif

        <p style="white-space: pre-line">{{ $post->content }}</p>
        <small class="text-muted">Dibuat: {{ $post->created_at->format('d M Y H:i') }}</small>

        <x-slot:footer>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Edit</a>
        </x-slot:footer>
    </x-card>
@endsection
