<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermisosController extends Component
{
    use WithPagination;

    public $permissionName, $search, $selected_id, $componentName, $pageTitle;
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->componentName = "Permisos";
        $this->pageTitle = 'Listado';

    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $permisos = Permission::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $permisos = Permission::orderBy('name', 'asc')->paginate($this->pagination);
        }

        return view('livewire.permisos.component',
            ['permisos' => $permisos]
        )->extends('layouts.theme.app')->section('content');
    }
    public function CreatePermission()
    {
        $rules = [
            'permissionName' => 'required|unique:permissions,name|min:2',
        ];
        $messages = [
            'permissionName.required' => 'El nombre del permiso es requerido',
            'permissionName.unique' => 'El permiso ingresado ya existe',
            'permissionName.min' => 'El nombre del permiso debe de tener como minimo 2 caracteres',
        ];
        $this->validate($rules, $messages);
        Permission::create(['name' => $this->permissionName]);
        $this->emit('permiso-added', 'El permiso se ha registrado con exito');
        $this->resetUI();
    }
    public function Edit(Permission $permiso)
    {
        //$role = Role::find($id);
        $this->selected_id = $permiso->id;
        $this->permissionName = $permiso->name;

        $this->emit('show-modal', 'ShowModal');
    }

    public function UpdatePermission()
    {
        $rules = [
            'permissionName' => "required|unique:permissions,name, {$this->selected_id}|min:3",
        ];
        $messages = [
            'permissionName.required' => 'El nombre del permiso es requerido',
            'permissionName.unique' => 'El permiso ingresado ya existe',
            'permissionName.min' => 'El nombre del permiso debe de tener como minimo 2 caracteres',
        ];

        $this->validate($rules, $messages);

        $permiso = Permission::find($this->selected_id);
        $permiso->name = $this->permissionName;
        $permiso->save();
        $this->emit('permiso-updated', 'El permiso se actualizo con exito');
        $this->resetUI();
    }
    protected $listeners = [
        'deleteRow' => 'destroy',
    ];

    public function destroy($id)
    {
        $rolesCount = Permission::find($id)->getRoleNames()->count();
        if ($rolesCount > 0) {
            $this->emit('permiso-error', 'No se ´puede eliminar el permiso porque tiene roles asociados.');
            return;
        }
        Permission::find($id)->delete();
        $this->emit('permiso-deleted', 'Permiso eliminado correctamente.');
    }
    public function resetUI()
    {
        $this->permissionName = "";
        $this->search = "";
        $this->selected_id = 0;
        $this->resetValidation();

    }
}
