<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use Livewire\Component;
use Livewire\WithFileUploads; //trait para subir imagenes
use Livewire\WithPagination;
// para la paginacion

class CoinsController extends Component
{
    use WithFileUploads;
    use withPagination;

    public $type, $value, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Denominaciones';
        $this->selected_id = 'Seleccionar';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Denomination::where('type', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $data = Denomination::orderby('id', 'asc')->paginate($this->pagination);
        }

        return view('livewire.denominations.component', ['data' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    //Edith Method

    public function Edit($id)
    {
        $record = Denomination::find($id);
        //dd($record->toArray()); //para ver si genero la consulta
        /*$this->type = $record->type;
        $this->value = $record->value;
        $this->image = null;
        $this->selected_id = $record->id;*/
        // emitir un evento

        $this->selected_id = $record->id;
        $this->type = $record->type;
        $this->value = $record->value;
        $this->image = null;
        $this->emit('show-modal', 'Muestra modal');
    }

    public function Update()
    {

        $rules = [
            'type' => 'required|not_in:Seleccionar',
            'value' => "required|unique:denominations,value,{$this->selected_id}",
        ];

        $messages = [
            'type.required' => 'El tipo es requerido',
            'type.not_in' => 'Elige un valor para tipo distinto de Seleccionar',
            'value.required' => 'El valor es requerido',
            'value.unique' => 'Ya existe el valor',
        ];

        $this->validate($rules, $messages);

        // ACTUALIZAMOS LA CATEGORIA
        $denomination = Denomination::find($this->selected_id);
        $denomination->update(['type' => $this->type]);
        $denomination->update(['value' => $this->value]);

        // PARA ACTUALIZAR LA IMAGEN
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denomination', $customFileName);
            // IMAGEN ANTERIOR
            $imageName = $denomination->image;
            // NUEVA IMAGEN
            $denomination->image = $customFileName;
            $denomination->save();

            // SI EXISTE PARA PODER ELIMINARLA
            if ($imageName != null) {
                if (file_exists('storage/denomination' . $imageName)) {
                    // ELIMINAMOS LA IMAGEN
                    unlink('storage/denomination' . $imageName);
                }
            }
        }
        // LIMPIAMOS LAS CAJAS DE TEXTOS
        $this->resetUI();
        $this->emit('denomination-updated', 'Denominación Actualizada');
    }

    public function Store()
    {

        //primero validamos que el name sea ingresado si o si que no quede null
        $rules = [
            'type' => 'required|not_in:Seleccionar',
            'value' => 'required|unique:denominations',
        ];

        $messages = [
            'type.required' => 'El tipo es requerido',
            'type.not_in' => 'Elige un valor diferente para el tipo que no sea Seleccionar',
            'value.required' => 'El valor es requerido',
            'value.unique' => 'Ya existe un valor igual al que desea registrar',

        ];
        //ejecutamos las validaciones
        $this->validate($rules, $messages);

        //si pasamos todas las validaciones realizamos el registro
        $denomination = Denomination::create([
            'type' => $this->type,
            'value' => $this->value,
        ]);

        //image

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denomination', $customFileName);
            $denomination->image = $customFileName;
            $denomination->save();

        }

        $this->ResetUI();
        $this->emit('denomination-added', 'Denominación Registrada');
    }

    //funcion resetUI
    public function ResetUI()
    {
        $this->type = '';
        $this->value = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy',
    ];

    public function Destroy(Denomination $denomination)
    {

        $imageName = $denomination->image; //creamos una imagen temporal para despues eliminarla
        $denomination->delete();

        if ($imageName != null) {
            unlink('storage/denomination/' . $imageName);
        }

        //reinicializamos
        $this->ResetUI();
        $this->emit('denomination-delete', 'Denominación Eliminada');
    }
}
