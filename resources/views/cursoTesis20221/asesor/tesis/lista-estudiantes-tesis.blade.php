@extends('plantilla.dashboard')
@section('titulo')
    Estudiantes con Tesis
@endsection
@section('contenido')
<div class="card-header">Estudiantes asignados para Tesis</div>
<div class="card-body">
    <div class="table-responsive">
        <table id="table-proyecto" class="table table-striped table-responsive-md">
            <thead>
                <tr>
                    <td>Grupo</td>
                    <td>Estudiantes</td>
                    <td>Revision</td>
                    <td class="text-center">Descargar</td>
                </tr>
            </thead>
            <tbody>
                {{-- HOSTING --}}
                @foreach ($studentforGroups as $estu)
                    <tr
                    @if ($estu[0]->estado == 3)
                                        style="background-color: rgba(76, 175, 80, 0.2);"
                                    @elseif ($estu[0]->estado == 4)
                                    style="background-color: rgba(255, 87, 51, 0.2);"
                                    @endif>
                        <td>
                            {{$estu[0]->num_grupo}}
                        </td>
                        <td>
                            @foreach ($estu as $e)
                                <p>{{$e->cod_matricula.' - '.$e->apellidos.', '.$e->nombres}}</p>
                            @endforeach
                        <td>
                            @if($estu[0]->estado != 0)
                                <form id="form-revisaTema" action="{{route('asesor.revisar-tesis')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_grupo" value="{{$estu[0]->id_grupo}}">
                                    @if ($estu[0]->estado == 1)
                                        <a href="#" onclick="this.closest('#form-revisaTema').submit()" class="btn btn-success">Revisar</a>
                                    @else
                                        <a href="#" onclick="this.closest('#form-revisaTema').submit()" class="btn btn-secondary">Observar</a>
                                    @endif
                                </form>
                            @endif
                            {{-- <a href="{{route('asesor.revisarTemas',$estu->cod_matricula)}}" class="btn btn-success">Revisar</a> --}}
                        </td>
                        <td class="text-center" style="text-align: center; justify-content:center;">
                            <form id="proyecto-download" action="{{route('curso.descargar-tesis')}}" method="POST">
                                @csrf
                                <input type="hidden" name="cod_Tesis" value="{{$estu[0]->cod_tesis}}">
                                <a href="#" onclick="this.closest('#proyecto-download').submit()"><i class='bx bx-sm bx-download'></i></a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
