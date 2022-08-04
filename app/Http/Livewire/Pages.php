<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Pages extends Component
{
    use WithPagination;

    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;
    public ?Page $pageModel = null;
    public $slug;
    public $title;
    public $content;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'slug'  => ['required', Rule::unique('pages', 'slug')->ignore($this->pageModel->id)],
            'content'   => 'required',
        ];
    }

    /**
     * The Livewire mount function
     *
     * @return void
     */
    public function mount()
    {
        //Resets the pagination after reloading page
        $this->resetPage();
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
     * The read function.
     *
     * @return mixed
     */
    public function read()
    {
        return Page::paginate(5);
    }

    /**
     * Update function.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        $this->pageModel->update($this->modelData());
        $this->modalFormVisible = false;
    }

    /**
     * Delete function.
     *
     * @return void
     */
    public function delete()
    {
        $this->pageModel->delete();
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    /**
     * Show the form modal of the create function
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modalFormVisible = true;
    }

    /**
     * Shows the form modal in update mode.
     *
     * @param Page $page
     * @return void
     */
    public function updateShowModal(Page $page)
    {
        $this->resetValidation();
        $this->resetVars();
        $this->pageModel = $page;
        $this->modalFormVisible = true;

        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->content = $page->content;
    }

    /**
     * Show delete confirmation modal.
     *
     * @param Page $page
     * @return void
     */
    public function deleteShowModal(Page $page)
    {
        $this->pageModel = $page;
        $this->modalConfirmDeleteVisible = true;
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
        $this->page = null;
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
        return view('livewire.pages', [
            'data' => $this->read(),
        ]);
    }
}
