@extends('plantilla.dashboard')
@section('titulo')
    Informacion del usuario
@endsection
@section('contenido')
    <div class="row" style="text-align: center;">

        <div class="col-7 col-md-10" style="margin:0px auto;margin-top:50px; border: 0.5px solid rgba(0, 0, 0, 0.2); border-radius:18px;">
            <div class="row" style="padding: 10px;">
                <div class="col-12" style="text-align: left;">
                    <h4>Informacion del usuario</h4>
                    <hr style="width:100%; border: 0.3px solid black;"/>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <img class="img-fluid" src="/img/{{$img}}" alt="imagen de perfil" style="width:300px;">
                        </div>
                        <div class="col-12 col-md-8">
                            <form action="{{route('save_user')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-10 col-md-6" style="text-align: left">
                                        <h5>Usuario</h5>
                                        <p>{{auth()->user()->name}}</p>
                                        <input type="hidden" id="txtCodUsuario" name="txtCodUsuario" value="{{auth()->user()->name}}" >
                                    </div>
                                    @if (auth()->user()->rol == 'CTesis2022-1')
                                        <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                            <h5>DNI</h5>
                                            <p>{{$estudiante->dni}}</p>
                                        </div>
                                        <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                            <h5>Nombres</h5>
                                            <input type="text" class="form-control" value="{{$estudiante->nombres}}" name="txtnewnombres" id="txtnewnombres" required>
                                        </div>
                                        <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                            <h5>Apellidos</h5>
                                            <input type="text" class="form-control" value="{{$estudiante->apellidos}}" name="txtnewapellidos" id="txtnewapellidos" required>
                                        </div>
                                    @elseif (auth()->user()->rol == 'a-CTesis2022-1')
                                        <div class="col-10 col-md-10" style="text-align: left; margin-bottom:15px;">
                                            <h5>Nombres</h5>
                                            <input type="text" class="form-control" value="{{$asesor->nombres}}" name="txtnewnombres" id="txtnewnombres" required>
                                        </div>
                                        <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                            <h5>Condicion</h5>
                                            <p>{{$asesor->grado_academico}}</p>
                                        </div>
                                        <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                            <h5>Escuela</h5>
                                            <input type="text" class="form-control" value="{{$asesor->titulo_profesional}}" name="txtnewtitulo" id="txtnewtitulo" required>
                                        </div>
                                        <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                            <h5>Direccion</h5>
                                            <input type="text" class="form-control" value="{{$asesor->direccion}}" name="txtnewdireccion" id="txtnewdireccion" required>
                                        </div>
                                    @endif
                                    <div class="col-12" style="text-align: left;">
                                        <h4>Actualizar Contraseña</h4>
                                        <hr style="width:100%; border: 0.3px solid black;"/>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#mActualizarContra">Actualizar Contraseña</button>
                                    </div>

                                    {{-- Modal para Actualizar Contraseña --}}
                                    <div class="modal" id="mActualizarContra">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Actualizar Contraseña</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <div class="col-12 col-md-10" style="text-align: left; margin-bottom:15px;">
                                                                <h5>Nueva contraseña</h5>
                                                                <input type="password" class="form-control" name="txtNuevaContra" id="txtNuevaContra" required>
                                                                <input type="hidden" id="older-password" value="">
                                                            </div>
                                                            <div class="col-12 col-md-10" style="text-align: left; margin-bottom:15px;">
                                                                <h5>Repetir nueva contraseña</h5>
                                                                <input type="password" class="form-control" onchange="verificaContra();" id="txtRepNuevaContra" name="txtRepNuevaContra" required>
                                                                <span id="guardadoContra"></span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input id="btnEnvioPassword" type="submit" class="btn btn-success" value="Guardar">
                                                        </div>
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div class="modal" id="mAvisoPassword">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Aviso</h4>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row" style="padding: 20px">
                        <p>Se recomienda a los estudiantes, realizar la actualizacion de su contraseña para mayor seguridad y evitar robo de informacion.</p>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>

            </div>
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
                title: 'Contraseña actulizada correctamente',
                showConfirmButton: false,
                timer: 1200
                })
            </script>
    @elseif (session('datos') == 'oknot')
            <script>
                Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al actulizar contraseña',
                showConfirmButton: false,
                timer: 1200
                })
            </script>
    @endif
    <script type="text/javascript">

        window.onload = function() {
          validateChanged();
        };

        const get_user = document.getElementById("").value;
        if(get_user!=""){

        }

        function aviso(){
            var myModal = document.getElementById('mAvisoPassword');
            $('#mAvisoPassword').modal('show');
        }

        function validateChanged(){
            let usuario = document.getElementById('txtCodUsuario').value;
            let password = document.getElementById('older-password').value;
            if(usuario == password) {
                setTimeout(() => {
                    aviso();
                }, 800);
            }
        }


        function verificaContra(){
            contraNueva = document.getElementById("txtNuevaContra").value;
            repContraNueva = document.getElementById("txtRepNuevaContra").value;

            if (contraNueva != repContraNueva) {
                document.getElementById('btnEnvioPassword').disabled = true;
                alert("Ambas contraseñas deben ser iguales");

            }else{
                document.getElementById('btnEnvioPassword').disabled = false;
            }
        }
    </script>
@endsection

