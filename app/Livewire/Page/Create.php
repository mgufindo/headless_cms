<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Page;
use Illuminate\Support\Str;

class Create extends Component
{
    public $title;
    public $slug;
    public $body;
    public $status = true;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'body' => 'required',
    ];

    public function save()
    {
        $this->validate();

        Page::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'body' => $this->body,
            'status' => $this->status ? '1' : '0',
        ]);

        session()->flash('message', 'Page created successfully!');
        return redirect()->route('pages.index');
    }
}
