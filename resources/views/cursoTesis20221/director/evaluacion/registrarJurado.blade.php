@extends('plantilla.dashboard')
@section('titulo')
    Registrar Jurado
@endsection
@section('contenido')
    <div class="card-header">
        Registrar Jurado
    </div>
    <div class="card-body" style="text-align: start;">
        <div class="row">
            <form id="formJurado" name="formJurado" action="{{route('director.registrarJurado')}}" method="post">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-12 col-lg-6">
                            <label class="ms-1">Buscar asesor</label>
                            <div class="input-group">
                                <input id="codeAsesor" type="text" class="form-control" placeholder="Código del asesor" aria-label="Código del asesor" aria-describedby="btnSearch">
                                <button class="btn btn-outline-secondary" type="button" id="btnSearch" onclick="buscarAsesor();">Buscar</button>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="ms-1">Asesor</label>
                            <select name="selectAsesor" id="selectAsesor" class="form-control">
                                <option value="0">-</option>
                                @foreach ($asesores as $asesor)
                                    <option value="{{$asesor->cod_docente}}">{{ $asesor->nombres.' '.$asesor->apellidos }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-lg-6">
                            <label class="ms-1">Linea de investigacion</label>
                            <select name="selectTInvestigacion" id="selectTInvestigacion" class="form-control">
                                <option value="0">-</option>
                                @foreach ($tipoInvestigacion as $tInvest)
                                    <option value="{{$tInvest->cod_tinvestigacion}}">{{ $tInvest->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-lg-3">
                            <label for="">Fecha de la solicitud</label>
                            <input class="form-control" type="date" name="fechaActual" id="fechaActual" disabled>
                        </div>

                    </div>
                    <div class="row d-flex mb-3">
                        <div class="col-auto">
                            <button type="button" class="btn btn-secondary">Cancelar</button>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-success" onclick="tryToSend();">Registrar como jurado</button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Codigo docente</td>
                                        <td>Nombres y apellidos</td>
                                        <td>Linea de Investigacion</td>
                                        <td>Fecha de inicio</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jurados as $jurado)
                                        <tr>
                                            <td>{{$jurado->cod_docente}}</td>
                                            <td>{{$jurado->nombres.' '.$jurado->apellidos}}</td>
                                            <td>{{$jurado->descripcion}}</td>
                                            <td>{{$jurado->created_at}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                title: 'Jurado registrado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ha ocurrido un error. Intentelo denuevo.',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <script type="text/javascript">
        const asesores = @json($asesores);
        console.log(`asesores: ${asesores}`)
        //fecha
        let fechaActual = new Date();
        let formatoFecha = [
            fechaActual.getFullYear(),
            ('0' + (fechaActual.getMonth() + 1)).slice(-2),
            ('0' + fechaActual.getDate()).slice(-2)
        ].join('-');
        document.getElementById('fechaActual').value = formatoFecha;
        function buscarAsesor(){
            const codeAsesor = document.getElementById('codeAsesor').value;
            console.log(`codAsesor: ${codeAsesor}`);
            let asesorFound = null;
            asesores.forEach(e=>{
                if(e.cod_docente == codeAsesor){
                    asesorFound = e;
                }
            })
            console.log(`asesorFound: ${asesorFound}`);
            const selectAsesor = document.getElementById('selectAsesor');
            selectAsesor.value = asesorFound.cod_docente;
        }
        function tryToSend(){
            const asesor = document.getElementById('selectAsesor').value;
            const dinvestigacion = document.getElementById('selectTInvestigacion').value;
            if(asesor == 0 || dinvestigacion == 0){
                return false;
            }
            document.formJurado.submit();
        }
    </script>
@endsection
