<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Rule; // For Laravel 11 style validation

class Create extends Component
{
    #[Rule('required|string|max:255|unique:categories,name')]
    public $name = '';

    #[Rule('required|string|max:255|unique:categories,slug')]
    public $slug = '';

    public function render()
    {
        return view('livewire.category.create');
    }

    public function save()
    {
        // Laravel 11 style validation:
        $this->validate();

        Category::create([
            'name' => $this->name,
            'slug' => $this->slug
        ]);

        session()->flash('success', 'Category created successfully.');
        return $this->redirect(route('categories.index'), navigate: true);
    }

    // Optional: Reset the form after submission
    public function resetForm()
    {
        $this->reset('name', 'slug');
        $this->resetValidation();
    }
}
