@extends('plantilla.dashboard')
@section('titulo')
    Estado de la Tesis
@endsection
@section('contenido')
    <div class="row" style="display:flex; align-items:center; justify-content: center;">
        <div class="col-12">
            <div class="row">
                <div class="col-10" style="margin:0px auto;margin-top:10px;">
                </div>
            </div>
        </div>

        @if($hTesis[0]!=null)
            <div class="col-10">
                <div class="row">
                    <div class="col-12">
                        <div class="row box-center">
                            <div class="col-10">
                                <h5><b>Estado de la Tesis</b></h5>
                                <div class="row">
                                    <table id="table-formato" class="table table-bordered table-responsive-md" style="table-border-color: red;">
                                        <thead>
                                            <tr>
                                                <td>Fecha</td>
                                                <td>Titulo</td>
                                                <td>Asesor</td>
                                                <td>Estado</td>
                                                <td style="text-align: center">Descargar</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $estado = 'sin iniciar';
                                                switch($hTesis[0]->estado){
                                                    case 1:
                                                        $estado = 'Sin revisar';
                                                        break;
                                                    case 2:
                                                        $estado = 'Revisado';
                                                        break;
                                                    case 3:
                                                        $estado = 'Aprobado';
                                                        break;
                                                    case 4:
                                                        $estado = 'Desaprobado';
                                                        break;
                                                    case 9:
                                                        $estado = 'Guardado';
                                                        break;
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{$hTesis[0]->fecha_update}}</td>
                                                <td>{{$hTesis[0]->titulo}}</td>
                                                <td>@if ($asesor!=null){{$asesor[0]->nombres}}@endif</td>
                                                <td>{{$estado}}</td>
                                                <td style="text-align: center;">
                                                    @if($hTesis[0]->estado!=0)
                                                        <form id="tesis-download" action="{{route('curso.descargar-tesis')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="cod_Tesis" value="{{$hTesis[0]->cod_tesis}}">
                                                            <a href="#" onclick="this.closest('#tesis-download').submit()" @if($hTesis[0]->estado == 0) hidden @endif><i class='bx bx-sm bx-download'></i></a>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('datos')=='ok')
        <script>
            Swal.fire(
                'Guardado/Enviado!',
                'Proyecto de Tesis guardado/enviado correctamente',
                'success'
            )
        </script>
    @endif
    <script type="text/javascript">
        setTimeout(function(){
            document.querySelector('#mensaje').remove();
        },2000);
    </script>
@endsection
