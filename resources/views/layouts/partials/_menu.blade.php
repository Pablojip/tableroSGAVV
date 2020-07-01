<div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
          <li class="m-t-30">
            <a href="#" class="detailed">
              <span class="title">Inicio</span>
              <span class="details">información adicional.</span>
            </a>
            <span class="icon-thumbnail "><i class="pg-icon">home</i></span>
          </li>
          <li class="">
            <a href="javascript:;">
              <span class="title">Usuarios</span>
              <span class=" arrow"></span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">user</i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="{{ route("usuarioCreate") }}">Nuevo</a>
                <span class="icon-thumbnail">N</span>
              </li>
              <li class="">
                <a href="{{ route("usuarioIndex") }}">Buscar</a>
                <span class="icon-thumbnail">B</span>
              </li>
            </ul>
          </li>
          <!--Turno -->
          <li class="">
              <a href="javascript:;">
                <span class="title">Alumno</span>
                <span class=" arrow"></span>
              </a>
              <span class="icon-thumbnail"><i class="pg-icon">A</i></span>
              <ul class="sub-menu">
                <li class="">
                  <a href="{{ route("alumnoCreate") }}">Nuevo</a>
                  <span class="icon-thumbnail">N</span>
                </li>
                <li class="">
                  <a href="{{ route("alumnoIndex") }}">Buscar</a>
                  <span class="icon-thumbnail">B</span>
                </li>
              </ul>
            </li>
          <!--Materias-->
          <li class="">
            <a href="javascript:;">
              <span class="title">Materias</span>
              <span class=" arrow"></span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">bookmark</i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="{{ route("materiaCreate") }}">Nuevo</a>
                <span class="icon-thumbnail">N</span>
              </li>
              <li class="">
                <a href="{{ route("materiaIndex") }}">Buscar</a>
                <span class="icon-thumbnail">B</span>
              </li>
            </ul>
          </li>
          <li class="">
            <a href="javascript:;">
              <span class="title">Temas</span>
              <span class=" arrow"></span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">comment</i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="{{ route("temaCreate") }}">Nuevo</a>
                <span class="icon-thumbnail">N</span>
              </li>
              <li class="">
                <a href="{{ route("temaIndex") }}">Buscar</a>
                <span class="icon-thumbnail">B</span>
              </li>
            </ul>
          </li>
          <li class="">
            <a href="javascript:;">
              <span class="title">Sub temas</span>
              <span class=" arrow"></span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">chat</i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="{{ route("subTemaCreate") }}">Nuevo</a>
                <span class="icon-thumbnail">N</span>
              </li>
              <li class="">
                <a href="{{ route("subTemaIndex") }}">Buscar</a>
                <span class="icon-thumbnail">B</span>
              </li>
            </ul>
          </li>

          <!--ciclo Escolar -->
          <li class="">
            <a href="javascript:;">
              <span class="title">Ciclo Escolar</span>
              <span class=" arrow"></span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">C</i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="{{ route("cicloEscolarCreate") }}">Nuevo</a>
                <span class="icon-thumbnail">N</span>
              </li>
              <li class="">
                <a href="{{ route("cicloEscolarIndex") }}">Buscar</a>
                <span class="icon-thumbnail">B</span>
              </li>
            </ul>
          </li>
          <!--Grado -->
          <li class="">
            <a href="javascript:;">
              <span class="title">Grado</span>
              <span class=" arrow"></span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">G</i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="{{ route("gradoCreate") }}">Nuevo</a>
                <span class="icon-thumbnail">N</span>
              </li>
              <li class="">
                <a href="{{ route("gradoIndex") }}">Buscar</a>
                <span class="icon-thumbnail">B</span>
              </li>
            </ul>
          </li>
           <!--Grupo -->
           <li class="">
            <a href="javascript:;">
              <span class="title">Grupo</span>
              <span class=" arrow"></span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">Gr</i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="{{ route("grupoCreate") }}">Nuevo</a>
                <span class="icon-thumbnail">N</span>
              </li>
              <li class="">
                <a href="{{ route("grupoIndex") }}">Buscar</a>
                <span class="icon-thumbnail">B</span>
              </li>
            </ul>
          </li>
          <!--Turno -->
          <li class="">
            <a href="javascript:;">
              <span class="title">Turno</span>
              <span class=" arrow"></span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">T</i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="{{ route("turnoCreate") }}">Nuevo</a>
                <span class="icon-thumbnail">N</span>
              </li>
              <li class="">
                <a href="{{ route("turnoIndex") }}">Buscar</a>
                <span class="icon-thumbnail">B</span>
              </li>
            </ul>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>