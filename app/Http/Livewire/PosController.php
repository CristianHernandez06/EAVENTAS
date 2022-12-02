<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use DB;

class PosController extends Component
{
    public $total, $ItemsQuantity, $efectivo, $change;


    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->ItemsQuantity = Cart::getTotalQuantity();

    }


    public function render()
    {

        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('value','desc')->get(),
            'cart'=> Cart::getContent()->sortBy('name')

        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    /*function aCash*/
    public function ACash($value)
    {
        $this->efectivo +=($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this-> total);
    }

    public function clearEfecty()
    {
        $this->efectivo = 0;
        $this->change = 0;
        //$set('efecty', 0)
    }

    /*listeners*/
    protected $listeners = [
        'scan-code' =>'ScanCode',
        'removeItem'=>'removeItem',
        'clearCart'=>'clearCart',
        'saveSale'=> 'saveSale'

    ];

    /*scan barcode*/
    public function ScanCode($barcode, $cant = 1)
    {
        $product = Product::where('barcode', $barcode)->first();

        if($product == null || empty($product))
        {
            $this->emit('scan-notfound', 'El producto no está registrado');
        }else

        {

            if($this->InCart($product->id))
            {
                $this->increaseQty($product->id );
                return;
            }
            //validamos si el stock es suficiente para cubrir lo solicitado por el cliente

            if($product->stock < 1)
            {
                $this->emit('no-stock','Stock Insuficiente');
                return;
            }

            //agregamos el producto al carrito de compras

            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

            //sumatoria del total del carrito
            $this->total = Cart::getTotal();
            $this->ItemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok','Producto Agregado');
        }


    }

    //metodo inCart
    public function InCart($productId)
    {
        $exist = Cart::get($productId);

        if($exist)
            return true;

        else
            return false;
    }

    //metodo incrementar cantidad
    public function increaseQty($productId, $cant = 1)
    {
        $title='';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if($exist)
        $title = 'Cantidad Actualizada';
        else
        $title = 'Producto Agregado';

        if($exist)
       {
            if($product->stock < ($cant + $exist->quantity))
            {
                $this->emit('non-stock','Stock Insuficiente');
                return;
            }
       }

       Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

       $this->total = Cart::getTotal();
       $this->ItemsQuantity = Cart::getTotalQuantity();

       $this->emit('scan-ok', $title);
    }
    //metodo actualizar cantidad
    public function updateQty($productId, $cant = 1)
    {
        $title='';
        $product = Product::find($productId);
        $exist = Cart::get($productId);

        if($exist)
        $title = 'Cantidad Actualizada';
        else
        $title = 'Producto Agregado';

        if($exist)
        {
             if($producto->stock < $cant)
             {
                 $this->emit('non-stock','Stock Insuficiente');
                 return;
             }
        }

        $this->removeItem($productId);

        if($cant > 0)
        {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

            $this->total = Cart::getTotal();
            $this->ItemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
        }
    }

    //metodo removeitem //no funciona correctamente
    public function removeItem($productId)
    {
        Cart::remove($productId);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Producto Eliminado');
    }
    //Disminuir cantidad
    public function decreaseQty($productId)
    {
        $item = Cart::get($productId);

        Cart::remove($productId);

        $newQty=($item->quantity)-1;

        if($newQty > 0)

            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);

        $this->total = Cart::getTotal();
        $this->ItemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Cantidad Actualizada');

    }

    //limpiar carrito de compra
    public function clearCart()
    {
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->ItemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Carrito Vacio');
    }

    //Guardar Venta
    public function saveSale()
    {
        if($this->total <= 0)
        {
            $this->emit('sale-error','Agregue productos a la venta');
            return;
        }

        if($this->efectivo <= 0)
        {
            $this->emit('sale-error','Ingrese el Efectivo');
            return;
        }

        if($this->total > $this->efectivo)
        {
            $this->emit('sale-error','Agregue productos a la venta');
            return;
        }

        DB::beginTransaction();

        try {

            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->ItemsQuantity,
                'cash' => $this->efectivo,
                'change' => $this->change,
                'user_id' => Auth()->user()->id

            ]);

            if($sale)
            {
                $items = Cart::getContent();

                foreach($items as $item)
                {
                    saleDetail::create([

                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id

                    ]);

                    //update stock

                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }

            }

            DB::commit();

            Cart::clear();
            $this->efectivo = 0;
            $this->change = 0;
            $this->total = Cart::getTotal();
            $this->ItemsQuantity = Cart::getTotalQuantity();
            $this->emit('sale-ok','Venta Registrada con Exito');
            $this->emit('print-ticket',$sale->id);

        }catch(Exception $e){
            DB::rollback();
            $this->emit('sale-error', $e->getMessage());
        }

    }


    //metodo para imprimir
    public function printTicket($sale)
    {
        return Redirect::to("print://$sale->id");
    }
}
