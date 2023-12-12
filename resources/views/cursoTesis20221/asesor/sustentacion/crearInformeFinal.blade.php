@extends('plantilla.dashboard')
@section('titulo')
    Informe final
@endsection
@section('contenido')
    <div class="card-header">
        Crear informe final
    </div>
    <div class="card-body" style="text-align: start;">
        <div class="row align-items-left">
            <form name="formInforme" id="formInforme" action="{{route('asesor.guardarInformeFinal')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="cod_tesis" value="{{$tesis->cod_tesis}}">
                <div class="col-12 mb-3">
                    <label for="razonSolicitud">Estudiante</label>
                    <input class="form-control" type="text" value="{{$autor->nombres.' '.$autor->apellidos}}" readonly>
                </div>
                <div class="col-12 mb-3">
                    <label for="">Título de tesis</label>
                    <input class="form-control" type="text" value="{{$tesis->titulo}}" readonly>
                </div>
                <div class="col-12">
                    <label for="">Introducción</label>
                    <textarea class="form-control" name="taIntroduccion" id="taIntroduccion"></textarea>
                </div>
                <div class="col-12 mb-3">
                    <label for="">Aporte de la investigación</label>
                    <textarea class="form-control" name="taAporte" id="taAporte"></textarea>
                </div>
                <div class="col-12 mb-3">
                    <label for="">Metodología empleada</label>
                    <textarea class="form-control" name="taMetodologia" id="taMetodologia"></textarea>
                </div>
                <button class="btn btn-success" type="button" onclick="verificarCampos(this);">Crear informe</button>
            </form>
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
                title: 'Alumno editado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar alumno',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okDelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Alumno eliminado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okNotDelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar el alumno',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @endif
    <script type="text/javascript">

        function verificarCampos(form){
            const introduccion = document.getElementById("taIntroduccion").value;
            if(introduccion == ""){
                alert("Falta rellenar la introducción");
                return false;
            }
            const aporte = document.getElementById('taAporte').value;
            if (aporte == "") {
                alert("Falta rellenar el aporte de la investigación");
                return false;
            }
            const metodologia = document.getElementById('taMetodologia').value;
            if (metodologia == "") {
                alert("Falta rellenar la metodologia");
                return false;
            }
            form.closest('#formInforme').submit();
        }
    </script>
@endsection
rme
