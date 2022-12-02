<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; //trait para subir imagenes
use Livewire\WithPagination;// para la paginacion

class CategoriesController extends Component
{
    use WithFileUploads;
    use withPagination;


    public $name, $search,$image,$selected_id, $pageTitle,$componentName;
    private $pagination=5;


    public function mount()
    {
        $this->pageTitle ='Listado';
        $this->componentName ='Categorias';
    }


    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search)>0)
        $data = Category::where('name', 'like', '%' .$this->search. '%')->paginate($this->pagination);
        else
        $data = Category::orderby('id','asc')->paginate($this->pagination);

        return view('livewire.category.categories', ['categories'=>$data])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    //Edith Method

    public function Edit($id)
    {
        $record = Category::find($id,['id','name','image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal','show modal');
    }

    public function Update(){
       
           //primero validamos que el name sea ingresado si o si que no quede null
           $rulles=[
            'name'=>'required|unique:categories|min:3'
  ];

  $messages = [
      'name.required'=>'Por favor, ingrese el nombre de la categoria',
      'name.unique'=>'Ya existe una categoria con ese nombre',
      'name.min'=>'El nombre de la categoria debe tener al menos 3 caracteres'
  ];
  //ejecutamos las validaciones
  $this->validate($rulles,$messages);

  ///update
		$category = Category::find($this->selected_id);    
		$category->update([
			'name' => $this->name
		]);  

        //save image
        //image
        $customFileName;
        if($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);
            $category->image=$customFileName;
            $category->save();
        }


        $this->ResetUI();
        $this->emit('category-updated','Categoria Actualizada');
    }



    public function Store()
    {
       
        //primero validamos que el name sea ingresado si o si que no quede null
        $rulles=[
                  'name'=>'required|unique:categories|min:3'
        ];

        $messages = [
            'name.required'=>'Por favor, ingrese el nombre de la categoria',
            'name.unique'=>'Ya existe una categoria con ese nombre',
            'name.min'=>'El nombre de la categoria debe tener al menos 3 caracteres'
        ];
        //ejecutamos las validaciones
        $this->validate($rulles,$messages);

        //si pasamos todas las validaciones realizamos el registro
        $category = Category::create([
            'name'=> $this->name
        ]);

        //image
        $customFileName;
        if($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);
            $category->image=$customFileName;
            $category->save();
        }

        $this->ResetUI();
        $this->emit('category-added','Categoria Registrada');
    }


   
    //funcion resetUI
    public function ResetUI(){
        $this->name='';
        $this->image=null;
        $this->search='';
        $this->selected_id = 0;
    }

    protected $listeners=[
        'deleteRow' =>'Destroy'
    ];

    public function Destroy($id)
    {
        $category = Category::find($id);
        //dd($category);
        $imageName = $category->image;//creamos una imagen temporal para despues eliminarla
        $category->delete();

        if($imageName !=null) {
            unlink('storage/categories/' . $imageName);
        }

        //reinicializamos 
        $this->ResetUI();
        $this->emit('category-delete','Categoria Eliminada');
    }
}
