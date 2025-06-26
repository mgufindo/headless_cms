<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Page;
use Illuminate\Support\Str;

class Edit extends Component
{
    public $page;
    public $title;
    public $slug;
    public $body;
    public $status = true;

    public function mount($page)
    {
        $this->page = Page::findOrFail($page);
        $this->title = $this->page->title;
        $this->slug = $this->page->slug;
        $this->body = $this->page->body;
        $this->status = $this->page->status == '1';
    }

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'slug' => 'required|min:3|max:255',
        'body' => 'required',
    ];

    public function update()
    {
        $this->validate();

        $this->page->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'status' => $this->status ? '1' : '0',
        ]);

        session()->flash('message', 'Page updated successfully!');
        return redirect()->route('pages.index');
    }

    public function render()
    {
        return view('livewire.page.edit');
    }
}
