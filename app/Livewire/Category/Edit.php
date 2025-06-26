<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    public Category $category; // The category being edited
    public string $name = ''; // Add this
    public string $slug = ''; // Add this

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name; // Initialize form fields
        $this->slug = $category->slug;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $this->category->id,
        ]);

        $this->category->update([
            'name' => $this->name,
            'slug' => $this->slug,
        ]);

        session()->flash('message', 'Category updated successfully.');
        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.category.edit');
    }
}
