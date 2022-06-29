<nav id="sidebar">
    <div class="sidebar-header">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('assets/template/img/logo_index.svg') }}" width="40" height="40" class="align-top" alt="">
        </a>
    </div>
    <ul id="dropMenu" class="list-unstyled components">
        <!-- Valida auth -->
        @if(Auth::user() != null)
            @if(count(Auth::user()->TRAM_CAT_ROL->TRAM_DET_PERMISOROL)> 0)
                <?php $Grupo = null; ?>
                <?php $List = Auth::user()->TRAM_CAT_ROL->TRAM_DET_PERMISOROL; ?>
                <?php $ArrMenu = [];
                    
                    function filter_by_value ($array, $index, $value){
                        $newarray = array();
                        if(is_array($array) && count($array)>0) 
                        {
                            foreach(array_keys($array) as $key){
                                $temp[$key] = $array[$key][$index];
                                
                                if ($temp[$key] == $value){
                                    $newarray[$key] = $array[$key];
                                }
                            }
                        }
                        return $newarray;
                    }
                    for ($i=0; $i < count($List); $i++) {
                        if($List[$i]->TRAM_CAT_PERMISO->PERMI_NIDCATEGORIA_PERMISO != null){ 
                            //Es una categoria
                            $Exist = filter_by_value($ArrMenu, 'Nombre', $List[$i]->TRAM_CAT_PERMISO->TRAM_CAT_CATEGORIA_PERMISO['CPERMI_CNOMBRE']);
                            if(count($Exist) == 0){
                                array_push($ArrMenu, [
                                        'Nombre' => $List[$i]->TRAM_CAT_PERMISO->TRAM_CAT_CATEGORIA_PERMISO['CPERMI_CNOMBRE'],
                                        'Ruta' => '',
                                        'Id' => $List[$i]->TRAM_CAT_PERMISO->TRAM_CAT_CATEGORIA_PERMISO['CPERMI_NIDCATEGORIA_PERMISO'],
                                        'SubMenu' => [],
                                        
                                ]);
                            }
                        }else {
                            //Permisos sin categoria
                            array_push($ArrMenu, [
                                        'Nombre' => $List[$i]->TRAM_CAT_PERMISO->PERMI_CNOMBRE,
                                        'Ruta' => $List[$i]->TRAM_CAT_PERMISO->PERMI_CRUTA,
                                        'Id'=> '',
                                        'SubMenu' => [],
                                        ]);
                        }
                    }
                ?>
                @foreach($ArrMenu as $item)
                    {{-- Menus --}}
                    @if($item['Ruta'] != "")
                        <li><a href='{{$item['Ruta']}}'>{{$item['Nombre']}}</a></li>
                    @endif 
                    
                    {{-- Sub menus --}}
                    @if($item['Ruta'] == "")                    
                        <li>
                            <a href='#sub_{{$item['Id']}}' data-toggle='collapse' aria-expanded='false'
                                class='dropdown-toggle'>{{$item['Nombre']}}</a>                                           
                            <ul class='collapse list-unstyled' id='sub_{{$item['Id']}}'>
                                @foreach(Auth::user()->TRAM_CAT_ROL->TRAM_DET_PERMISOROL as $subitem)
                                    @if($subitem->TRAM_CAT_PERMISO->PERMI_NIDCATEGORIA_PERMISO == $item['Id'])
                                        <li><a href='{{$subitem->TRAM_CAT_PERMISO->PERMI_CRUTA}}'>{{$subitem->TRAM_CAT_PERMISO->PERMI_CNOMBRE}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif   
                @endforeach
            @endif
        @endif
        {{-- 
        <li class="active"><a href='/tramite_servicio'>Inicio</a></li>
        <li><a href='/registrar'>Registro</a></li>
        <li><a href="/seguimiento_solicitud">Seguimiento a solicitudes</a></li>
        <li><a href="#">Gestores</a></li>
        <li><a href="#">Lista de trámites</a></li>
        <li><a href="#">Servidores públicos</a></li>
        <li><a href="#">Personas físicas o morales</a></li>
        <li><a href="#">Formularios</a></li>
        <li><a href="#">Reportes estadísticos</a></li>
        <li><a href='#Configuraciones' data-toggle='collapse' aria-expanded='false'
                class='dropdown-toggle'>Configuraciones</a>
            <ul class='collapse list-unstyled' id='Configuraciones'>
                <li><a href="/permiso">Permisos</a></li>
                <li><a href="/rol">Roles</a></li>
                <li><a href='usuarios.html'>Usuarios</a></li>
                <li><a href='#'>Días inhábiles</a></li>
                <li><a href='#'>Vigencias</a></li>
                <li><a href='#'>Notificaciones</a></li>
            </ul>
        </li> --}}
    </ul>
</nav>

