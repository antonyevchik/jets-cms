<?php

namespace App\Http\Livewire;

use App\Models\NavigationMenu;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class NavigationMenus extends Component
{
    use WithPagination;

    public bool $modalFormVisible = false;
    public bool $modalConfirmDeleteVisible = false;
    public ?NavigationMenu $menuModel = null;
    public $type;
    public $label;
    public $sequence;
    public $slug;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'type'       => 'required',
            'label'      => 'required',
            'slug'       => ['required', Rule::unique('navigation_menus', 'slug')->ignore($this->menuModel?->id)],
            'sequence'   => 'required',
        ];
    }


    /**
     * @return void
     */
    public function mount()
    {
        //Resets the pagination after reloading page
        $this->resetPage();
    }

    public function create()
    {
        $this->validate();
        NavigationMenu::create($this->modelData());
        $this->modalFormVisible = false;
        $this->reset();
    }

    /**
     * The read function
     *
     * @return mixed
     */
    public function read()
    {
        return NavigationMenu::paginate(5);
    }

    /**
     * Update function.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        $this->menuModel->update($this->modelData());
        $this->modalFormVisible = false;
    }

    /**
     * Delete function.
     *
     * @return void
     */
    public function delete()
    {
        $this->menuModel->delete();
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }


    /**
     * Shows the create modal
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
     * @param NavigationMenu $menu
     * @return void
     */
    public function updateShowModal(NavigationMenu $menu)
    {
        $this->resetValidation();
        $this->reset();

        $this->menuModel = $menu;
        $this->modalFormVisible = true;

        $this->label    = $menu->label;
        $this->slug     = $menu->slug;
        $this->sequence = $menu->sequence;
    }

    /**
     * Show delete confirmation modal.
     *
     * @param Page $page
     * @return void
     */
    public function deleteShowModal(NavigationMenu $menu)
    {
        $this->menuModel = $menu;
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
            'label'        => $this->label,
            'slug'         => $this->slug,
            'sequence'     => $this->sequence,
            'type'         => $this->type,
        ];
    }

    public function render()
    {
        return view('livewire.navigation-menus', [
            'data' => $this->read(),
        ]);
    }
}
