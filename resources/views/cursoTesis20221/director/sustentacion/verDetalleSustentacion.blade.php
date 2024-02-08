@extends('plantilla.dashboard')
@section('titulo')
    Detalle Sustentacion
@endsection
@section('css')
    <style type="text/css">

    </style>
@endsection
@section('contenido')
    <div class="card-header">
        Detalle de la Sustentación
    </div>
    <div class="card-body">
        <form name="formDetalleSust" id="formDetalleSust" method="POST" action="{{route('director.sustentacion.actualizarSustentacion')}}">
            @csrf
            <input type="hidden" name="codTesis" value="{{$tesis->cod_tesis}}">
            <input type="hidden" name="codSustentacion" value="{{sizeof($existSustentacion) > 0 ? $existSustentacion[0]->cod : ''}}">
            <div class="col-12">
                <h6>Autores</h6>
                <ul>
                    @foreach ($autores as $autor)
                    <li>{{$autor->apellidos.', '.$autor->nombres}}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-12 mt-3">
                <label for="titulo">Titulo de la tesis</label>
                <input type="text" class="form-control" name="titulo" id="titulo" value="{{$tesis->titulo}}" readonly>
            </div>
            <div class="col-12 mt-3">
                <label for="asesor">Asesor</label>
                <input type="text" class="form-control" name="asesor" id="asesor" value="{{$tesis->apellidosAsesor.', '.$tesis->nombresAsesor}}" readonly>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <label for="modalidad">Modalidad</label>
                <select class="form-select" name="modalidad" id="modalidad">
                    <option value="Presencial">Presencial</option>
                    <option value="Virtual">Virtual</option>
                </select>
                <div class="form-floating mt-2">
                    <textarea class="form-control" name="comentarioModalidad" id="comentarioModalidad" cols="3">{{sizeof($existSustentacion) > 0 ? $existSustentacion[0]->modalidad : ''}}</textarea>
                    <label for="comentarioModalidad">Comentario (Opcional)</label>
                  </div>
            </div>
            <div class="col-12 mt-3">
                @php
                    $date = '';
                    $time = '';
                    if(sizeof($existSustentacion) > 0){
                        $datetime = Carbon\Carbon::parse($existSustentacion[0]->fecha_stt);
                        $date = $datetime->toDateString();
                        $time = $datetime->toTimeString();
                    }
                @endphp
                <label for="">Fecha y hora de la sustentación</label>
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <input type="date" class="form-control" name="fecha_stt" id="fecha_stt" value="{{$date}}">
                    </div>
                    <div class="col-12 col-sm-4">
                        <input type="time" class="form-control" name="hora_stt" id="hora_stt" value="{{$time}}">
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <h6>Jurados</h6>
                <div class="col-12 col-sm-2">1er Jurado</div>
                <div class="col-12 col-sm-8">
                    <select class="form-select" name="cboJurado1" id="cboJurado1">
                        <option value="0">-</option>
                        @foreach ($jurados as $jurado)
                            <option value="{{$jurado->cod_jurado}}">{{$jurado->apellidos.', '.$jurado->nombres}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 col-sm-2">2do Jurado</div>
                <div class="col-12 col-sm-8">
                    <select class="form-select" name="cboJurado1" id="cboJurado1">
                        <option value="0">-</option>
                        @foreach ($jurados as $jurado)
                            <option value="{{$jurado->cod_jurado}}">{{$jurado->apellidos.', '.$jurado->nombres}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 col-sm-2">Vocal</div>
                <div class="col-12 col-sm-8">
                    <select class="form-select" name="cboJurado1" id="cboJurado1">
                        <option value="0">-</option>
                        @foreach ($jurados as $jurado)
                            <option value="{{$jurado->cod_jurado}}">{{$jurado->apellidos.', '.$jurado->nombres}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 col-sm-2">Extra</div>
                <div class="col-12 col-sm-8">
                    <select class="form-select" name="cboJurado1" id="cboJurado1">
                        <option value="0">-</option>
                        @foreach ($jurados as $jurado)
                            <option value="{{$jurado->cod_jurado}}">{{$jurado->apellidos.', '.$jurado->nombres}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex gap-4 mt-4">
                <div class="col-auto"><button class="btn btn-outline-danger">Cancelar</button></div>
                <div class="col-auto"><button class="btn btn-success" type="submit">Registrar</button></div>
            </div>
        </form>
    </div>
@endsection
