@extends('plantilla.dashboard')
@section('titulo')
    Estado del Proyecto
@endsection
@section('css')
<style type="text/css">
    .border-box {
        border: 0.5px solid rgba(0, 0, 0, 0.2);
        border-radius: 20px;
        padding: 10px 0px;
        margin: 0;
    }
</style>
@endsection
@section('contenido')
    <div class="row" style="display:flex; align-items:center; justify-content: center;">
        <div class="col-12">
            <div class="row">
                <div class="col-10" style="margin:0px auto;margin-top:10px;">
                </div>
            </div>
        </div>
        @if(sizeof($hTesis)>0 && $hTesis[0]!=null)
            <div class="col-10">
                <div class="row">
                    <div class="col-12">
                        <div class="row box-center">
                            <div class="col-10">
                                <h5><b>Estado del Proyecto de Tesis</b></h5>
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
                                                <td>{{$hTesis[0]->fecha}}</td>
                                                <td>{{$hTesis[0]->titulo}}</td>
                                                <td>{{$hTesis[0]->nombre_asesor." ".$hTesis[0]->apellidos_asesor}}</td>
                                                <td>{{$estado}}</td>
                                                <td style="text-align: center;">
                                                    @if($hTesis[0]->estado!=0)
                                                        <form id="proyecto-download" action="{{route('curso.descargaTesis')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="cod_cursoTesis" value="{{$hTesis[0]->cod_proyectotesis}}">
                                                            <a href="#" onclick="this.closest('#proyecto-download').submit()" @if($hTesis[0]->estado == 0) hidden @endif><i class='bx bx-sm bx-download'></i></a>
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
        @else
            @include('cards.avisoCard')
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
