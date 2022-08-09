<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Support\Str;
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
    public $isSetToDefaultHomePage;
    public $isSetToDefaultNotFoundPage;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'slug'  => ['required', Rule::unique('pages', 'slug')->ignore($this->pageModel?->id)],
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
        $this->slug = Str::slug($value);
    }

    /**
     * @param $value
     * @return void
     */
    public function updatedIsSetToDefaultHomePage($value)
    {
        $this->isSetToDefaultNotFoundPage = null;
    }

    /**
     * @param $value
     * @return void
     */
    public function updatedIsSetToDefaultNotFoundPage($value)
    {
        $this->isSetToDefaultHomePage = null;
    }

    /**
     * The create function
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        $this->unassignDefaultHomePage();
        $this->unassignDefaultNotFoundPage();
        Page::create($this->modelData());
        $this->modalFormVisible = false;
        $this->reset();
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
        $this->unassignDefaultHomePage();
        $this->unassignDefaultNotFoundPage();
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
        $this->reset();
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
        $this->reset();
        $this->pageModel = $page;
        $this->modalFormVisible = true;

        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->content = $page->content;
        $this->isSetToDefaultHomePage = !$page->is_default_home ? null : true;
        $this->isSetToDefaultNotFoundPage = !$page->is_default_not_found ? null : true;
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
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            'content'               => $this->content,
            'is_default_home'       => $this->isSetToDefaultHomePage,
            'is_default_not_found'  => $this->isSetToDefaultNotFoundPage
        ];
    }

    /**
     * Unassigns the default home page in the database table
     *
     * @return void
     */
    private function unassignDefaultHomePage()
    {
        if ($this->isSetToDefaultHomePage != null) {
            Page::where('is_default_home', true)->update([
                'is_default_home' => false,
            ]);
        }
    }

    /**
     * Unassigns the default 404 page in the database table
     *
     * @return void
     */
    private function unassignDefaultNotFoundPage()
    {
        if ($this->isSetToDefaultNotFoundPage != null) {
            Page::where('is_default_not_found', true)->update([
                'is_default_not_found' => false,
            ]);
        }
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
