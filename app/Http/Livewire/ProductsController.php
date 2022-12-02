<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; //trait para subir imagenes
use Livewire\WithPagination;// para la paginacion

class ProductsController extends Component
{

    use WithFileUploads;
    use withPagination;


    public $name, $barcode, $cost, $price,$stock,$alert,$categorias, $search,$image,$selected_id, $pageTitle,$componentName;
    private $pagination=5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle ='Listado';
        $this->componentName ='Productos';
        $this->categorias='Seleccionar';
    }

    public function render()
    {
        if(strlen($this->search)>0)
        $products = Product::Join('categories as c','c.id','products.category_id')
                    ->select('products.*','c.name as category')
                    ->where('products.name','like','%' . $this->search . '%')
                    ->orWhere('products.barcode','like','%' . $this->search . '%')
                    ->orWhere('c.name','like','%' . $this->search . '%')
                    ->orderBy('products.name','asc')
                    ->paginate($this->pagination);
        else

        $products = Product::Join('categories as c','c.id','products.category_id')
        ->select('products.*','c.name as category')
        ->orderBy('products.name','asc')
        ->paginate($this->pagination);


        return view('livewire.products.component', [
            'data'=>$products,
            'categories'=> Category::orderBy('name','asc')->get()])
            ->extends('layouts.theme.app')
        ->section('content');
    }

    //crear nuevo registro//

    public function Store()
    {

        //primero validamos que el name sea ingresado si o si que no quede null
        $rulles=[
                  'name'=>'required|unique:products|min:3',
                  'cost'=>'required',
                  'price'=>'required',
                  'stock'=>'required',
                  'alert'=>'required',
                  'categorias'=>'required|not_in:Seleccionar'
        ];

        $messages = [
            'name.required'=>'Por favor, ingrese el nombre del producto',
            'name.unique'=>'Ya existe un producto con ese nombre',
            'name.min'=>'El nombre del producto debe tener al menos 3 caracteres',
            'cost.required'=>'El costo es requerido',
            'price.required'=>'El precio es requerido',
            'stock.required'=>'El stock es requerido',
            'alert.required'=>'Ingresar el valor mínimo en existencia',
            'categorias.not_in'=>'Por favor, seleccione una categoria diferente a Seleccionar'

        ];
        //ejecutamos las validaciones
        $this->validate($rulles,$messages);

        //si pasamos todas las validaciones realizamos el registro
        $product = Product::create([
            'name'=> $this->name,
            'barcode'=> $this->barcode,
            'cost'=> $this->cost,
            'price'=> $this->price,
            'stock'=> $this->stock,
            'category_id'=> $this->categorias,
            'alert'=> $this->alert,
        ]);

        //image
        $customFileName;
        if($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $product->image=$customFileName;
            $product->save();
        }

        $this->ResetUI();
        $this->emit('product-added','Producto Registrado');
    }

    //actualizar registro//
//actualizar registro//

public function Edit($id){

    $record = Product::find($id,['id','name','barcode','cost','price','stock','alert','category_id']);
    $this->name = $record->name;
    $this->barcode = $record->barcode;
    $this->cost = $record->cost;
    $this->price = $record->price;
    $this->stock = $record->stock;
    $this->alert = $record->alert;
    $this->categorias =$record->category_id;
    $this->selected_id = $record->id;
    $this->image = null;

    $this->emit('show-modal','show modal');

}

public function Update(){
              //primero validamos que el name sea ingresado si o si que no quede null
              $rulles=[
                'name'=>"required|min:3|unique:products,name,{$this->selected_id}"
      ];

      $messages = [
          'name.required'=>'Por favor, ingrese el nombre del producto',
          'name.unique'=>'Ya existe un producto con ese nombre',
          'name.min'=>'El nombre del producto debe tener al menos 3 caracteres'
      ];
      //ejecutamos las validaciones
      $this->validate($rulles,$messages);

      ///update
            $product = Product::find($this->selected_id);
            $product->update([
                'name' => $this->name,
                'barcode' => $this->barcode,
                'cost'=>$this->cost,
                'price'=>$this->price,
                'stock'=>$this->stock,
                'alert'=>$this->alert,
                'categorias_id'=>$this->categorias
            ]);

                 //image  el actualizar la imagen no funciona... //deja que chequeo en el mio aqui
    $customFileName;
    if($this->image)
    {
        $customFileName = uniqid() . '_.' . $this->image->extension();
        $this->image->storeAs('public/products', $customFileName);
        $imageName = $product->image;
        $imageTemp = $product->image; //imagen temporal
        $product->image=$customFileName;
        $product->save();

        if($imageTemp != null)
        {
            if(file_exists('storage/products/' . $imageTemp)){
                unlink('storage/products/' . $imageTemp);
            }
        }
    }


            $this->ResetUI();
            $this->emit('product-updated','Producto Actualizada');

}

    //Eliminar registro registro//

    protected $listeners=[
        'deleteRow' =>'Destroy'
    ];

    public function Destroy(Product $product)
    {


        $imageTemp = $product->image;//creamos una imagen temporal para despues eliminarla
        $product->delete();

        if($imageTemp !=null) {
            if(file_exists('storage/products/' . $imageTemp)){
                unlink('storage/products/' . $imageTemp);
            }
        }

        //reinicializamos
        $this->ResetUI();
        $this->emit('product-delete','Producto Eliminado');
    }

    // reset values inputs
	public function ResetUI()
	{
		$this->name ='';
        $this->barcode = '';
        $this->cost = 0;
        $this->price = 0;
        $this->categorias="Seleccionar";
        $this->stock ='';
        $this->alert ='';
		$this->image = null;
		$this->search ='';
		$this->selected_id = 0;
        $this->resetValidation();

	}
}
