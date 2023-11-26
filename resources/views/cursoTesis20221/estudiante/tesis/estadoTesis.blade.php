@extends('plantilla.dashboard')
@section('titulo')
    Estado de la Tesis
@endsection
@section('contenido')
<div class="card-header">
    Estado de la Tesis
</div>
<div class="card-body">
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
                            <div class="col-12">
                                <div class="row">
                                    <div class="table-responsive">
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
                                                    <td>@if ($asesor!=null){{$asesor->nombres." ".$asesor->apellidos}}@endif</td>
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
            </div>
        @else
            <div class="row d-flex" style="align-items:center; justify-content: center;">
                <div class="col-8 border-box mt-3">
                    <div class="row">
                        <div class="col">
                            <h4 style="color:red;">Aviso!</h4>
                            <hr style="border: 1px solid black;" />
                        </div>

                        <div class="col">
                            <p>Esta vista estará habilitada cuando se te designe algun asesor para el curso.
                                Si existe algun inconveniente y/o queja envia un correo a <a href="#">
                                    <>example@unitru.edu.pe</u>
                                </a> para mas información.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('datos')=='ok')
        <script>
            Swal.fire(
                'Guardado/Enviado!',
                'Tesis guardado/enviado correctamente',
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
