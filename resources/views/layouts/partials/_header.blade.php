<div class="header ">
        <!-- START MOBILE SIDEBAR TOGGLE -->
        <a href="#" class="btn-link toggle-sidebar d-lg-none pg-icon btn-icon-link" data-toggle="sidebar">
      		menu</a>
        <!-- END MOBILE SIDEBAR TOGGLE -->
        <div class="">
          <div class="brand inline">
            <img src="{{ asset('assets/img/logo4x.png') }}" alt="logo" data-src="{{ asset('assets/img/logo4x.png') }}" data-src-retina="{{ asset('assets/img/logo2x.png') }}" width="78" height="40">
          </div>
          <!-- START NOTIFICATION LIST -->
         
          <!-- END NOTIFICATIONS LIST -->
          <!--<a href="#" class="search-link d-lg-inline-block d-none" data-toggle="search"><i
      				class="pg-icon">search</i>Escriba cualquier cosa para  <span class="bold">buscar</span></a>-->
        </div>
        <div class="d-flex align-items-center">
          <!-- START User Info-->
          <div class="dropdown pull-right d-lg-block d-none">
            <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="profile dropdown">
              <span class="thumbnail-wrapper d32 circular inline">
      					<img src="{{ asset('assets/img/profiles/perfil-83.5@2x.png') }}" alt="" data-src="{{ asset('assets/img/profiles/perfil-83.5@2x.png') }}"
      						data-src-retina="{{ asset('assets/img/profiles/perfil-83.5@2x.png') }}" width="32" height="32">
      				</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
            <a href="#" class="dropdown-item"><span>Ingresaste como <br /><b>{{ Auth::user()->nombreCompleto() }}</b></span></a>
              <div class="dropdown-divider"></div>
              <a href="{{ route("usuarioCreateProfile",['id' => Auth::user()->id]) }}" class="dropdown-item">Mi perfil</a>
              <a href="#" id="btnRememberPassword" class="dropdown-item">Cambiar contraseña</a>
              <div class="dropdown-divider"></div>
              <a href="{{ route("logout")  }}" class="dropdown-item"><b>Cerrar Sesion</b></a>
            </div>
          </div>
          <!-- END User Info-->
          <!--<a href="#" class="header-icon m-l-5 sm-no-margin d-inline-block" data-toggle="quickview" data-toggle-element="#quickview">
            <i class="pg-icon btn-icon-link">menu_add</i>-->
          </a>
        </div>
      </div>