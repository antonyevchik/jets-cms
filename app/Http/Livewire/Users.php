<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public bool $modalFormVisible = false;
    public bool $modalConfirmDeleteVisible = false;
    public ?User $Model = null;

    public $name;
    public $email;
    public $role;

    /**
     * The validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required',
            'email' => 'required',
            'role'  => 'required',
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
            'name'  => $this->name,
            'email' => $this->email,
            'role'  => $this->role,
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
        User::create($this->modelData());
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
        return User::paginate(5);
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
     * @param User $model
     * @return void
     */
    public function updateShowModal(User $model)
    {
        $this->resetValidation();
        $this->reset();

        $this->Model = $model;
        $this->modalFormVisible = true;

        $this->name     = $model->name;
        $this->email    = $model->email;
        $this->role     = $model->role;
    }

    /**
     * Show delete confirmation modal.
     *
     * @param User $model
     * @return void
     */
    public function deleteShowModal(User $model)
    {
        $this->Model = $model;
        $this->modalConfirmDeleteVisible = true;
    }

    public function render()
    {
        return view('livewire.users', [
            'data'  => $this->read(),
            'roles' => User::userRoleList(),
        ]);
    }
}
