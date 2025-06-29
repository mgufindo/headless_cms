<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $slug;
    public $content;
    public $excerpt;
    public $image;
    public $status = 'draft';
    public $publishedAtShow = false;
    public $published_at;
    public $categories = [];
    public $selectedCategories = [];
    protected $listeners = ['updatedStatus'];

    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:posts,slug',
        'content' => 'required|string',
        'excerpt' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
        'status' => 'required|in:draft,published',
        'published_at' => 'nullable|date',
        'selectedCategories' => 'required|array|min:1',
    ];


    public function mount()
    {
        $this->categories = Category::all();
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate();

        $post = Post::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'status' => $this->status,
            'published_at' => $this->status === 'published' ? $this->published_at : null,
        ]);

        if ($this->image) {
            $path = $this->image->store('posts', 'public');
            $post->update(['image' => $path]);
        }



        $post->categories()->sync($this->selectedCategories);

        session()->flash('message', 'Post created successfully.');

        return redirect()->route('posts.index');
    }

    public function render()
    {
        return view('livewire.post.create');
    }

    public function updatePublishedAt($status)
    {

        if ($status == 'draft') {
            $this->publishedAtShow = false;
        } else {
            $this->publishedAtShow = true;
        }
    }
}
