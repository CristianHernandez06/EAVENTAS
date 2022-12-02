<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use App\Models\User;
use Livewire\Component; //trait para subir imagenes
use Livewire\WithFileUploads; // para la paginacion
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UsersController extends Component
{
    use WithFileUploads;
    use withPagination;

    public $name, $phone, $email, $status, $image, $password, $selected_id, $componentName, $fileLoaded, $profile, $pageTitle, $search;
    private $pagination = 5;

    //paginación
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    //metodo mount - titulo del modulo
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Usuarios';
        $this->status = 'Elegir';

    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = User::where('name', 'like', '%' . $this->search . '%')
                ->select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = User::select('*')->orderby('id', 'asc')->paginate($this->pagination);
        }

        return view('livewire.users.component', [
            'data' => $data,
            'roles' => Role::orderBy('name', 'asc')->get(),
        ])
            ->extends('layouts.theme.app')
            ->section('content');

    }

    //reseteamos todos los valores a 0
    public function ResetUI()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->image = '';
        $this->search = '';
        $this->status = 'Elegir';
        $this->profile = 'Elegir';
        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();

    }

    //metodo edit
    public function edit(User $user)
    {

        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $user->profile;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->image = $user->image;
        $this->password = '';
        $this->emit('show-modal', 'open!');
    }

    //mandamos a llamar a los listeners
    protected $listeners = [
        'deleterow' => 'destroy',
        'ResetUI' => 'ResetUI',
    ];

    //metodo store (almacenar los datos de nuevos usuarios)
    public function Store()
    {
        //dd($this->profile);
        //reglas de validacion de campos requeridos
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3',
        ];

        //mensajes de validacion
        $messages = [
            'name.required' => 'Ingrese el nombre de usuario',
            'name.min' => 'El nombre de usuario debe tener al menos 3 carácteres',
            'email.required' => 'Ingrese un correo valido',
            'email.email' => 'Ingrese un correo valido',
            'email.unique' => 'El email ingresado ya existe en el sistema',
            'status.required' => 'Seleccione el status para el usuario',
            'status.not_in' => 'Seleccione el status',
            'profile.required' => 'Selecciona el perfil del usuario',
            'profile.not_in' => 'Seleccione un perfil diferente a Elegir',
            'password.required' => 'Ingrese el password',
            'password.min' => 'El password debe tener al menos 3 carácteres',

        ];
        $this->validate($rules, $messages);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password), //encryptamos la pass

        ]);
        $user->syncRoles($this->profile);

        //validamos el avatar
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $user->image = $customFileName;
            $user->save();
        }

        $this->ResetUI();
        $this->emit('user-added', 'Usuario Registrado');
    }

    //Metodo Update
    public function Update()
    {
        //reglas de validacion de campos requeridos
        $rules = [
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'name' => 'required|min:3',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3',
        ];

        //mensajes de validacion
        $messages = [
            'name.required' => 'Ingrese el nombre de usuario',
            'name.min' => 'El nombre de usuario debe tener al menos 3 carácteres',
            'email.required' => 'Ingrese un correo valido',
            'email.email' => 'Ingrese un correo valido',
            'email.unique' => 'El email ingresado ya existe en el sistema',
            'status.required' => 'Seleccione el status para el usuario',
            'status.not_in' => 'Seleccione el status',
            'profile.required' => 'Selecciona el perfil del usuario',
            'profile.not_in' => 'Seleccione un perfil diferente a Elegir',
            'password.required' => 'Ingrese el password',
            'password.min' => 'El password debe tener al menos 3 carácteres',

        ];
        $this->validate($rules, $messages);

        $user = User::find($this->selected_id);
        $user->update([
            $user->name = $this->name,
            $user->phone = $this->phone,
            $user->profile = $this->profile,
            $user->status = $this->status,
            //$user->image = $this->image,
            $user->email = $this->email,
            $user->password = bcrypt($this->password),
            $user->save(),
        ]);
        $user->syncRoles($this->profile);

        //validamos el avatar
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $imageName = $user->image;
            $imageTemp = $user->image;
            $user->image = $customFileName;
            $user->save();

            if ($imageTemp != null) {
                if (file_exists('storage/users/' . $imageTemp)) {
                    unlink('storage/users/' . $imageTemp); //eliminamos la imagen anterior
                }
            }

        }

        $this->ResetUI();
        $this->emit('user-updated', 'Se actualizó la información del usuario');

    }

    public function destroy(User $user)
    {
        if ($user) {
            $sales = Sale::where('user_id', $user->id)->count();
            if ($sales > 0) {
                $this->emit('user-withsales', 'No es posble eliminar el usuario porque tiene ventas registradas');
            } else {
                $user->delete();
                $this->resetUI();
                $this->emit('user-deleted', 'Se eliminó el usuario del sistema');
            }
        }
    }
}
