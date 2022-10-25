@extends('plantilla.dashboard')
@section('titulo')
    Historial de Correcciones
@endsection
@section('css')
    <style type="text/css">
        .box-search{
            display: flex;
            justify-content: right;
            align-items: right;
            margin-top:15px;
            margin-bottom:10px;
        }
        .box-center{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top:10px;
            margin-bottom:10px;
        }

        #table-formato > thead > tr > td{
            color: rgb(40, 52, 122);
            font-style: italic;
        }
        .border-box{
            margin-bottom:8px;
            margin-left:5px;
            border: 0.5px solid rgba(0, 0, 0, 0.2);
            border-radius:20px;
            padding-top:5px;
            padding-bottom:10px;
        }

    </style>
@endsection
@section('contenido')
    <div class="row">
        @if (sizeof($historial)==0 && $tesis == null)
            <div class="row" style="display:flex; align-items:center; justify-content: center; margin-top:15px;">
                <div class="col-8 border-box">
                    <div class="row">
                        <div class="col-12">
                            <h4 style="color:red;">Aviso!</h4>
                            <hr style="border: 1px solid black;" />
                        </div>
                        <div class="col-12">
                            <p>Esta vista estara habilitada cuando se haya registrado alguna observacion en su proyecto de tesis. Vuelve luego para observar si ya se proceso tu solicitud.
                                Si existe algun inconveniente y/o queja envia un correo a <a href="#"><u>example@unitru.edu.pe</u></a> para mas informacion.</p>
                        </div>

                    </div>
                </div>
            </div>
        @endif
        @if (sizeof($historial)>0)

            <div class="col-12">
                <br>
                <br>
                <div class="row box-center">
                    <div class="col-10 ">
                        <h5><b>Historial de Correcciones del Proyecto de Tesis</b></h5>
                        <div class="row">
                            <table id="table-formato" class="table table-bordered table-striped table-responsive-md">
                                <thead>
                                    <tr>
                                        <td>Fecha</td>
                                        <td>Asesor</td>
                                        <td>Observacion</td>
                                        <td style="text-align:center;">Ver</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach ($historial as $histo)
                                        <tr>
                                            <td>{{$histo->fecha}}</td>
                                            <td>{{$histo->nombre_asesor}}</td>
                                            <td>{{$histo->observacionNum}}</td>
                                            <td style="text-align:center;"><a href="{{route('',$histo->cod_observaciones)}}"><i class="far fa-eye"></i></a></td>
                                        </tr>
                                        @php
                                            $count++;
                                        @endphp
                                    @endforeach

                                </tbody>
                            </table>

                        </div>


                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('js')
<script type="text/javascript">
    setTimeout(function(){
        document.querySelector('#mensaje').remove();
    },2000);
</script>
@endsection
