<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Pages extends Component
{
    public $modalFormVisible = false;
    public $slug;
    public $title;
    public $content;

    public function rules()
    {
        return [
            'title' => 'required',
            'slug'  => ['required', Rule::unique('pages', 'slug')],
            'content'   => 'required',
        ];
    }

    /**
     * Runs everytime the title
     * variable is updated
     *
     * @param $value
     *
     * @return void
     */
    public function updatedTitle($value)
    {
        $this->slug = $this->generateSlug($value);
    }

    /**
     * The create function
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        Page::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetVars();
    }

    /**
     * Show the form modal of the create function
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }

    /**
     * The data for the model mapped
     * in this component
     *
     * @return array
     */
    public function modelData()
    {
        return [
            'title' => $this->title,
            'slug'  => $this->slug,
            'content'   => $this->content,
        ];
    }

    /**
     *  Reset all variables to null
     *
     * @return void
     */
    public function resetVars()
    {
        $this->title = null;
        $this->slug = null;
        $this->content = null;
    }

    /**
     *  Slug generator
     *
     * @param $value
     *
     * @return string
     */
    private function generateSlug($value)
    {
        $dashed = str_replace(' ', '-', $value);

        return strtolower($dashed);
    }

    /**
     * The livewire render function
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.pages');
    }
}
