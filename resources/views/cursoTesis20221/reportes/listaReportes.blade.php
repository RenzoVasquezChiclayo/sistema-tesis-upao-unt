@extends('plantilla.dashboard')
@section('titulo')
    Reportes
@endsection
@section('contenido')
<div class="card-header">
    Lista de reportes
</div>
<div class="card-body">
    @if (auth()->user()->rol == 4)
    <div class="row">
        <div class="col-3">
            <h4>% Avance Proyecto de Tesis</h4>
        </div>
        <div class="col-5">
            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: {{$porcentaje}}%">{{(int)$porcentaje}}%</div>
            </div>
        </div>

    </div>
@elseif (auth()->user()->rol == 3)
    <input type="hidden" name="Codigo_Avance_Asesor" id="Codigo_Avance_Asesor" value="{{$dato2}}">
    <input type="hidden" id="rol" value="a-CTesis2022-1">
    <div class="row">
        <div class="col-6">
            <table class="table" id="table-reportes">
                <thead>
                  <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Porcentaje de Avance</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                    </tr>
                </tbody>
              </table>
        </div>
    </div>
@elseif (auth()->user()->rol == 2)
    <div class="row">
        <div class="card text-bg-light mb-3" style="max-width: 18rem; margin-left: 5px;">
            <div class="card-header">Total Estudiantes</div>
            <div class="card-body" style="text-align: center">
                <h2 class="card-title">{{$totalEstudiantes}}</h2>
            </div>
        </div>
        <div class="card text-bg-light mb-3" style="max-width: 18rem; margin-left: 5px;">
            <div class="card-header">Total Asesores</div>
            <div class="card-body" style="text-align: center">
                <h2 class="card-title">{{$totalAsesores}}</h2>
            </div>
        </div>
    </div>
    <input type="hidden" name="Codigo_Avance" id="Codigo_Avance" value="{{$dato}}">
    <input type="hidden" id="rol" value="d-CTesis2022-1">
    <div class="row">
        <div class="col-6">
            <h2 style="text-align: center">Avances Proyecto de Tesis</h2>
            <form action="{{ route('director.descargar-reporteProyT') }}" method="get" id="form-reporteProyT">
                <table class="table" id="table-reportes">
                    <thead>
                      <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">Porcentaje de Avance</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                        </tr>
                    </tbody>
                  </table>
                  <div class="row">
                    <div class="col-4">
                        <input type="submit" class="btn btn-success" value="Descargar">
                    </div>
                </div>
            </form>
        </div>

    </div>
    @endif

</div>




@endsection
@section('js')
    <script src="./js/myjs.js"></script>
@endsection
