@extends('plantilla.dashboard')
@section('titulo')
    Lista Alumnos
@endsection
@section('contenido')
<div class="row">
    <div class="col-12">
        <div class="row" style="display: flex; align-items:center;">
            <div class="col-12">
                <div class="row" style="margin: 10px;">
                    <div class="col-8 col-md-5 col-lg-3">
                        <a href="{{route('director.veragregar')}}" class="btn btn-success"><i class='bx bx-sm bx-message-square-add'></i>Nuevo Alumno</a>
                    </div>
                </div>
                <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                    <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                        <form id="listAlumno" name="listAlumno" method="get">
                            <div class="row">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="buscarAlumno" placeholder="Codigo de matricula o Apellidos" value="{{$buscarAlumno}}" aria-describedby="btn-search">
                                    <button class="btn btn-outline-primary" type="submit" id="btn-search">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-proyecto" class="table table-striped table-responsive-md">
                        <thead>
                            <tr>
                                <td>Numero Matricula</td>
                                <td>DNI</td>
                                <td>Nombre</td>
                                <td>Editar</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $cont = 0;
                            @endphp
                            @foreach ($estudiantes as $est)
                                <tr>
                                    <td>{{$est->cod_matricula}}</td>
                                    <td>{{$est->dni}}</td>
                                    <td>{{$est->apellidos.' '.$est->nombres}}.</td>
                                    <td>
                                        <form id="form-alumno" method="post" action="{{route('director.verAlumnoEditar')}}">
                                            @csrf
                                            <input type="hidden" name="auxid" value="{{$est->cod_matricula}}">
                                            <a href="#" class="btn btn-warning" onclick="this.closest('#form-alumno').submit();"><i class='bx bx-sm bx-edit-alt'></i></a>
                                        </form>
                                    </td>
                                    {{-- <td>
                                        <form id="formAlumnoDelete" name="formAlumnoDelete" method="" action="">
                                            @method('DELETE')
                                            @csrf

                                            <input type="hidden" name="auxidDelete" value="{{$est->cod_matricula}}">
                                            <a href="#" class="btn btn-danger btn-eliminar" onclick="alertaConfirmacion(this);"><i class="fas fa-minus-circle"></i></a>
                                        </form>
                                    </td> --}}
                                </tr>
                                @php
                                    $cont++;
                                @endphp
                            @endforeach
                            <input type="hidden" name="saveAsesor" id="saveAsesor">
                            <input type="hidden" id="cantidadEstudiantes" value="{{count($estudiantes)}}">
                        </tbody>
                    </table>
                    {{$estudiantes->links()}}
                </div>

            </div>
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
    @endif
<script type="text/javascript">
    function editarAlumno(formulario, contador){
        formulario.closest('#form-alumno'+contador).submit();
    }
    function alertaConfirmacion(e){

        Swal.fire({
            title: 'Estas Seguro que deseas eliminar?',
            text: "No podras revertirlo",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar!'
        }).then((result) => {
            if (result.isConfirmed) {

                document.formAlumnoDelete.action ="{{route('director.deleteAlumno')}}";
                document.formAlumnoDelete.method = "POST";
                e.closest('#formAlumnoDelete').submit();

            }
        });

    }

</script>
@endsection
