<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\UserPermission;
use Livewire\Component;
use Livewire\WithPagination;

class UserPermissions extends Component
{
    use WithPagination;

    public bool $modalFormVisible = false;
    public bool $modalConfirmDeleteVisible = false;
    public ?UserPermission $Model = null;

    public $role;
    public $routeName;

    /**
     * The validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role'      => 'required',
            'routeName' => 'required',
        ];
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
            'role'       => $this->role,
            'route_name' => $this->routeName,
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
        UserPermission::create($this->modelData());
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
        return UserPermission::paginate(5);
    }

    /**
     * Update function.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        $this->Model->update($this->modelData());
        $this->modalFormVisible = false;
    }

    /**
     * Delete function.
     *
     * @return void
     */
    public function delete()
    {
        $this->Model->delete();
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
     * @param UserPermission $model
     * @return void
     */
    public function updateShowModal(UserPermission $model)
    {
        $this->resetValidation();
        $this->reset();

        $this->Model = $model;
        $this->modalFormVisible = true;

        $this->role      = $model->role;
        $this->routeName = $model->route_name;
    }

    /**
     * Show delete confirmation modal.
     *
     * @param UserPermission $model
     * @return void
     */
    public function deleteShowModal(UserPermission $model)
    {
        $this->Model = $model;
        $this->modalConfirmDeleteVisible = true;
    }

    public function render()
    {
        return view('livewire.user-permissions', [
            'data' => $this->read(),
            'roles'         => User::userRoleList(),
            'routeNames'    => UserPermission::routeNameList(),
        ]);
    }
}
