//inicializacion o   usos globales

$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
 
    
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
