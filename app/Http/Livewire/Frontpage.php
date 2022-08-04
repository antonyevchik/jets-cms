<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;

class Frontpage extends Component
{
    public $title;
    public $content;

    /**
     * The livewire mount function.
     *
     * @param $urlslug
     * @return void
     */
    public function mount($urlslug)
    {
        $this->retrieveContent($urlslug);
    }

    /**
     * Retrieves the content of the page.
     *
     * @param $urlslug
     * @return void
     */
    public function retrieveContent($urlslug)
    {
        $data = Page::where('slug', $urlslug)->first();
        $this->title = $data->title;
        $this->content = $data->content;
    }

    /**
     * The livewire render function.
     *
     * @return mixed
     */
    public function render()
    {
        return view('livewire.frontpage')->layout('layouts.frontpage');
    }
}
