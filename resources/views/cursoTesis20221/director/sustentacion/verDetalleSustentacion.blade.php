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
                    <option value="Presencial" @if(sizeof($existSustentacion)>0 && $existSustentacion[0]->modalidad == "Presencial") selected @endif>Presencial</option>
                    <option value="Virtual" @if(sizeof($existSustentacion)>0 && $existSustentacion[0]->modalidad == "Virtual") selected @endif>Virtual</option>
                </select>
                <div class="form-floating mt-2">
                    <textarea class="form-control" name="comentarioModalidad" id="comentarioModalidad" cols="3">{{sizeof($existSustentacion) > 0 ? $existSustentacion[0]->comentario : ''}}</textarea>
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
                    <select class="form-select" name="cboJurado2" id="cboJurado2">
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
                    <select class="form-select" name="cboJurado3" id="cboJurado3">
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
                    <select class="form-select" name="cboJurado4" id="cboJurado4">
                        <option value="0">-</option>
                        @foreach ($jurados as $jurado)
                            <option value="{{$jurado->cod_jurado}}">{{$jurado->apellidos.', '.$jurado->nombres}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex gap-4 mt-4">
                <div class="col-auto"><a href="{{route('director.sustentacion.verRegistrarSustentacion')}}" class="btn btn-outline-danger">Cancelar</a></div>
                <div class="col-auto"><button class="btn btn-success" type="button" onclick="verifyFields();"">@if(sizeof($existSustentacion)>0)Editar @else Registrar @endif</button></div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        let jurados = @json($juradoSustentacion);
        window.onload = function(){
            if(jurados.length>0){
                putJuradoSelect(nJurado = 4, prefixSelect= "cboJurado");
            }
        }

        function putJuradoSelect(nJurado, prefixSelect){
            for(let i=1; i<=nJurado; i++){
                let selectJurado = document.getElementById(`${prefixSelect}${i}`);
                for(let j=0; j<selectJurado.options.length;j++){
                    let optionValue = selectJurado.options[j].value;
                    if(jurados[i-1].cod_jurado == optionValue){
                        selectJurado.options[j].selected = true;
                        break;
                    }
                }
            }
        }

        function verifyFields(){
            let cboJurado1 = document.getElementById('cboJurado1');
            let cboJurado2 = document.getElementById('cboJurado2');
            let cboJurado3 = document.getElementById('cboJurado3');
            let cboJurado4 = document.getElementById('cboJurado4');

            let date = document.getElementById('fecha_stt');
            let time = document.getElementById('hora_stt');

            if(date.value == "" || time.value == "" ){
                alert('Debe colocar la fecha para la sustentacion.');
                return;
            }
            if(cboJurado1.selectedIndex <= 0 || cboJurado2.selectedIndex <= 0 || cboJurado3.selectedIndex <= 0 || cboJurado4.selectedIndex <= 0){
                alert('Debe completar todos los jurados.');
                return;
            }
            if(tieneOpcionesDuplicadas([cboJurado1.selectedIndex,cboJurado2.selectedIndex,cboJurado3.selectedIndex,cboJurado4.selectedIndex])){
                alert('No deben repetirse los jurados.');
                return;
            }
            document.getElementById("formDetalleSust").submit();
        }

        function tieneOpcionesDuplicadas(opciones) {
            let uniqueOptions = new Set(opciones);
            return opciones.length !== uniqueOptions.size;
        }
    </script>
@endsection
