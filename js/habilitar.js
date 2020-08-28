
 function comprobarOption(){
        
        var opcion == document.atencion_emergencia.motivo.opcions.value ;
        if(opcion ==='OTRO') document.atencion_emergencia.otro.readonly = false;
        else document.atencion_emergencia.otro.readonly = true;
    }
