<script>


    try{
        
        onScan.attachTo(document,{
        suffixKeyCodes: [13], // enter-key expected at the end of a scan
        onScan: function(barcode) { // Alternative to document.addEventListener('scan')
        console.log(barcode)
        window.livewire.emit('scan-code', barcode)
         },

        onScanError:function(e){
        console.log(e)
         }

    })
        console.log('Scanner Ready!')
    }catch(e){

        console.log('Error de Lectura: ',e)
    }
   



</script>