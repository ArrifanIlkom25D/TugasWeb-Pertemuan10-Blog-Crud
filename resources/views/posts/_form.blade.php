{{-- Partial form dipakai oleh create & edit. Variabel $post opsional. --}}
<div class="mb-3">
    <label for="title" class="form-label">Judul</label>
    <input type="text" id="title" name="title"
           class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $post->title ?? '') }}">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="content" class="form-label">Konten</label>
    <textarea id="content" name="content" rows="6"
              class="form-control @error('content') is-invalid @enderror">{{ old('content', $post->content ?? '') }}</textarea>
    @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="image" class="form-label">Gambar (opsional)</label>
    <input type="file" id="image" name="image"
           class="form-control @error('image') is-invalid @enderror">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if (!empty($post?->image))
        <img src="{{ asset('storage/' . $post->image) }}" class="img-thumbnail mt-2" style="max-height:120px" alt="">
    @endif
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('posts.index') }}" class="btn btn-secondary">Batal</a>
