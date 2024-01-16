@extends('plantilla.dashboard')
@section('titulo')
    Observaciones de Tesis
@endsection
@section('contenido')
    <div class="card-header">
        Lista de observaciones
    </div>
    <div class="card-body">
        <ul id="observation-list" class="list-group">

        </ul>
    </div>
@endsection
@section('js')
    <script>
        // Supongamos que recibes una lista de objetos llamada 'observations' del controlador
        const observations = @json($observaciones);

        // Función para mapear nombres de atributos a nombres más legibles
        const mapAttributeName = (attribute) => {
            const attributeMap = {
                'presentacion': 'Presentacion',
                'resumen': 'Resumen',
                'keyword': 'Palabras clave',
                'introduccion': 'Introduccion',

                'real_problematica': 'Realidad Problematica',
                'antecedentes': 'Antecedentes',
                'justificacion': 'Justificacion',
                'formulacion_prob': 'Formulacion del Problema',

                'marco_teorico': 'Marco Teorico',
                'marco_conceptual': 'Marco Conceptual',
                'marco_legal': 'Marco Legal',
                'form_hipotesis': 'Formulacion de la Hipotesis',

                'objeto_estudio': 'Objeto de Estudio',
                'poblacion': 'Poblacion',
                'muestra': 'Muestra',
                'metodos': 'Metodos',

                'tecnicas_instrum': 'Tecnicas de Instrumentacion',
                'instrumentacion': 'nstrumentacion',

                'estg_metodologicas': 'Estrategias Metodologicas',

                'discusion': 'Discusion',
                'conclusiones': 'Conclusiones',
                'recomendaciones': 'Recomendaciones',
                'resultados': 'Resultados',
            };
            return attributeMap[attribute] || "";
        };

        // Eliminar atributos con valor null y generar la lista en el HTML
        const observationListContainer = document.getElementById("observation-list");
        observations.forEach(observation => {
            const filteredObservation = {};

            // Eliminar atributos con valor null
            Object.keys(observation).forEach(key => {
                if (observation[key] !== null) {
                    filteredObservation[key] = observation[key];
                }
            });
            console.log(filteredObservation);
            // Generar la lista en el HTML
            const listItem = document.createElement("li");
            listItem.classList.add("list-group-item");
            let extra = 0;
            Object.keys(filteredObservation).forEach(key => {
                const observationKey = mapAttributeName(key);
                const observationValue = filteredObservation[key];

                const observationItem = document.createElement("p");
                if(extra == 0){
                    listItem.innerHTML += `<h6>${filteredObservation["nombres"]} ${filteredObservation["apellidos"]}</h6>`;
                }
                if(observationKey!=""){
                    observationItem.innerHTML += `<strong>${observationKey}: </strong> ${observationValue}`;

                }
                listItem.appendChild(observationItem);
                extra+=1;
            });

            observationListContainer.appendChild(listItem);
        });
    </script>
@endsection
