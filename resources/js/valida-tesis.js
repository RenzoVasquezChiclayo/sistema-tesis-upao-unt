/*Funcion para validar que el titulo no contenga mas de 20 palabras, sin contar espacios extras.*/
function validaText()
{

    primerBlanco = /^ /;
    ultimoBlanco = / $/;
    variosBlancos = /[ ]+/g;

    txtTitulo = document.getElementById("txtTitulo").value;
    txtTitulo = txtTitulo.replace(variosBlancos," ");
    txtTitulo = txtTitulo.replace(primerBlanco,"");
    txtTitulo = txtTitulo.replace(ultimoBlanco,"");

    txtTituloValidado = txtTitulo.split(" ");

    if(txtTituloValidado.length > 20){
        document.getElementById("validateTitle").innerHTML = "Maximo 20 palabras";

    } else {
        document.getElementById("validateTitle").innerHTML = "Aceptado";
    }

}

/*Funcion para prohibir escribir numeros decimales u otro caracter*/
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

 return true;
}

/*Funcion para redirigir cada button a una ruta especifica*/
function giveForm(){
    document.formTesis.action = "{{route('index')}}";
    document.formTesis.method = "GET";
    document.formTesis.submit();
}

/*Funcion para dirigir a la ruta guardar y registrar los datos del proy. investigacion*/
function registerProject(){
    //span = $("validateTitle").text();
    //if(span!="Aceptado"){
       //document.getElementById("txtTitulo").focus();
        //alert("El titulo debe contener menos de 20 palabras");
    //}
    saveMonths();
    document.formTesis.action = "{{route('guardarDoc')}}";
    document.formTesis.method = "POST";
    document.formTesis.submit();

}


/*Funcion para agregar las celdas referentes de los meses de ejecucion*/
function setMeses(){
    meses = document.getElementById("txtMesesEjecucion").value;
    for(i = 1;i<=meses; i++){
        document.getElementById("headers").innerHTML += '<th id="Mes'+i+'" scope="col">Mes '+i+'</th>'
        document.getElementById("1Tr").innerHTML += '<input type="hidden" id="n1Tr'+i+'" name="n1Tr'+i+'" value="0"><td id="1Tr'+i+'" onclick="setColorTable(this);"></td>'
        document.getElementById("2Tr").innerHTML += '<input type="hidden" id="n2Tr'+i+'" name="n2Tr'+i+'" value="0"><td id="2Tr'+i+'" onclick="setColorTable(this);"></td>'
        document.getElementById("3Tr").innerHTML += '<input type="hidden" id="n3Tr'+i+'" name="n3Tr'+i+'" value="0"><td id="3Tr'+i+'" onclick="setColorTable(this);"></td>'
        document.getElementById("4Tr").innerHTML += '<input type="hidden" id="n4Tr'+i+'" name="n4Tr'+i+'" value="0"><td id="4Tr'+i+'" onclick="setColorTable(this);"></td>'
    }

}

/*Funcion para pintar las celdas que se seleccionen para cada actividad*/
function setColorTable(celda){
    cont = document.getElementById("n"+celda.id).value;
    touch = parseInt(cont) + 1
    document.getElementById("n"+celda.id).value = touch;

    if(touch%2 != 0 ){
        celda.style.backgroundColor= "red";
    }else{
        celda.style.backgroundColor= "rgb(212, 212, 212)";
    }
}

/*Funcion para guardar los meses que duraron cada actividad del cronograma de trabajo
  tambien, estos meses estan separados por un '_' para conocer tambien el rando de estos*/
function saveMonths(){
    months = document.getElementById("txtMesesEjecucion").value;
    list=[]
    cadena = ""
    for(i=1;i<=parseInt(months);i++){
        notnull = document.getElementById("n1Tr"+i).value;
        if((notnull%2) != 0 && notnull !=0){
            if(cadena!=""){
                cadena += "_" + i
            }else{
                cadena += i
            }
        }
    }
    cadena += "_1a"
    //list.push(cadena)
    //cadena = ""

    for(i=1;i<=parseInt(months);i++){
        notnull = document.getElementById("n2Tr"+i).value;
        if((notnull%2) != 0 && notnull !=0){
            if(cadena!=""){
                cadena += "_" + i
            }else{
                cadena += i
            }
        }
    }
    //list.push(cadena)
    //cadena = ""
    cadena += "_2a"

    for(i=1;i<=parseInt(months);i++){
        notnull = document.getElementById("n3Tr"+i).value;
        if((notnull%2) != 0 && notnull !=0){
            if(cadena!=""){
                cadena += "_" + i
            }else{
                cadena += i
            }
        }
    }
    //list.push(cadena)
    //cadena = ""
    cadena += "_3a"

    for(i=1;i<=parseInt(months);i++){
        notnull = document.getElementById("n4Tr"+i).value;
        if((notnull%2) != 0 && notnull !=0){
            if(cadena!=""){
                cadena += "_" + i
            }else{
                cadena += i
            }
        }
    }
    //list.push(cadena)
    //cadena = ""
    cadena += "_4a"

    document.getElementById("listMonths").value=cadena;

}

/* Funcion para aagregar Recursos en la tabla */
var indice2 = 0




/*Funcion para agregar cada referencia bibliografica en la tabla*/
var indice=0;
function agregarReferenciaB()
{
    autorApa = document.getElementById('txtAutorAPA').value;
    fPublicacion = document.getElementById('txtFechaPublicacion').value;
    tituloTrabajo = document.getElementById('txtTituloTrabajo').value;
    fuente = document.getElementById('txtFuente').value;

    fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
            +indice+')">X</a></td><td><input type="hidden" name="idautorApa[]" value="'
            +autorApa+'">'+autorApa+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
            +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
            +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
            +fuente+'">'+fuente+'</td></tr></tbody>';
    $('#detalleReferencias').append(fila);
    indice++;

    $('#txtAutorAPA').val('');
    $('#txtFechaPublicacion').val('');
    $('#txtTituloTrabajo').val('');
    $('#txtFuente').val('');

}

function quitarReferenciaB(item)
{
    $('#fila'+item).remove();
    indice--;
    document.getElementById('txtAutorAPA').focus();
}

function onChangeRecurso(){
    if(document.getElementById('cboTipoRecurso').value == 2){
        document.getElementById('cboSubtipoRecurso').hidden = false;
    } else {
        document.getElementById('cboSubtipoRecurso').hidden = true;
    }
}

//Funcion para agregar cada Recurso
var indiceRecurso=0;
function agregarRecurso()
{
    tipo = document.getElementById("cboTipoRecurso");
    txtTipo = tipo.options[tipo.selectedIndex].text;

    subtipo = ""
    if(document.getElementById('cboTipoRecurso').value == 2){
        st = document.getElementById("cboSubtipoRecurso");
        subtipo = st.options[st.selectedIndex].text;
    }
    descripcion = document.getElementById("taRecurso").value;

    fila = '<tbody><tr id="filaR'+indiceRecurso+'"><td><input type="hidden" name="idtipo[]" value="'+txtTipo+'">'+txtTipo+'</td><td><input type="hidden" name="idsubtipo[]" value="'+subtipo+'">'+subtipo+'</td><td><input type="hidden" name="iddescripcion[]" value="'+descripcion+'">'+descripcion+'</td><td align="center"><a href="#" class="btn btn-warning" onclick="quitarRecurso('+indiceRecurso+')">X</a></td></tr></tbody>';
    $('#recursosTable').append(fila);
    indiceRecurso++;

}

function quitarRecurso(item)
{
    $('#filaR'+item).remove();
    indiceRecurso--;
}


//Funcion para agregar cada Recurso
var iObjetivo=0;
function agregarObjetivo()
{

    tipo = document.getElementById("cboObjetivo");
    txtTipo = tipo.options[tipo.selectedIndex].text;

    descripcion = document.getElementById("taObjetivo").value;
    fila = '<tbody><tr id="filaO'+iObjetivo+'"><td><input type="hidden" name="idtipoObj[]" value="'+txtTipo+'">'+txtTipo+'</td><td><input type="hidden" name="iddescripcionObj[]" value="'+descripcion+'">'+descripcion+'</td><td align="center"><a href="#" class="btn btn-warning" onclick="quitarObjetivo('+iObjetivo+')">X</a></td></tr></tbody>';
    $('#objetivoTable').append(fila);
    iObjetivo++;

}

function quitarObjetivo(item)
{
    $('#filaO'+item).remove();
    iObjetivo--;
}

var iVariable=0;
function agregarVariable()
{

    descripcion = document.getElementById("taVariable").value;
    fila = '<tbody><tr id="filaV'+iVariable+'"><td><input type="hidden" name="iddescripcionVar[]" value="'+descripcion+'">'+descripcion+'</td><td align="center"><a href="#" class="btn btn-warning" onclick="quitarVariable('+iVariable+');">X</a></td></tr></tbody>';
    $('#variableTable').append(fila);
    iVariable++;

}

function quitarVariable(item)
{
    $('#filaV'+item).remove();
    iVariable--;
}




