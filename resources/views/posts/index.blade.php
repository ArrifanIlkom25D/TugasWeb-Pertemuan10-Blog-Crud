@extends('layouts.app')

@section('title', 'Daftar Post')

@section('content')
    {{-- Bonus: pencarian --}}
    <form method="GET" action="{{ route('posts.index') }}" class="row g-2 mb-4">
        <div class="col-md-9">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                   placeholder="Cari judul / konten...">
        </div>
        <div class="col-md-3 d-grid">
            <button class="btn btn-dark">Cari</button>
        </div>
    </form>

    <div class="row g-3">
        @forelse ($posts as $post)
            <div class="col-md-4">
                {{-- Component 2: Card --}}
                <x-card :title="$post->title">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded mb-2" alt="{{ $post->title }}">
                    @endif
                    <p class="text-muted mb-0">{{ Str::limit($post->content, 100) }}</p>

                    <x-slot:footer>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus post ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </x-slot:footer>
                </x-card>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-secondary">Belum ada post.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endsection
