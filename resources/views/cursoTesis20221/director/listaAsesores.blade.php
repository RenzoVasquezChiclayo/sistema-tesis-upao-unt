@extends('plantilla.dashboard')
@section('titulo')
    Lista Asesores
@endsection
@section('contenido')
<div class="row">
    <div class="col-12">
        <div class="row" style="display: flex; align-items:center;">
            <div class="col-12">
                <div class="row" style="margin: 10px;">
                    <div class="col-8 col-md-5 col-lg-3">
                        <a href="{{route('director.veragregarAsesor')}}" class="btn btn-success"><i class='bx bx-sm bx-message-square-add'></i>Nuevo Asesor</a>
                    </div>
                </div>
                <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                    <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                        <form id="listAsesor" name="listAsesor" method="get">
                            <div class="row">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="buscarAsesor" placeholder="Codigo o Apellidos" value="{{$buscarAsesor}}" aria-describedby="btn-search">
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
                                <td>Codigo</td>
                                <td>Nombres</td>
                                <td>Categoria</td>
                                <td>Editar</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $cont = 0;
                            @endphp
                            @foreach ($asesores as $ase)
                                <tr>
                                    <td>{{$ase->cod_docente}}</td>
                                    <td>{{$ase->nombres}}</td>
                                    <td>{{$ase->grado_academico}}.</td>
                                    <td>
                                        <form id="form-asesor" method="post" action="{{route('director.verAsesorEditar')}}">
                                            @csrf
                                            <input type="hidden" name="auxid" value="{{$ase->cod_docente}}">
                                            <a href="#" class="btn btn-warning" onclick="this.closest('#form-asesor').submit();"><i class='bx bx-sm bx-edit-alt'></i></a>
                                        </form>
                                    </td>
                                    @if (auth()->user()->rol == 'administrador')
                                        <td>
                                            <form id="formAsesorDelete" name="formAsesorDelete" method="" action="">
                                                @method('DELETE')
                                                @csrf

                                                <input type="hidden" name="auxidDelete" value="{{$ase->cod_docente}}">
                                                <a href="#" class="btn btn-danger btn-eliminar" onclick="alertaConfirmacion(this);"><i class='bx bx-message-square-x' ></i></a>
                                            </form>
                                        </td>
                                    @endif

                                </tr>
                                @php
                                    $cont++;
                                @endphp
                            @endforeach
                            <input type="hidden" name="saveAsesor" id="saveAsesor">
                            <input type="hidden" id="cantidadAsesores" value="{{count($asesores)}}">
                        </tbody>
                    </table>
                    {{$asesores->links()}}
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
    function editarAsesor(formulario, contador){
        formulario.closest('#form-asesor'+contador).submit();
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

                document.formAsesorDelete.action ="{{route('director.deleteAsesor')}}";
                document.formAsesorDelete.method = "POST";
                e.closest('#formAsesorDelete').submit();

            }
        });

    }

</script>
@endsection
