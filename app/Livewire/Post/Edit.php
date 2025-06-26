<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $post;
    public $title;
    public $slug;
    public $content;
    public $excerpt;
    public $image;
    public $existingImage;
    public $status = 'draft';
    public $publishedAtShow = false;
    public $published_at;
    public $categories = [];
    public $selectedCategories = [];
    protected $listeners = ['updatedStatus'];

    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:posts,slug,',
        'content' => 'required|string',
        'excerpt' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
        'status' => 'required|in:draft,published',
        'published_at' => 'nullable|date',
        'selectedCategories' => 'array',
    ];

    public function mount($post)
    {
        $this->post = $post;
        $post = Post::findOrFail($post);

        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->content = $post->content;
        $this->excerpt = $post->excerpt;
        $this->status = $post->status;
        $this->published_at = $post->published_at;
        $this->existingImage = $post->image;
        $this->selectedCategories = $post->categories->pluck('id')->toArray();

        $this->categories = Category::all();
        $this->publishedAtShow = $this->status === 'published';
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function update()
    {
        $this->rules['slug'] .= $this->post; // Add post to ignore unique rule for current post

        $this->validate();

        $post = Post::findOrFail($this->post);

        $postData = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'status' => $this->status,
            'published_at' => $this->status === 'published' ? $this->published_at : null,
        ];

        if ($this->image) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $path = $this->image->store('posts', 'public');
            $postData['image'] = $path;
        }

        $post->update($postData);

        $post->categories()->sync($this->selectedCategories);

        session()->flash('message', 'Post updated successfully.');

        return redirect()->route('posts.index');
    }

    public function render()
    {
        return view('livewire.post.edit');
    }

    public function updatePublishedAt($status)
    {
        if ($status == 'draft') {
            $this->publishedAtShow = false;
        } else {
            $this->publishedAtShow = true;
        }
    }

    public function removeImage()
    {
        $post = Post::findOrFail($this->post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
            $post->update(['image' => null]);
            $this->existingImage = null;
            $this->image = null;
        }
    }
}
