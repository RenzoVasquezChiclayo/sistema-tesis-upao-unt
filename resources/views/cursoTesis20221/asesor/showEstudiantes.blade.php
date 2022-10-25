@extends('plantilla.dashboard')
@section('titulo')
    Estudiantes con Proyectos
@endsection
@section('contenido')
<div class="row">
    <div class="col-12">
        <div class="row" style="display: flex; align-items:center;">
            <div class="col-10">
                    <table id="table-proyecto" class="table table-striped table-responsive-md">
                        <thead>
                            <tr>
                                <td>Numero Matricula</td>
                                <td>DNI</td>
                                <td>Nombres</td>
                                <td>Revision</td>
                                <td>Descargar</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($estudiantes as $estu)
                                <tr>
                                    <td>{{$estu->cod_matricula}}</td>
                                    <td>{{$estu->dni}}</td>
                                    <td>{{$estu->nombres.' '.$estu->apellidos}}</td>
                                    <td>
                                        @if($estu->estado != 0)
                                            <form id="form-revisaTema" action="{{route('asesor.revisarTemas')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="cod_matricula" value="{{$estu->cod_matricula}}">
                                                @if ($estu->estado == 1)
                                                    <a href="#" onclick="this.closest('#form-revisaTema').submit()" class="btn btn-success">Revisar</a>
                                                @else
                                                    <a href="#" onclick="this.closest('#form-revisaTema').submit()" class="btn btn-secondary">Observar</a>
                                                @endif
                                            </form>
                                        @endif
                                        {{-- <a href="{{route('asesor.revisarTemas',$estu->cod_matricula)}}" class="btn btn-success">Revisar</a> --}}
                                    </td>
                                    <td style="text-align: center;">
                                        <form id="proyecto-download" action="{{route('curso.descargaTesis')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="cod_cursoTesis" value="{{$estu->cod_cursoTesis}}">
                                            <a href="#" onclick="this.closest('#proyecto-download').submit()"><i class='bx bx-sm bx-download'></i></a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>

    </div>
</div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('datos')=='ok')
        <script>
            Swal.fire(
                'Guardado!',
                'Asignacion de campos guardados correctamente',
                'success'
            )
        </script>
    @endif
@endsection
