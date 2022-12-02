<script>

document.addEventListener('DOMContentLoaded', function () { 

    //evento scan-ok

    window.livewire.on('scan-ok', Msg=>{

        notify(Msg)
    })
    
    //evento scan-notfound

    window.livewire.on('scan-notfound', Msg=>{
        notify(Msg,2)
    })

    //evento no-stock
    window.livewire.on('no-stock', Msg=>{
        notify(Msg,2)
    })

    //ventas con error
    window.livewire.on('sale-error', Msg=>{
        notify(Msg)
    })

    //evento print-ticket
    window.livewire.on('print-ticket', saleId=>{
        window.open("print:://" + saleId, '_blank')
    })
})

</script>




