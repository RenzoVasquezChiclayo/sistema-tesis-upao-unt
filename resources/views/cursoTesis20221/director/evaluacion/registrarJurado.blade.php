@extends('plantilla.dashboard')
@section('titulo')
    Registrar Jurado
@endsection
@section('contenido')
    <div class="card-header">
        Registrar Jurado
    </div>
    <div class="card-body" style="text-align: start;">
        <div class="row justify-content-around align-items-center">
            <div class="row border-box" style="margin-bottom: 30px;">
                <form action="{{ route() }}" method="post">
                    @csrf
                    <div class="row justify-content-center" style="margin-bottom: 20px;">
                        <div class="col-3">
                            <h5>Escuela</h5>
                            <select class="form-select" onchange="select_escuela(this);" name="escuela" id="escuela"
                                required>
                                @foreach ($escuela as $e)
                                    <option value="{{ $e->cod_escuela }}">{{ $e->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <h5>Semestre academico</h5>
                            <select class="form-select" onchange="select_semestre(this);" name="semestre_academico"
                                id="semestre_academico" required>
                                @foreach ($semestre_academico as $s_a)
                                    <option value="{{ $s_a->cod_configuraciones }}">{{ $s_a->año }}_{{ $s_a->curso }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('datos') == 'ok')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Jurado registrado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ha ocurrido un error. Intentelo denuevo.',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <script type="text/javascript">
        window.onload = function() {
            semestre = document.getElementById('semestre_academico').value;
            document.getElementById('semestre_hidden').value = semestre;

            escuela = document.getElementById('escuela').value;
            document.getElementById('escuela_hidden').value = escuela;
        }

        function select_semestre() {
            semestre = document.getElementById('semestre_academico').value;
            if (semestre != '0') {
                document.getElementById('semestre_hidden').value = semestre;
            } else {
                alert('Seleccione otra opcion de semestre academico');
            }
        }

        function select_escuela() {
            escuela = document.getElementById('escuela').value;
            if (escuela != '0') {
                document.getElementById('escuela_hidden').value = escuela;
            } else {
                alert('Seleccione otra opcion de escuela');
            }
        }

        const inputDireccion = document.querySelector('#direccion');
        const contadorCaracteres = document.querySelector('#contador-caracteres');

        inputDireccion.addEventListener('input', () => {
            contadorCaracteres.textContent = `${inputDireccion.value.length}/30`;
        });

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection
