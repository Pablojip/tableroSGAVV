//inicializacion o   usos globales

$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   

});

$(document).ajaxComplete(function() {
    $('.tooltip_ajax').tooltip();
});

function fetch_data(pagina,form,lista='#lista'){
    try{
        showLoading();
        $.get(pagina,form)
        .done(function(data) {
            if(data.valido){
                $(lista).html(data.mensaje);
            }else{
                alert(data.mensaje,'danger');
            }
        })
        .fail(function(e) {
            alert('Ocurrio un error inesperado, contacte al administrador.','danger');
        })
        .always(function() {
            hideLoading();
        });
        
    }catch(e){
        
    } 
}



//Loadings
function showLoading(){
    $('.loadingContent').card({refresh: true});
}
function hideLoading(){
    setTimeout(function() {
        // Hides progress indicator
        $('.loadingContent').card({
            refresh: false
        });
    }, 300);
    //$('.loadingContent').card({refresh: false});
}
function showLoadingCustom(id){
    $(id).card({refresh: true});
}
function hideLoadingCustom(id){
    setTimeout(function() {
        // Hides progress indicator
        $(id).card({
            refresh: false
        });
    }, 300);
    //$('.loadingContent').card({refresh: false});
}
function loadingEmail(){
  $(".tituloEnvio").html('Procesando información, espere...').removeClass( "text-danger" );
  $("#correoSend-error").remove();
}


function limpiar(){
    $('.limpiar')[0].reset();
}

$( "#btnLimpiar" ).click(function() {
    showLoading();
    limpiar();
    hideLoading();
});

function alert(mensaje,type='success',timeout=10000,style='simple',position='top-right'){
    //postiion: top,bottom,top-left,top-right,bottom-left,bottom-right
    $('.page-content-wrapper').pgNotification({
        style: style,
        message: mensaje,
        position: position,
        timeout: timeout,
        type: type
    }).show();
}


  //methodos de validación
jQuery.validator.addMethod("nombres", function(value, element) {
    return this.optional(element) || /^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u.test(value);
}, "Solo acepta letras.");




//bitacora
function detalleBitacora(modulo,accion,cambios){
    //variables
    var countNew=0;
    var rowNew=false;
    var columnaVieja='';
    var columnaNueva='';
    $("#b_campos_viejos").html('');
    $("#b_campo_nuevos").html('');
    //ponemos el modulo.
    $(".modulo").html(modulo);
    $(".accion").html(accion);
    //verificamos los registros
    $.each(cambios, function( index, value ) {
        if(countNew < 2){
            if(!rowNew){
                columnaVieja = columnaNueva =  `<div class="row">`;
                rowNew = true;
            }
            color = value.es_modificado == true ? 'bg-warning' : '';
            columnaVieja +=`<div class="col-md-6">
                              <div class="form-group form-group-default `+color+`">
                                <label>`+ value.nombre_campo +`</label>
                                <label>`+ value.campo_anterior +`</label>
                              </div>
                            </div>`;
                            
            columnaNueva +=`<div class="col-md-6">
                            <div class="form-group form-group-default `+color+`">
                              <label>`+ value.nombre_campo +`</label>
                              <label>`+ value.campo_nuevo +`</label>
                            </div>
                          </div>`;
            
            countNew++;
            if(countNew == 2){
                columnaVieja += `</div>`;
                columnaNueva += `</div>`;
                rowNew = false;
                countNew = 0;
                $("#b_campos_viejos").append(columnaVieja);
                $("#b_campo_nuevos").append(columnaNueva);
            }
        }
        
       
    });
    if(countNew == 1 ){
        $("#b_campos_viejos").append(columnaVieja);
        $("#b_campo_nuevos").append(columnaNueva);
    }
}