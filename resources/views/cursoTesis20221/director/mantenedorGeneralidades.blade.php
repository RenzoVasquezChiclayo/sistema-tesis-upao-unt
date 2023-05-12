@extends('plantilla.dashboard')
@section('titulo')
    Mantenedor Generalidades
@endsection
@section('css')
<style type="text/css">

</style>
@endsection
@section('contenido')
<div class="row" style="display: flex; align-items:center;">
    <div class="col-10">
        <div class="row justify-content-end">
            <div class="col-6">
                <h5>Filtrar por semestre:</h5>
                <div class="col-5">
                    <form id="listGeneralidades" name="listGeneralidades" method="get">
                        <div class="row">
                            <div class="input-group">
                                <select class="form-select" name="buscarpor_semestre" id="buscarpor_semestre">
                                    <option value="20231">2023-I</option>
                                </select>
                                <button class="btn btn-primary" type="submit" id="btn-search">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <div class="row" style="margin-top: 20px;">
                    <h5>Linea de Investigacion</h5>
                        <div class="col-10">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Accion</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($lineasInves))
                                        @foreach ($lineasInves as $l_i)
                                        <tr>
                                            <td>{{$l_i->cod_tinvestigacion}}</td>
                                            <td>{{$l_i->descripcion}}</td>
                                            <td>
                                                <form id="form-linea-inves" method="post" action="{{route('director.lineaInvesEditar')}}">
                                                    @csrf
                                                    <input type="hidden" name="auxid" value="{{$l_i->cod_tinvestigacion}}">
                                                    <a href="#" class="btn btn-warning" onclick="this.closest('#form-linea-inves').submit();"><i class='bx bx-sm bx-edit-alt'></i></a>
                                                </form>
                                            </td>
                                                <td>
                                                    <form id="formLineaInvesDelete" name="formLineaInvesDelete" method="post" action="{{route('director.deleteLineaInves')}}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input type="hidden" name="auxidDelete" value="{{$l_i->cod_tinvestigacion}}">
                                                        <a href="#" class="btn btn-danger btn-eliminar" onclick="alertaConfirmacion(this);"><i class='bx bx-message-square-x' ></i></a>
                                                    </form>
                                                </td>
                                        </tr>
                                        @endforeach
                                    @endif


                                </tbody>
                              </table>
                        </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <h5>Fin que persigue</h5>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Accion</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (!empty($fin_persigue))
                            @foreach ($fin_persigue as $f_p)
                            <tr>
                                <td>{{$f_p->cod_fin_persigue}}</td>
                                <td>{{$f_p->descripcion}}</td>
                                    <td>
                                        <form id="formFinPersigueDelete" name="formFinPersigueDelete" method="post" action="{{route('director.deleteFinPersigue')}}">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="auxidDeleteF_P" value="{{$f_p->cod_fin_persigue}}">
                                            <a href="#" class="btn btn-danger btn-eliminar" onclick="alertaConfirmacionF_P(this);"><i class='bx bx-message-square-x' ></i></a>
                                        </form>
                                    </td>
                            </tr>
                            @endforeach
                        @endif

                    </tbody>
                  </table>
            </div>
            <div class="row" style="margin-top: 20px;">
                <h5>Diseno de Investigacion</h5>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Accion</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (!empty($diseno_investigacion))
                            @foreach ($diseno_investigacion as $d_i)
                            <tr>
                                <td>{{$d_i->cod_diseno_investigacion}}</td>
                                <td>{{$d_i->descripcion}}</td>
                                    <td>
                                        <form id="formDisInvestigaDelete" name="formDisInvestigaDelete" method="post" action="{{route('director.deleteDisInvestiga')}}">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="auxidDeleteD_I" value="{{$d_i->cod_diseno_investigacion}}">
                                            <a href="#" class="btn btn-danger btn-eliminar" onclick="alertaConfirmacionD_I(this);"><i class='bx bx-message-square-x' ></i></a>
                                        </form>
                                    </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                  </table>
            </div>
    </div>

</div>

@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('datos') == 'okEdit')
            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Editado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
    @elseif (session('datos') == 'oknotEdit')
            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error al editar',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
    @elseif (session('datos') == 'okDelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Eliminado correcxtamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknotDelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <script type="text/javascript">
        function editarLinea(formulario, contador){
            formulario.closest('#form-linea-inves'+contador).submit();
        }

        function alertaConfirmacion(e){
            Swal.fire({
            title: 'Estas Seguro que deseas eliminar?',
            text: "No podras revertirlo",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.closest('#form-linea-inves').submit();
                }
            });
        }
        function alertaConfirmacionF_P(e){
            Swal.fire({
            title: 'Estas Seguro que deseas eliminar?',
            text: "No podras revertirlo",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.closest('#formFinPersigueDelete').submit();
                }
            });
        }
        function alertaConfirmacionD_I(e){
            Swal.fire({
            title: 'Estas Seguro que deseas eliminar?',
            text: "No podras revertirlo",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.closest('#formDisInvestigaDelete').submit();
                }
            });
        }
    </script>
@endsection
