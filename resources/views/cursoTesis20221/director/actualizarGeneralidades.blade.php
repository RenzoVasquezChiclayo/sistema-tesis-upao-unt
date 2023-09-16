@extends('plantilla.dashboard')
@section('titulo')
    Generalidades
@endsection
@section('css')
<style type="text/css">

</style>
@endsection
@section('contenido')
<div class="row" style="display: flex; align-items:center;">
    <div class="col-10">
        <form action="{{route('director.saveDatosGenerales')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                    <h5>Escuela</h5>
                    <select class="form-select" name="escuela" id="escuela">
                        @foreach ($escuela as $esc)
                            <option value="{{$esc->cod_escuela}}">{{$esc->nombre}}</option>
                        @endforeach
                      </select>
                </div>
                <div class="col-6">
                    <h5>Semestre academico</h5>
                    <select class="form-select" name="semestre_academico" id="semestre_academico" required>
                        <option value="2023-I">2023-I</option>
                        <option value="2023-II">2023-II</option>
                    </select>
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-4">
                    <h5>Linea de Investigacion</h5>
                    <div class="row">
                        <div class="col-10">
                            <table class="table table-warning" id="table_linea_investigacion">
                                @if (sizeof($linea_investigacion) > 0)
                                @php
                                    $indice_l_i = 0;
                                @endphp
                                    @foreach ($linea_investigacion as $l_i)
                                        <tbody>
                                            <tr id="filal_i{{ $indice_l_i }}">
                                                <td>{{$l_i->cod_tinvestigacion}}</td>
                                                <td>{{$l_i->descripcion}}</td>
                                                <td style=" text-align:center;">
                                                    <a href="#" id="l_i-{{ $indice_l_i }}"
                                                        class="btn btn-warning"
                                                        onclick="remover_vieja_gen(this);">-</a>
                                                    <input type="hidden" id="xl_i-{{ $indice_l_i }}"
                                                        value="{{ $l_i->cod_tinvestigacion }}">

                                            </td>
                                            </tr>
                                        </tbody>
                                        @php
                                            $indice_l_i++;
                                        @endphp
                                    @endforeach
                                @endif
                                <input type="hidden" id="valNl_i" value="{{ sizeof($linea_investigacion) }}">
                                <input type="hidden" name="listOldl_i" id="listOldl_i">
                              </table>
                            <div class="row">
                                <div class="col-4">
                                    <h6>Codigo:</h6>
                                    <input class="form-control" minlength="4" maxlength="4" type="text" name="cod_linea_investigacion" id="cod_linea_investigacion" autofocus>
                                    <p>(Maximo cuatro digitos)</p>
                                </div>
                                <div class="col-8">
                                    <h6>Descripcion:</h6>
                                    <input class="form-control" type="text" name="linea_investigacion" id="linea_investigacion">
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <input  class="btn btn-success" id="btnAsesor_" type="button" value="+" onclick="agregar_linea_inv();">
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <h5>De acuerdo al fin que persigue</h5>
                    <div class="row">
                        <div class="col-10">
                            <table class="table table-warning" id="table_fin_persigue">
                                @if (sizeof($fin_persigue) > 0)
                                @php
                                    $indice_f_p=0;
                                @endphp
                                    @foreach ($fin_persigue as $f_p)
                                        <tbody>
                                            <tr id="filaf_p{{ $indice_f_p }}">
                                                <td>{{$f_p->descripcion}}</td>
                                                <td style=" text-align:center;">
                                                    <a href="#" id="f_p-{{ $indice_f_p }}"
                                                        class="btn btn-warning"
                                                        onclick="remover_vieja_gen(this);">-</a>
                                                    <input type="hidden" id="xf_p-{{ $indice_f_p }}"
                                                        value="{{ $f_p->cod_fin_persigue }}">
                                            </tr>
                                        </tbody>
                                        @php
                                            $indice_f_p++;
                                        @endphp
                                    @endforeach
                                @endif
                                <input type="hidden" id="valNf_p" value="{{ sizeof($fin_persigue) }}">
                                <input type="hidden" name="listOldf_p" id="listOldf_p">
                            </table>
                            <h6>Descripcion:</h6>
                            <input class="form-control" type="text" name="fin_persigue" id="fin_persigue">

                        </div>
                        <div class="col-2">
                            <input  class="btn btn-success" id="btnAsesor_" type="button" value="+" onclick="agregar_fin_persigue();">
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <h5>De acuerdo al diseño de investigacion</h5>
                    <div class="row">
                        <div class="col-10">
                            <table class="table table-warning" id="table_diseno_investigacion">
                                @if (sizeof($diseno_investigacion) > 0)
                                @php
                                    $indice_d_i=0;
                                @endphp
                                    @foreach ($diseno_investigacion as $d_i)
                                        <tbody>
                                            <tr id="filad_i{{ $indice_d_i }}">
                                                <td>{{$d_i->descripcion}}</td>
                                                <td style=" text-align:center;">
                                                    <a href="#" id="d_i-{{ $indice_d_i }}"
                                                        class="btn btn-warning"
                                                        onclick="remover_vieja_gen(this);">-</a>
                                                    <input type="hidden" id="xd_i-{{ $indice_d_i }}"
                                                        value="{{ $d_i->cod_diseno_investigacion }}">
                                            </tr>
                                        </tbody>
                                        @php
                                            $indice_d_i++;
                                        @endphp
                                    @endforeach
                                @endif
                                <input type="hidden" id="valNd_i" value="{{ sizeof($diseno_investigacion) }}">
                                <input type="hidden" name="listOldd_i" id="listOldd_i">
                              </table>
                              <h6>Descripcion:</h6>
                            <input class="form-control" type="text" name="diseno_investigacion" id="diseno_investigacion">
                        </div>
                        <div class="col-2">
                            <input  class="btn btn-success" id="btnAsesor_" type="button" value="+" onclick="agregar_diseno_investigacion();">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end" style="margin: 30px;">
                <div class="col-4">
                    <input class="btn btn-success" type="submit" value="Guardar todo">
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
                    title: 'Datos guardados correctamente',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
    @elseif (session('datos') == 'oknot')
            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error al guardar los datos',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
    @endif
    <script type="text/javascript">
    var indicel_i = 0;
    var indicef_p = 0;
    var indiced_i = 0;
    const valOldl_i = document.getElementById('valNl_i').value;
        if(valOldl_i!=0 ){
            indicel_i = parseInt(valOldl_i);
        }
        function agregar_linea_inv(){
            linea_investigacion = document.getElementById('linea_investigacion').value;
            cod_linea_investigacion = document.getElementById('cod_linea_investigacion').value;
            fila = '<tbody><tr id="filal_i'+indicel_i+'"><td>'+cod_linea_investigacion+'</td><td><input type="hidden" name="id_linea_investigacion[]" value="'+cod_linea_investigacion+'_'+linea_investigacion+'">'+linea_investigacion+'</td><td><input  class="btn btn-danger" id="btnAsesor_" type="button" value="-" onclick="remover_linea_inv('+indicel_i+');"></td></tr></tbody>'
            document.getElementById('table_linea_investigacion').innerHTML += fila;
            document.getElementById('linea_investigacion').value = "";
            document.getElementById('cod_linea_investigacion').value = "";
            indicel_i++;
        }
        function remover_linea_inv(indice){
            document.getElementById('filal_i'+indice).remove();

        }
        function remover_vieja_gen(item){
            const iditem = item.id;

            const idindice = iditem.split("-");
            let code = document.getElementById('x'+iditem).value;
            if(document.getElementById('listOld'+idindice[0]).value == ""){
                document.getElementById('listOld'+idindice[0]).value = code;
            }else{
                document.getElementById('listOld'+idindice[0]).value += ","+code;
            }
            if(idindice[0]=='l_i'){
                document.getElementById('filal_i'+idindice[1]).remove();
            }else if(idindice[0]=='f_p'){
                document.getElementById('filaf_p'+idindice[1]).remove();
            }
            else if(idindice[0]=='d_i'){
                document.getElementById('filad_i'+idindice[1]).remove();
            }
        }

        function agregar_fin_persigue(){
            fin_persigue = document.getElementById('fin_persigue').value;
            fila = '<tbody><tr id="filaf_p'+indicef_p+'"><td><input type="hidden" name="id_fin_persigue[]" value="'+fin_persigue+'">'+fin_persigue+'</td><td><input  class="btn btn-danger" id="btnAsesor_" type="button" value="-" onclick="remover_fin_persigue('+indicef_p+');"></td></tr></tbody>'
            document.getElementById('table_fin_persigue').innerHTML += fila;
            document.getElementById('fin_persigue').value = "";
            indicef_p++;
        }
        function remover_fin_persigue(indice){
            document.getElementById('filaf_p'+indice).remove();

        }

        function agregar_diseno_investigacion(){
            diseno_investigacion = document.getElementById('diseno_investigacion').value;
            fila = '<tbody><tr id="filad_i'+indiced_i+'"><td><input type="hidden" name="id_diseno_investigacion[]" value="'+diseno_investigacion+'">'+diseno_investigacion+'</td><td><input  class="btn btn-danger" id="btnAsesor_" type="button" value="-" onclick="remover_dis_inves('+indiced_i+');"></td></tr></tbody>'
            document.getElementById('table_diseno_investigacion').innerHTML += fila;
            document.getElementById('diseno_investigacion').value ="";
            indiced_i++;
        }
        function remover_dis_inves(indice){
            document.getElementById('filad_i'+indice).remove();

        }
    </script>
@endsection