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
        <div class="row">
            @foreach ($autores as $autor)
                <div class="col">{{$autor->apellidos.', '.$autor->nombres}}</div>
            @endforeach

        </div>
        <input type="text" class="form-control" name="titulo" id="titulo" value="{{$tesis->titulo}}" readonly>
        <input type="text" class="form-control" name="asesor" id="asesor" value="{{$tesis->apellidosAsesor.', '.$tesis->nombresAsesor}}" readonly>
        <input type="datetime" class="form-control" name="fecha_stt" id="fecha_stt">
        <div class="row">
            <div class="col-4">1er Jurado</div>
            <div class="col-8">
                <select name="cboJurado1" id="cboJurado1">
                    <option value="0">-</option>
                    @foreach ($jurados as $jurado)
                        <option value="{{$jurado->cod_jurado}}">{{$jurado->apellidos.', '.$jurado->nombres}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">2do Jurado</div>
            <div class="col-8">
                <select name="cboJurado1" id="cboJurado1">
                    <option value="0">-</option>
                    @foreach ($jurados as $jurado)
                        <option value="{{$jurado->cod_jurado}}">{{$jurado->apellidos.', '.$jurado->nombres}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">Vocal</div>
            <div class="col-8">
                <select name="cboJurado1" id="cboJurado1">
                    <option value="0">-</option>
                    @foreach ($jurados as $jurado)
                        <option value="{{$jurado->cod_jurado}}">{{$jurado->apellidos.', '.$jurado->nombres}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">Extra</div>
            <div class="col-8">
                <select name="cboJurado1" id="cboJurado1">
                    <option value="0">-</option>
                    @foreach ($jurados as $jurado)
                        <option value="{{$jurado->cod_jurado}}">{{$jurado->apellidos.', '.$jurado->nombres}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@endsection
