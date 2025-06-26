<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class Index extends Component
{
    use WithPagination;

    public $selectedCategories = [];
    public $selectAll = false;
    public $confirmingDelete = false;

    public function render()
    {
        return view('livewire.post.index', [
            'posts' => Post::latest()->paginate(10),
        ]);
    }

    public function confirmDelete($id = null)
    {
        if ($id) {
            $this->selectedCategories = [$id];
        }
        $this->confirmingDelete = true;
    }

    public function delete()
    {
        $categories = Post::whereIn('id', $this->selectedCategories)->first();

        $categories->delete();

        $this->selectedCategories = [];
        $this->selectAll = false;
        $this->confirmingDelete = false;

        session()->flash('message', 'Post deleted successfully.');
        $this->dispatch('refreshCategories');
    }
}
