<?php

namespace App\Http\Livewire;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use DB;



class RolesController extends Component
{
    use WithPagination;

    public  $roleName, $search, $selected_id, $componentName, $pageTitle;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->componentName = "Roles";
        $this->pageTitle = 'Listado';

    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $roles = Role::where('name', 'like', '%'.$this->search.'%')->paginate($this->pagination);
        }else {
            $roles = Role::orderBy('name', 'asc')->paginate($this->pagination);
        }

        return view('livewire.roles.component',
         ['roles' => $roles ]
        )->extends('layouts.theme.app')->section('content');
    }
    public function CreateRole()
    {
        $rules = [
            'roleName' => 'required|unique:roles,name|min:2'
        ];
        $messages = [
            'roleName.required' => 'Nombre de rol requerido',
            'roleName.unique' => 'El nombre ingresado ya existe',
            'roleName.min' => 'El nombre debe de tener como minimo 2 caracteres',
        ];
        $this->validate($rules, $messages);
        Role::create(['name' => $this->roleName]);
        $this->emit('role-added', 'El rol se ha registrado con exito');
        $this->resetUI();
    }
    public function Edit($id)
    {
        $role = Role::find($id);
        $this->selected_id = $role->id;
        $this->roleName = $role->name;

        $this->emit('show-modal', 'ShowModal');
    }

    public function UpdateRole()
    {
        $rules = [
            'roleName' => "required|unique:roles,name, {$this->selected_id}|min:3"
        ];
        $messages = [
            'roleName.required' => 'Nombre requerido',
            'roleName.unique' => 'El nombre ingresado ya existe',
            'roleName.min' => 'El nombre debe de tener como minimo 2 caracteres',
        ];

        $this->validate($rules, $messages);

        $role = Role::find($this->selected_id);
        $role->name = $this->roleName;
        $role->save();
        $this->emit('role-updated', 'El rol se actualizo con exito');
        $this->resetUI();
    }
    protected $listeners=[
        'deleteRow' => 'destroy'
    ];

    public function destroy($id)
    {
        $permissionsCount = Role::find($id)->permissions->count();
        if ($permissionsCount > 0) {
            $this->emit('role-error', 'No se ´puede eliminar el rol porque tiene permisos asociados.');
            return;
        }
        Role::find($id)->delete();
        $this->emit('role-deleted', 'Rol eliminado correctamente.');
    }
    public function resetUI()
    {
        $this->roleName = "";
        $this->search = "";
        $this->selected_id = 0;
        $this->resetValidation();//elimina todos los errores que tendramos dentro del formulario //

    }
}
