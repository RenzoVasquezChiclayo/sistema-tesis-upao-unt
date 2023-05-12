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
                                    @foreach ($linea_investigacion as $l_i)
                                        <tbody>
                                            <tr>
                                                <td>{{$l_i->cod_tinvestigacion}}</td>
                                                <td>{{$l_i->descripcion}}</td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                @endif
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
                                    @foreach ($fin_persigue as $f_p)
                                        <tbody>
                                            <tr>
                                                <td>{{$f_p->descripcion}}</td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                @endif
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
                                    @foreach ($diseno_investigacion as $d_i)
                                        <tbody>
                                            <tr>
                                                <td>{{$d_i->descripcion}}</td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                @endif
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
    var indice = 0;
        function agregar_linea_inv(){
            linea_investigacion = document.getElementById('linea_investigacion').value;
            cod_linea_investigacion = document.getElementById('cod_linea_investigacion').value;
            fila = '<tbody><tr id="fila'+indice+'"><td>'+cod_linea_investigacion+'</td><td><input type="hidden" name="id_linea_investigacion[]" value="'+cod_linea_investigacion+'_'+linea_investigacion+'">'+linea_investigacion+'</td></tr></tbody>'
            document.getElementById('table_linea_investigacion').innerHTML += fila;
            document.getElementById('linea_investigacion').value = "";
            document.getElementById('cod_linea_investigacion').value = "";
            indice++;
        }

        function agregar_fin_persigue(){
            fin_persigue = document.getElementById('fin_persigue').value;
            fila = '<tbody><tr id="fila'+indice+'"><td><input type="hidden" name="id_fin_persigue[]" value="'+fin_persigue+'">'+fin_persigue+'</td></tr></tbody>'
            document.getElementById('table_fin_persigue').innerHTML += fila;
            document.getElementById('fin_persigue').value = "";
            indice++;
        }

        function agregar_diseno_investigacion(){
            diseno_investigacion = document.getElementById('diseno_investigacion').value;
            fila = '<tbody><tr id="fila'+indice+'"><td><input type="hidden" name="id_diseno_investigacion[]" value="'+diseno_investigacion+'">'+diseno_investigacion+'</td></tr></tbody>'
            document.getElementById('table_diseno_investigacion').innerHTML += fila;
            document.getElementById('diseno_investigacion').value ="";
            indice++;
        }
    </script>
@endsection
