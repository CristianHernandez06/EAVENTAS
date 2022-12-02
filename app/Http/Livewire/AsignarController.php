<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use DB;


class AsignarController extends Component
{
    use WithPagination;

    //definimos las propiedades publicas
    public $role, $componentName, $permisosSelected = [], $old_permissions=[], $listPermi;

    // definimos la paginacion en forma privada
    private $pagination = 10;

    //funcion de paginacion personalizado
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    //mount 
    public function mount()
    {
        $this->role = 'Elegir';
        $this->componentName = "Asignar Permisos";

        $permisos = Permission::select('name','id', DB::raw("0 as checked"))
        ->orderBy('name', 'asc')
        ->paginate($this->pagination);
       // dd(count($permisos));
    }


    //metodo render
    public function render()
    {
       
        $permisos = Permission::select('name','id', DB::raw("0 as checked"))
        ->orderBy('name', 'asc')
        ->paginate($this->pagination); //listado de permisos del sistema

        if($this->role !='Elegir'){
            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id','permissions.id')
            ->where('role_id', $this->role)->pluck('permissions.id')->toArray();
            $this->old_permissions = $list;
        }
        
        //mostramos los checkbox activos e inactivos
        if ($this->role !='Elegir')
        {
           
            foreach($permisos as $permiso)
            {
                $role = Role::find($this->role);
                //definimos la variable tiene permiso
                $tienePermiso=$role->hasPermissionTo($permiso->name);
               
                $permiso->checked = $tienePermiso ? 1 : 0;
            }
          
           

           
        }
      
//dd($count);/

        return view('livewire.asignar.component',[
            'roles' => Role::orderBy('name', 'asc')->get(),
            'permisos'=>$permisos
        ])
        ->extends('layouts.theme.app')
        ->section('content'); 
        
    }

    //metodo listeners
    public $listeners = ['revokeall'=>'RemoveAll'];

    //metodo removeall
    public function RemoveAll()
    {
        if($this->role == 'Elegir')
        {
            $this->emit('sync-error','debe escoger un rol valido');
            return;
        }
       
        $role = Role::find($this->role);

        $role->syncPermissions([0]); ///revocar todos los permisos
        $this->emit('removeall',"se revocaron todos los permisos a $role->name");
    }
    


        public function SyncAll()
    {
        
        if($this->role == 'Elegir')
        {
            $this->emit('sync-error','debe escoger un rol valido');
           return;
      }

       $role = Role::find($this->role);
       $permisos= Permission::pluck('id')->toArray();
       $role->syncPermissions($permisos);
       $this->emit('SyncAll',"se sincronizaron todos los permisos a: $role->name");
    }

  

    //funcion sincronizar permisos individualmente - funciona correctamente

    public function SyncPermiso($state, $permisoName) //esta función trae dos parametros, el parametro status y el parametro permisoName (nombre del permiso)
    {
        if($this->role !='Elegir'){
            $roleName = Role::find($this->role);
            if($state){
                //dd($permisoName);
                $roleName -> givePermissionTo($permisoName); 
                $this->emit('permi', "Permiso Asignado Correctamente");
            } else {
                $roleName -> RevokePermissionTo($permisoName); 
                $this->emit('permi', "Permiso Eliminado Correctamente");
            }
        } else{
            $this->emit('permi', "Elige un rol valido");
        }
    }
}
