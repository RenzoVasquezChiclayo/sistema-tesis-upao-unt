@extends('plantilla.dashboard')
@section('titulo')
    Configuraciones Iniciales
@endsection
@section('contenido')
    <div class="card-header">
        Semestre Académico
    </div>
    <div class="card-body">
        <form id="formconfig" method="post" action="{{ route('admin.saveconfigurar') }}">
            @csrf
            <div class="row">
                <h4>Registrar nuevo semestre</h4>
                <div class="col-md-6 col-xl-4 my-2 text-start">
                    <label class="ms-2" for="year">Año</label>
                    <select class="form-control" name="year" id="year">
                        <option value="0">-- Selecciona el año académico --</option>
                    </select>
                </div>
                <div class="col-md-6 col-xl-4 my-2 text-start">
                    <label class="ms-2" for="curso">Curso</label>
                    <input class="form-control" type="text" placeholder="Nombre del curso" id="curso" name="curso">
                </div>
                <div class="col-md-6 col-xl-4 my-2 text-start">
                    <label class="ms-2" for="ciclo">Ciclo</label>
                    <select class="form-control" name="ciclo" id="ciclo">
                        <option value="0">-- Selecciona el ciclo académico --</option>
                    </select>
                </div>
            </div>
            <div class="col my-3 text-start">
                <button class="btn btn-success" type="button" onclick="saveConfig(this);">Registrar</button>
            </div>
        </form>
        <div class="row mt-3">
            <h4>Listado de semestres</h4>
            <div class="mt-2 table-responsive">
                <table id="table-proyecto" class="table table-striped table-responsive-md" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <td>Id</td>
                            <td>Año</td>
                            <td>Curso</td>
                            <td>Ciclo</td>
                            <td>Estado</td>
                            <td>Editar</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $cont = 0;
                        @endphp
                        @foreach ($lista_configuraciones as $l_c)
                            <tr>
                                <td>{{ $l_c->cod_config_ini }}</td>
                                <td>{{ $l_c->year }}</td>
                                <td>{{ $l_c->curso }}</td>
                                <td>{{ $l_c->ciclo }}</td>
                                <td>
                                    <div class="container-center">
                                        <form class="form-fit" id="formChangeStatus" name="formChangeStatus" method="post"
                                        action="{{ route('admin.changeStatusConfiguraciones') }}" >
                                            @csrf
                                            <input type="text" name="aux_configuraciones"
                                                value="{{ $l_c->cod_config_ini}}" hidden>
                                            <div class="form-check form-switch" style="width: fit-content">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckDefault" onclick="updateState(this);"
                                                    @if ($l_c->estado == 1) checked @endif>
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Activado</label>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <form id="form-configuracion" method="post"
                                        action="{{ route('admin.verConfiguracionEditar') }}">
                                        @csrf
                                        <input type="hidden" name="auxid" value="{{ $l_c->cod_config_ini }}">
                                        <a href="#" class="btn btn-warning"
                                            onclick="this.closest('#form-configuracion').submit();"><i
                                                class='bx bx-sm bx-edit-alt'></i></a>
                                    </form>
                                </td>
                            </tr>
                            @php
                                $cont++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                {{ $lista_configuraciones->links() }}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        putListYears();
        putListCiclos();
        function saveConfig(form) {
            if (!verifiyFields()) {
                alert("Existen campos pendientes.");
                return;
            }
            Swal.fire({
                title: 'Estas seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, guardar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.closest('#formconfig').submit();
                }
            })

        }
        function updateState(form) {
            form.closest('#formChangeStatus').submit();
        }

        function verifiyFields() {
            const year = document.getElementById('year').selectedIndex;
            const ciclo = document.getElementById('ciclo').selectedIndex;
            const curso = document.getElementById('curso').value.trim();
            if (year === 0) {
                return false;
            }
            if(ciclo===0){
                return false;
            }
            if(curso == ""){
                return false;
            }
            return true;
        }

        function putListYears() {
            const currentYear = new Date().getFullYear();

            const yearSelector = document.getElementById('year');
            for (let i = 0; i < 5; i++) {
                const optionYear = currentYear - i;
                const option = document.createElement('option');
                option.value = optionYear;
                option.text = optionYear;
                yearSelector.add(option);
            }
        }

        function putListCiclos() {
            const cicloSelector = document.getElementById('ciclo');
            for (let i = 1; i <= 10; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.text = i;
                cicloSelector.add(option);
            }
        }
    </script>
    @if (session('datos') == 'okNotNull')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Complete todos los campos',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'ok')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Guardado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okNot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al guardar',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @endif
@endsection
