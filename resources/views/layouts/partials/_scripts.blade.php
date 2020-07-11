<script src="{{ asset('assets/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
<!--<script src="{{ asset('assets/plugins/liga.js') }}" type="text/javascript"></script>-->
    <script src="{{ asset('assets/plugins/jquery/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/modernizr.custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/popper/umd/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery-easy.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-unveil/jquery.unveil.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-ios-list/jquery.ioslist.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-actual/jquery.actual.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <!--<script type="text/javascript" src="{{ asset('assets/plugins/classie/classie.js') }}"></script>-->
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-autonumeric/autoNumeric.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-tag/bootstrap-tagsinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.min.js') }}"></script>
    <!--<script src="{{ asset('assets/plugins/bootstrap-form-wizard/js/jquery.bootstrap.wizard.min.js') }}" type="text/javascript"></script>-->
    <script src="{{ asset('assets/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/quill/quill.min.js') }}" type="text/javascript"></script>
    
    <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-typehead/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-typehead/typeahead.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/handlebars/handlebars-v4.0.5.js') }}"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="{{ asset('pages/js/pages.min.js') }}" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
   
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/form_elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/scripts.js') }}" type="text/javascript"></script>

    
    <!-- JAVASCRIP PARA USO GLOBAL -->
    <script src="{{ asset('assets/js/card.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/notifications.js') }}" type="text/javascript"></script>

    <script>
        $(function()
        {
          //Alerta general
          var error = "{!! $errorMsj ?? '' !!}";
          if(error){
            alert(error,'danger');
          }

        }); 
       
        $('#btnRememberPassword').click(function (e){

          try{
              //showLoading();
              alert('Procesando la solicitud, porfavor espere....','warning');
              $.post('{{ route("mailRecuperarIn") }}')
              .done(function(data) {
                  if(data.valido){
                    alert(data.mensaje);
                  }else{
                    lert(data.mensaje,'danger');
                  }
                })
                .fail(function(e) {
                  alert('Ocurrio un error inesperado, contacte al administrador.','danger');
                })
                .always(function() {
                  //hideLoading();
                });
            }catch(e){

            } 

        });
    </script>
  
    @yield('js')