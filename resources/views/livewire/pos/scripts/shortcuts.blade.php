<script>
//inicializamos el listener
var listener = new window.keypress.Listener();

//tecla f9
listener.simple_combo("f9", function() {
livewire.emit('saveSale')
})


//tecla f8
listener.simple_combo("f8", function() {
document.getElementById('cash').value=''
document.getElementById('cash').focus()
})


//tecla f4
listener.simple_combo("f4", function() {
var total = parseFloat(document.getElementById('hiddenTotal'));

if(total > 0){
    Confirm(0,'clearCart','¿Segur@ que desea vaciar el carrito?')
}else{
    notify('Agrega producto/s a la venta')
}
})
</script>