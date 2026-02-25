<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function __construct()
    {
        // Double check for security, though routes will also handle this.
        // Assuming 'role' middleware from Spatie or similar package is available.
        // If not, we can use a closure or check in each method.
        // Given existing code uses 'restrict.admin.chef.driver' and similar custom middleware, 
        // we will enforce a check in the actions for safety.
        $this->middleware('auth');
    }

    private function ensureSuperAdmin()
    {
        if (!auth()->user() || !auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index()
    {
        $this->ensureSuperAdmin();
        $posts = BlogPost::latest()->paginate(10);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        $this->ensureSuperAdmin();
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $this->ensureSuperAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'content', 'excerpt']);
        $data['slug'] = Str::slug($request->title) . '-' . time();
        $data['user_id'] = Auth::id();
        $data['is_published'] = $request->has('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog_images', 'public');
            $data['image_path'] = $imagePath;
        }

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(BlogPost $blog)
    {
        $this->ensureSuperAdmin();
        return view('admin.blog.edit', ['blogPost' => $blog]);
    }

    public function update(Request $request, BlogPost $blog)
    {
        $this->ensureSuperAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'content', 'excerpt']);

        if ($request->title !== $blog->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }

        $data['is_published'] = $request->has('is_published');

        // Handle publishing date logic
        if ($data['is_published'] && !$blog->is_published) {
            $data['published_at'] = now();
        } elseif (!$data['is_published']) {
            $data['published_at'] = null;
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($blog->image_path) {
                Storage::disk('public')->delete($blog->image_path);
            }
            $imagePath = $request->file('image')->store('blog_images', 'public');
            $data['image_path'] = $imagePath;
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blog)
    {
        $this->ensureSuperAdmin();

        if ($blog->image_path) {
            Storage::disk('public')->delete($blog->image_path);
        }

        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully.');
    }
}
