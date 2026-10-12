<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    private function rules(): array
    {
        return [
            'title'   => 'required|string|min:5|max:150',
            'content' => 'required|string|min:10',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    private function messages(): array
    {
        return [
            'title.required'   => 'Judul wajib diisi.',
            'title.min'        => 'Judul minimal 5 karakter.',
            'title.max'        => 'Judul maksimal 150 karakter.',
            'content.required' => 'Konten wajib diisi.',
            'content.min'      => 'Konten minimal 10 karakter.',
            'image.image'      => 'File harus berupa gambar.',
            'image.mimes'      => 'Format gambar: jpg, jpeg, png, webp.',
            'image.max'        => 'Ukuran gambar maksimal 2 MB.',
        ];
    }

    // 1. index: daftar + pencarian + pagination
    public function index(Request $request)
    {
        $posts = Post::query()
            ->when($request->q, function ($query, $search) {
                $query->where(function ($w) use ($search) {
                    $w->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('posts.index', compact('posts'));
    }

    // 2. create: form tambah
    public function create()
    {
        return view('posts.create');
    }

    // 3. store: simpan data
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        try {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('posts', 'public');
            }
            Post::create($data);
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan post: ' . $e->getMessage());
        }

        return redirect()->route('posts.index')->with('success', 'Post berhasil ditambahkan.');
    }

    // 4. show: detail (Route Model Binding)
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // 5. edit: form ubah (Route Model Binding)
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    // 6. update: simpan perubahan
    public function update(Request $request, Post $post)
    {
        $data = $request->validate($this->rules(), $this->messages());

        try {
            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $data['image'] = $request->file('image')->store('posts', 'public');
            }
            $post->update($data);
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Gagal mengubah post: ' . $e->getMessage());
        }

        return redirect()->route('posts.show', $post)->with('success', 'Post berhasil diperbarui.');
    }

    // 7. destroy: hapus (soft delete)
    public function destroy(Post $post)
    {
        try {
            $post->delete();
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus post.');
        }

        return redirect()->route('posts.index')->with('success', 'Post berhasil dihapus.');
    }
}
