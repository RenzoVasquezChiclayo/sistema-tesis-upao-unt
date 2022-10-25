@extends('plantilla.dashboard')
@section('titulo')
    Ver formato
@endsection
@section('css')
    <style type="text/css">
        .border-box{
            margin-top:20px;
            margin-left:5px;
            border: 0.5px solid rgba(0, 0, 0, 0.2);
            border-radius:20px;
            padding-top:5px;
            padding-bottom:10px;
        }

        .campus {
            display: flex;
            align-items: center;
        }
        .campus > div >.row{
            margin-bottom: 15px;
        }
    </style>
@endsection
@section('contenido')
<div class="row">
    <form name="formFormato" id="formFormato" action="" method="">
        @csrf
        <div class="row justify-content-md-center">
            <div class="col-11" style="margin-top:15px;">
                <div class="row" style="padding-bottom: 15px; display: flex; align-items: left;">
                    <div class="col-6 col-md-2" style="border: 0.8px dashed rgba(0, 0, 0, 0.39); text-align:center;">
                        <h4 style="color:rgba(0, 0, 0, 0.603)">Formato N°{{$formato[0]->cod_formato}}</h4>
                        <input type="hidden" name="codigoFormato" value="{{$formato[0]->codigo}}">
                    </div>

                </div>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-11">
                <div class="row" style="padding-bottom: 15px; display: flex; align-items: right; justify-content:right;">
                    <div class="col-5 col-md-4 col-xl-2" style="border: 0.5px solid gray; padding-bottom:10px;">
                        <div class="row" style="text-align: center;">
                            <h6>Foto del Egresado</h6>
                        </div>
                        <div class="row">
                            <div class="col-12" id="img-egresado" name="img-egresado" style="text-align:center;">
                                <img class="img-fluid" src="/plantilla/img/{{$img[0]->referencia}}" alt="Foto del egresado" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center" style="text-align: center;">
            <div class="col-11">
                <div class="row" style="padding-bottom: 20px;">
                    <h4>TITULO PROFESIONAL DE:</h4>
                    <input class="form-control" name="txtTituloProfe" id="txtTituloProfe" type="text" value="{{$formato[0]->tit_profesional}}"readonly>
                </div>
                <div class="row campus">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 col-md-2">
                                <h6 style="margin-top:10px;">APELLIDOS Y NOMBRES:</h6>
                            </div>
                            <div class="col-6">
                                <input class="form-control" name="txtApellidos" id="txtApellidos" type="text" value="{{$formato[0]->name_egresado.', '.$formato[0]->apellidos_egresado}}"readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <h6 style="margin-top:10px;">NUMERO DE MATRICULA:</h6>
                            </div>
                            <div class="col-6 col-md-8">
                                <input class="form-control" name="txtNumMatricula" id="txtNumMatricula" type="text" value="{{$formato[0]->cod_matricula}}" maxlength="10"readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <h6 style="margin-top:10px;">DNI:</h6>
                            </div>
                            <div class="col-6 col-md-8">
                                <input class="form-control" name="txtDNI" id="txtDNI" type="text" value="{{$formato[0]->dni}}" maxlength="8" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <h6 style="margin-top:10px;">FECHA DE NACIMIENTO:</h6>
                            </div>
                            <div class="col-6 col-md-8">
                                <input class="form-control" name="txtfNacimiento" id="txtfNacimiento" type="date" value="{{$formato[0]->fecha_nacimiento}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4 col-md-2">
                                <h6 style="margin-top:10px;">FACULTAD DE: </h6>
                            </div>
                            <div class="col-8 col-md-10">
                                <input class="form-control" name="txtFacultad" id="txtFacultad" type="text" value="{{$formato[0]->name_facultad}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-4">
                                <h6 style="margin-top:10px;">ESCUELA PROFESIONAL:</h6>
                            </div>
                            <div class="col-8">
                                <input class="form-control" name="txtEscuela" id="txtEscuela" type="text" value="{{$formato[0]->name_escuela}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <h6 style="margin-top:10px;">SEDE:</h6>
                            </div>
                            <div class="col-6 col-md-8">
                                <input class="form-control" name="txtSede" id="txtSede" type="text" value="{{$formato[0]->name_sede}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 col-md-3">
                                <h6 style="margin-top:10px;">UNIDAD DE 2DA ESPECIALIDAD EN: </h6>
                            </div>
                            <div class="col-6 col-md-9">
                                <input class="form-control" name="txt2daEsp" id="txt2daEsp" type="text" value="@if ($formato[0]->sgda_especialidad!=null){{$formato[0]->sgda_especialidad}} @endif" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <h6 style="margin-top:10px;">PROGRAMA EXTRAORDINARIO DE FORMACION DOCENTE-SEDE: </h6>
                            </div>
                            <div class="col-6 col-md-8">
                                <input class="form-control" name="txtProgFormacion" id="txtProgFormacion" type="text" value="@if ($formato[0]->prog_extraordinario!=null){{$formato[0]->prog_extraordinario}} @endif" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4 col-md-2">
                                <h6 style="margin-top:10px;">DOMICILIO:</h6>
                            </div>
                            <div class="col-8 col-md-10">
                                <input class="form-control" name="txtDireccion" id="txtDireccion" type="text" value="{{$formato[0]->direccion}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <h6 style="margin-top:10px;">TELEFONO FIJO:</h6>
                            </div>
                            <div class="col-6 col-md-8">
                                <input class="form-control" name="txtTelefonoFijo" id="txtTelefonoFijo" type="text" value="{{$formato[0]->tele_fijo}}" maxlength="8" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <h6 style="margin-top:10px;">TELEFONO CELULAR:</h6>
                            </div>
                            <div class="col-6 col-md-8">
                                <input class="form-control" name="txtTelefonoCelular" id="txtTelefonoCelular" type="text" value="{{$formato[0]->tele_celular}}" maxlength="12" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 col-md-2">
                                <h6 style="margin-top:10px;">CORREO ELECTRONICO:</h6>
                            </div>
                            <div class="col-6 col-md-10">
                                <input class="form-control" name="txtCorreo" id="txtCorreo" type="email" value="{{$formato[0]->correo}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 col-md-3">
                                <h6 style="margin-top:10px;">MODALIDAD PARA OBTENER TITULO:</h6>
                            </div>
                            <div class="col-6 col-md-9">
                                <input class="form-control" name="txtModalidadTit" id="txtModalidadTit" type="text" value="{{$formato[0]->modalidad_titulo}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <h6 style="margin-top:10px;">FECHA DE SUSTENTACION:</h6>
                            </div>
                            <div class="col-6 col-md-8">
                                <input class="form-control" name="txtFechaSustentacion" id="txtFechaSustentacion" type="date" value="@if ($formato[0]->fecha_sustentacion!=null){{$formato[0]->fecha_sustentacion}} @endif" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-6 col-md-4" style="text-align: right;">
                                <h6 style="margin-top:10px;">FECHA DE COLACION:</h6>
                            </div>
                            <div class="col-6 col-md-8">
                                <input class="form-control" name="txtFechaColacion" id="txtFechaColacion" type="date" value="@if ($formato[0]->fecha_colacion!=null){{$formato[0]->fecha_colacion}} @endif" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 col-md-2">
                                <h6 style="margin-top:10px;">CENTRO DE TRABAJO:</h6>
                            </div>
                            <div class="col-6 col-md-10">
                                <input class="form-control" name="txtCentroTrabajo" id="txtCentroTrabajo" type="text" value="{{$formato[0]->centro_labores}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 col-md-2">
                                <h6 style="margin-top:10px;">PROCEDENCIA DE COLEGIO:</h6>
                            </div>
                            <div class="col-6 col-md-6">
                                <input class="form-control" name="txtColegio" id="txtColegio" type="text" value="{{$formato[0]->colegio}}" readonly>
                            </div>
                            <div class="col-6 col-md-2">
                                <input type="text" class="form-control" id="rubroColegio" name="rubroColegio" value="{{$formato[0]->tipo_colegio}}" readonly>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row campus">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <h6 style="margin-top:10px;">LINEA DE INVESTIGACION:</h6>
                            </div>
                            <div class="col-6 col-md-8">
                                <input class="form-control" name="txtTipoInvestigacion" id="txtTipoInvestigacion" type="text" value="{{$formato[0]->lineaInv}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row campus">
                    <div class="col-4">
                        <a class="btn btn-warning" target="_blank" href="{{ asset('plantilla/pdf-egresado/'.$file[0]->fut)}}">Ver FUT</a>
                    </div>
                    <div class="col-4">
                        <a class="btn btn-warning" target="_blank" href="{{ asset('plantilla/pdf-egresado/'.$file[0]->constancia)}}">Ver Constancia de No Duplicidad</a>
                    </div>
                    <div class="col-4">
                        <a class="btn btn-warning" target="_blank" href="{{ asset('plantilla/pdf-egresado/'.$file[0]->recibo)}}">Ver Recibo de Pago</a>
                    </div>
                </div>
                <br>
                <div class="row campus">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-2">
                                <h6 style="margin-top:10px;">ASESOR:</h6>
                            </div>
                            <div class="col-6 col-md-8 input-group">
                                <input class="form-control" list="datalistOptions"name="txtCodDocente" id="txtCodDocente" type="text" value="@if($formato[0]->cod_docente != null){{$formato[0]->cod_docente}}@endif" placeholder="Codigo del Docente" required>
                                <datalist id="datalistOptions">
                                    @foreach ($asesores as $asesor)
                                        <option value="{{$asesor->cod_docente}}">
                                    @endforeach
                                </datalist>
                                {{-- <input class="form-control" name="txtCodDocente" id="txtCodDocente" type="text" value="@if($formato[0]->cod_docente != null) {{$formato[0]->cod_docente}} @endif" placeholder="Codigo del Docente" required> --}}
                                <input class="btn btn-outline-success" id="btnSearchAsesor" type="button" onclick="searchAsesor();" value="Search">
                                <input type="hidden" name="hiddenCodDocente" id="hiddenCodDocente" value="@if($formato[0]->cod_docente != null){{$formato[0]->cod_docente}}@endif">
                            </div>
                            <div class="col-12" style="text-align: left;">
                                <div class="row">
                                    <div class="col-5" style="text-align: center">
                                        <span id="span-asesor" ></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @foreach ($asesores as $asesor)
                        <div class="row border-box" id="{{$asesor->cod_docente}}"
                        @if ($asesor->cod_docente != $formato[0]->cod_docente)
                            hidden
                        @endif
                        >
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-6">
                                    <label for="txtNombreAsesor" class="form-label">Apellidos y Nombres</label>
                                    <input class="form-control" name="txtNombreAsesor" id="txtNombreAsesor" type="text" value="{{$asesor->nombres}}" readonly>
                                </div>
                                <div class="col-6">
                                    <label for="cboGrAcademicoAsesor" class="form-label">Grado Academico</label>
                                    <input class="form-control" name="txtGrAcademicoAsesor" id="txtGrAcademicoAsesor" type="text" value="{{$asesor->grado_academico}}" readonly>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-6">
                                    <label for="txtTProfesional" class="form-label">Titulo Profesional</label>
                                    <input class="form-control" name="txtTProfesional" id="txtTProfesional" type="text" value="{{$asesor->titulo_profesional}}" readonly>
                                </div>
                                <div class="col-6">
                                    <label for="txtDireccionAsesor" class="form-label">Dirección laboral y/o domiciliaria</label>
                                    <input class="form-control" name="txtDireccionAsesor" id="txtDireccionAsesor" type="text" value="{{$asesor->direccion}}" readonly>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>


            </div>
            <div class="row" style="padding-top: 20px; padding-bottom:20px;">
                <div class="col-7 col-xl-5 col-xxl-4">
                    <div class="row" style="text-align:right; ">
                        <div class="col-8 col-md-4">
                            <input class="btn btn-success" type="button" value="Actualizar formato" onclick="uploadFormato();" style="margin-right:20px;">
                        </div>
                        <div class="col-4 col-md-3">
                            <a href="{{route('director.formatos')}}" type="button" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </form>
</div>
@endsection
@section('js')
    <script type="text/javascript">
        function uploadFormato(){
            document.formFormato.action = "{{route('director.continueFormat')}}";
            document.formFormato.method = "POST";
            document.formFormato.submit();
        }

        let code_asesor="";
        function searchAsesor(){
            let last_code = code_asesor;
            const itsasesor = document.getElementById('hiddenCodDocente').value;
            if(itsasesor!=""){
                last_code = itsasesor;
            }

            code_asesor = document.getElementById('txtCodDocente').value;
            if(!!document.getElementById(code_asesor)){
                document.getElementById(code_asesor).hidden = false;
                document.getElementById('hiddenCodDocente').value = code_asesor;
                document.getElementById('span-asesor').innerHTML='';
                if(last_code!=""){
                    document.getElementById(last_code).hidden = true;
                }
            }else{
                document.getElementById('span-asesor').innerHTML='No existe el asesor';
                if(last_code!=""){
                    document.getElementById(last_code).hidden = true;
                }
            }
        }

    </script>
@endsection
