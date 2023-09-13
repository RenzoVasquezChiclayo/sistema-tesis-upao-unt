@extends('plantilla.dashboard')
@section('titulo')
    Estudiantes con Tesis
@endsection
@section('contenido')
<div class="row">
    <div class="col-12">
        <div class="row" style="display: flex; align-items:center;">
            <div class="col-10">
                    <table id="table-proyecto" class="table table-striped table-responsive-md">
                        <thead>
                            <tr>
                                <td>Grupo</td>
                                <td>Estudiantes</td>
                                <td>Revision</td>
                                <td>Descargar</td>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- HOSTING --}}
                            @foreach ($studentforGroups as $estu)
                                <tr
                                @if ($estu[0]->estado == 3)
                                    style="background-color: #7BF96E;"
                                @elseif ($estu[0]->estado == 4)
                                    style="background-color: #FA6A56;"
                                @endif
                                >
                                    <td>{{$estu[0]->num_grupo}}</td>
                                    @if (count($estu)>1)
                                        <td>{{$estu[0]->nombres.' '.$estu[0]->apellidos.' & '.$estu[1]->nombres.' '.$estu[1]->apellidos}}</td>
                                    @else
                                        <td>{{$estu[0]->nombres.' '.$estu[0]->apellidos}}</td>
                                    @endif
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
                                    <td style="text-align: center;">
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
