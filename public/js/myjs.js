var indiceRecurso=0;
var iObjetivo=0;
var iVariable=0;

var listObs = [];
var listTextObs = [];
var counter = 0;

var gFOTOS_GENERAL = [[],[],[],[],[],[],[],[],[],[],[],[]];
var gruposFOTOS = [];

//Variables para setMeses()


//Para agregar mas autores
var arrayAutores=[];
/*Esta funcion es implementada cuando se inicia la ventana y el proyecto de tesis
  ya se haya registrado antes.*/



window.onload = function() {

    const isObservacion = document.getElementById('verificaCorrect').value;
    if(isObservacion=='true'){

        const valuesObs = document.getElementById('txtValuesObs').value;
        listObs = valuesObs.split(',');

        for(let x=0; x<listObs.length; x++){
            if(listObs[x]!='recursos' && listObs[x]!='objetivos' && listObs[x]!='variables' && listObs[x]!='referencias' && listObs[x]!='localidad_institucion'){
                //Debo cambiar los id por los nombres del input o txtarea segun sea el caso.
                let valueTA = document.getElementById('txt'+listObs[x]).value;
                listObs[counter] = listObs[x];
                counter += 1;
                listTextObs.push(valueTA);
            }
        }

    }
    /*Asignar el valor para el indice del recurso en caso ya existan*/

    const valOldRecursos = document.getElementById('valNRecurso').value;
    if(valOldRecursos!=0 ){
        indiceRecurso = parseInt(valOldRecursos);
    }


    //Verificamos que se este corrigiendo alguna observacion
    const valOldObj = document.getElementById('valNObjetivo').value;
    if(valOldObj!=0 ){
        iObjetivo = parseInt(valOldObj);

    }

    const valOldVar = document.getElementById('valNVariable').value;
    if(valOldVar!=0 ){
        iVariable = parseInt(valOldVar);
    }
}
/*Esta funcion la hemos duplicado para aplicar solo cuando haya datos registrados en el cronograma*/
function setColorInit(id){

    const celda = document.getElementById(id);
    const ncelda = document.getElementById('n'+id);
    let cont = ncelda.value;
    let touch = parseInt(cont) + 1
    ncelda.value = touch;

    if(touch%2 != 0 ){
        celda.style.backgroundColor= "red";
    }else{
        celda.style.backgroundColor= "rgb(212, 212, 212)";
    }
}
/*Funcion para eliminar los recursos antiguos que ya estan registrados*/
function deleteOldRecurso(item){
    const iditem = item.id;
    const idindice = iditem.split("-");
    let code = document.getElementById('x'+iditem).value;
    if(document.getElementById('listOld'+idindice[0]).value == ""){
        document.getElementById('listOld'+idindice[0]).value = code;
    }else{
        document.getElementById('listOld'+idindice[0]).value += ","+code;
    }
    if(idindice[0]=='lrec'){
        document.getElementById('filaR'+idindice[1]).remove();
        //indiceRecurso--;
    }else if(idindice[0]=='lobj'){
        document.getElementById('filaO'+idindice[1]).remove();
        //iObjetivo--;
    }else if(idindice[0]=='lvar'){
        document.getElementById('filaV'+idindice[1]).remove();
        //iVariable--;
    }else if(idindice[0]=='lref'){

        document.getElementById('filaRe'+idindice[1]).remove();
        //iReferencia--;
    }


}
/*Funcion para validar que el titulo no sea mayor de 20 palabras*/
function validaText()
{

    primerBlanco = /^ /;
    ultimoBlanco = / $/;
    variosBlancos = /[ ]+/g;

    txtTitulo = document.getElementById("txttitulo").value;
    txtTitulo = txtTitulo.replace(variosBlancos," ");
    txtTitulo = txtTitulo.replace(primerBlanco,"");
    txtTitulo = txtTitulo.replace(ultimoBlanco,"");

    txtTituloValidado = txtTitulo.split(" ");

    if(txtTituloValidado.length > 20){
        document.getElementById("validateTitle").innerHTML = "Maximo 20 palabras";
        return false;
    } else {
        document.getElementById("validateTitle").innerHTML = "Aceptado";
        return true;
    }

}
/*Funcion para prohibir escribir numeros decimales u otro caracter*/
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : evt.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

 return true;
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
          tambien, estos meses estan separados por un '_' para conocer tambien el rango de estos*/
function saveMonths(){
    months = document.getElementById("txtmeses_ejecucion").value;
    list=[]
    cadena = ""
    hayMeses = false;
    for(i=1;i<=parseInt(months);i++){
        notnull = document.getElementById("n1Tr"+i).value;
        if((notnull%2) != 0 && notnull !=0){
            hayMeses = true;
            if(cadena!=""){
                cadena += "_" + i
            }else{
                cadena += i
            }
        }
    }
    if(hayMeses==true){
        hayMeses=false;
        cadena += "_1a"
    }else{
        return false;
    }

    for(i=1;i<=parseInt(months);i++){
        notnull = document.getElementById("n2Tr"+i).value;
        if((notnull%2) != 0 && notnull !=0){
            hayMeses = true;
            if(cadena!=""){
                cadena += "_" + i
            }else{
                cadena += i
            }
        }
    }
    if(hayMeses==true){
        hayMeses=false;
        cadena += "_2a"
    }else{
        return false;
    }

    for(i=1;i<=parseInt(months);i++){
        notnull = document.getElementById("n3Tr"+i).value;
        if((notnull%2) != 0 && notnull !=0){
            hayMeses = true;
            if(cadena!=""){
                cadena += "_" + i
            }else{
                cadena += i
            }
        }
    }
    if(hayMeses==true){
        hayMeses=false;
        cadena += "_3a"
    }else{
        return false;
    }

    for(i=1;i<=parseInt(months);i++){
        notnull = document.getElementById("n4Tr"+i).value;
        if((notnull%2) != 0 && notnull !=0){
            hayMeses=true;
            if(cadena!=""){
                cadena += "_" + i
            }else{
                cadena += i
            }
        }
    }
    if(hayMeses==true){
        hayMeses=false;
        cadena += "_4a"
    }else{
        return false;
    }
    document.getElementById("listMonths").value=cadena;
    return true;
}
/*Funcion para agregar cada referencia bibliografica en la tabla*/
var indice=0;

function agregarReferenciaB()
{
    listAutor="";
    autores4table = "";
    if(arrayAutores.length > 0){
        arrayAutores=ordenarArray(arrayAutores);
        for(i=0; i<arrayAutores.length;i++){
            if(i==0){
                autores4table += arrayAutores[i];
                listAutor += arrayAutores[i];
            }else{
                listAutor += "_" + arrayAutores[i];
                if(i==arrayAutores.length-1){
                    autores4table += ' y ' + arrayAutores[i];
                }else{
                    autores4table += ', ' + arrayAutores[i];
                }
            }
        }
    }else{
        listAutor = document.getElementById('txtAutorAPA').value;
        autores4table = listAutor;
    }


    document.getElementById('array_autores').value = listAutor;
    iAutor = 0;
    tipoAPA = document.getElementById("cboTipoAPA").selectedIndex;
    //autorApa = document.getElementById('txtAutorAPA').value;
    fPublicacion = document.getElementById('txtFechaPublicacion').value;
    tituloTrabajo = document.getElementById('txtTituloTrabajo').value;
    fuente = document.getElementById('txtFuente').value;
    editorial = document.getElementById('txtEditorial').value;
    titCapitulo = document.getElementById('txtTitleCap').value;
    numCapitulos = document.getElementById('txtNumCapitulo').value;

    titRevista = document.getElementById('txtTitleRev').value;
    volumenRevista = document.getElementById('txtVolumen').value;

    nombreWeb = document.getElementById('txtNameWeb').value;

    nombrePeriodista = document.getElementById('txtNamePeriodista').value;

    nombreInstitucion = document.getElementById('txtNameInsti').value;

    subtitInfo = document.getElementById('txtSubtitle').value;
    nombreEditorInfo = document.getElementById('txtNameEditor').value;

    if (tipoAPA == 1) {
        if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && editorial!="" && titCapitulo!="" && numCapitulos!=""){
        fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
            +indice+')">X</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
            +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
            +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
            +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
            +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
            +fuente+'">'+fuente+'</td><td><input type="hidden" name="ideditorial[]" value="'
            +editorial+'">'+editorial+'</td><td><input type="hidden" name="idtitCapitulo[]" value="'
            +titCapitulo+'">'+titCapitulo+'</td><td><input type="hidden" name="idnumCapitulos[]" value="'
            +numCapitulos+'">'+numCapitulos+'</td></tr></tbody>';
        document.getElementById('detalleReferencias').innerHTML += fila;
        indice++;
        clearReferences();

        }else{
            document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
        }
    } else if(tipoAPA == 2) {
        if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && titRevista!="" && volumenRevista!=""){
        fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
            +indice+')">X</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
            +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
            +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
            +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
            +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
            +fuente+'">'+fuente+'</td><td><input type="hidden" name="idtitRevista[]" value="'
            +titRevista+'">'+titRevista+'</td><td><input type="hidden" name="idvolumenRevista[]" value="'
            +volumenRevista+'">'+volumenRevista+'</td></tr></tbody>';
        document.getElementById('detalleReferencias').innerHTML +=fila;
        indice++;
        clearReferences();

        }else{
            document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
        }
    } else if(tipoAPA == 3) {
        if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && nombreWeb!=""){
        fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
            +indice+')">X</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
            +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
            +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
            +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
            +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
            +fuente+'">'+fuente+'</td><td><input type="hidden" name="idnombreWeb[]" value="'
            +nombreWeb+'">'+nombreWeb+'</td></tr></tbody>';
        document.getElementById('detalleReferencias').innerHTML +=fila;
        indice++;
        clearReferences();

        }else{
            document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
        }

    } else if(tipoAPA == 4) {
        if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && nombrePeriodista!=""){
        fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
            +indice+')">X</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
            +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
            +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
            +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
            +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
            +fuente+'">'+fuente+'</td><td><input type="hidden" name="idnombrePeriodista[]" value="'
            +nombrePeriodista+'">'+nombrePeriodista+'</td></tr></tbody>';
        document.getElementById('detalleReferencias').innerHTML +=fila;
        indice++;
        clearReferences();

        }else{
            document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
        }
    } else if(tipoAPA == 5) {
        if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && nombreInstitucion!=""){
        fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
            +indice+')">X</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
            +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
            +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
            +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
            +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
            +fuente+'">'+fuente+'</td><td><input type="hidden" name="idnombreInstitucion[]" value="'
            +nombreInstitucion+'">'+nombreInstitucion+'</td></tr></tbody>';
        document.getElementById('detalleReferencias').innerHTML+=fila;
        indice++;
        clearReferences();

        }else{
            document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
        }
    } else if(tipoAPA == 6) {
        if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && subtitInfo!="" && nombreEditorInfo!=""){
        fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
            +indice+')">X</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
            +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
            +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
            +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
            +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
            +fuente+'">'+fuente+'</td><td><input type="hidden" name="idsubtitInfo[]" value="'
            +subtitInfo+'">'+subtitInfo+'</td><td><input type="hidden" name="idnombreEditorInfo[]" value="'
            +nombreEditorInfo+'">'+nombreEditorInfo+'</td></tr></tbody>';
        document.getElementById('detalleReferencias').innerHTML += fila;
        indice++;
        clearReferences();

        }else{
            document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
        }
    }
    arrayAutores=[];
    return indice;

}
function quitarReferenciaB(item)
{
    document.getElementById('fila'+item).remove();
    //indice--;
    document.getElementById('txtAutorAPA').focus();
}
function clearReferences(){
    document.getElementById('txtFechaPublicacion').value = "";
    document.getElementById('txtTituloTrabajo').value = "";
    document.getElementById('txtFuente').value = "";

    document.getElementById('txtEditorial').value = "";
    document.getElementById('txtTitleCap').value = "";
    document.getElementById('txtNumCapitulo').value = "";

    document.getElementById('txtTitleRev').value = "";
    document.getElementById('txtVolumen').value = "";

    document.getElementById('txtNameWeb').value = "";

    document.getElementById('txtNamePeriodista').value = "";

    document.getElementById('txtNameInsti').value = "";

    document.getElementById('txtSubtitle').value = "";
    document.getElementById('txtNameEditor').value = "";
    document.getElementById('txtAutorAPA').value = "";
    document.getElementById("fullReference").innerHTML = '';
    document.getElementById('rowAddAutor').innerHTML = '';
    if(document.getElementById('chkMasAutor').checked){
        document.getElementById('chkMasAutor').click();
    }

}

function ordenarArray(arreglo){
    var extra = -1;
    var contador_a = 0;
    var ultimo_valor = -1;
    for(let i=0;i<arreglo.length;i++){
        if(arreglo[i]==""){
            contador_a++;
            if(contador_a<=1){
                extra=i;
            }
        }else{
            if(extra>=0){
                arreglo[extra]=arreglo[i];
                ultimo_valor = extra;
                extra = i;
                contador_a=1;

            }
        }
    }
    if(ultimo_valor!=-1){
        const vrest=arreglo.length-(ultimo_valor+1);
        arreglo.length = arreglo.length-vrest;
    }
    return arreglo;
}

function onChangeRecurso(){
    if(document.getElementById('cboTipoRecurso').value == 2){
        document.getElementById('cboSubtipoRecurso').hidden = false;
    } else {
        document.getElementById('cboSubtipoRecurso').hidden = true;
    }
}
//Funcion para agregar cada Recurso
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
    document.getElementById('recursosTable').innerHTML += fila;
    indiceRecurso++;
    document.getElementById('taRecurso').value="";
}

function quitarRecurso(item)
{
    document.getElementById('filaR'+item).remove();
    //indiceRecurso--;
}

//Funcion para agregar cada Recurso
function agregarObjetivo()
{

    tipo = document.getElementById("cboObjetivo");
    txtTipo = tipo.options[tipo.selectedIndex].text;

    descripcion = document.getElementById("taObjetivo").value;
    fila = '<tbody><tr id="filaO'+iObjetivo+'"><td><input type="hidden" name="idtipoObj[]" value="'+txtTipo+'">'+txtTipo+'</td><td><input type="hidden" name="iddescripcionObj[]" value="'+descripcion+'">'+descripcion+'</td><td align="center"><a href="#" class="btn btn-warning" onclick="quitarObjetivo('+iObjetivo+')">X</a></td></tr></tbody>';
    document.getElementById('objetivoTable').innerHTML +=fila;
    iObjetivo++;
    document.getElementById('taObjetivo').value="";

}
function quitarObjetivo(item)
{
    document.getElementById('filaO'+item).remove();
    //iObjetivo--;
}
function agregarVariable()
{
    descripcion = document.getElementById("taVariable").value;
    fila = '<tbody><tr id="filaV'+iVariable+'"><td><input type="hidden" name="iddescripcionVar[]" value="'+descripcion+'">'+descripcion+'</td><td align="center"><a href="#" class="btn btn-warning" onclick="quitarVariable('+iVariable+');">X</a></td></tr></tbody>';
    document.getElementById('variableTable').innerHTML +=fila;
    iVariable++;
    document.getElementById('taVariable').value="";
}
function quitarVariable(item)
{
    document.getElementById('filaV'+item).remove();
    //iVariable--;
}
//Funcion para generar el total del presupuesto
function verTotal(){
    cadena = ""
    total = 0.0;
    vextra = true;
    for(i=0;i<5;i++){
        precioCod = document.getElementById("cod_"+i).value;
        if(parseFloat(precioCod)>1 || precioCod != ""){
            total += parseFloat(precioCod);
            if(cadena!=""){
                cadena += "_" + precioCod;
            }else{
                cadena += precioCod;
            }
        }else{
            return false;
        }
    }

    precios = cadena.split('_');
    document.getElementById('precios').value = cadena;
    document.getElementById('total').value = parseFloat(total);
    document.getElementById('total').style.backgroundColor="yellow";
    return true;
}
/*Funcion para realizar un guardado de la tesis*/
function guardarCopia(){
    document.getElementById('isSaved').value="true";
    registerProject();
}
/*Funcion para dirigir a la ruta guardar y registrar los datos del proy. investigacion*/
function registerProject(){

    tipoInvestigacion = document.getElementById("cboTipoInvestigacion").selectedIndex;
    finInvestigacion = document.getElementById("cboFinInvestigacion").selectedIndex;
    disenInvestigacion = document.getElementById("cboDesignInvestigacion").selectedIndex;

    financiamiento = document.getElementById("cboFinanciamiento").selectedIndex;

    //Esto nos ayuda a saber si se esta haciendo una correccion
    const isCorrect = document.getElementById('verificaCorrect').value;
    verTotal();
    if(isCorrect!='true'){
        saveMonths();
        if(validaText()==false){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El titulo del proyecto es incorrecto, por favor verificar.'
            })
        }else{
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "Se guardara/enviara el Proyecto de Tesis!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, continuar!',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                if (result.isConfirmed) {
                    document.formTesis.submit();
                }
            })

        }
    }else{
        if(document.getElementById('CorreccionMes').value!=""){
            extra = saveMonths();
        }
        let corrigio = true;
        for(let x=0; x<counter; x++){
            let valueTA = document.getElementById('txt'+listObs[x]).value;
            if(valueTA == listTextObs[x]){
                corrigio = false;
            }
        }
        if(corrigio==true){
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "Se guardara/enviara el Proyecto de Tesis!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, continuar!',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                if (result.isConfirmed) {
                    document.formTesis.submit();
                }
            })
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe realizar las correcciones correspondientes.'
            })
        }

    }
}
function setVariosAutores(){
    if (document.getElementById('chkMasAutor').checked)
    {
        document.getElementById('btnVariosAutores').hidden = false;
        document.getElementById('rowVariosAutores').hidden = false;
    }else{
        document.getElementById('btnVariosAutores').hidden = true;
        document.getElementById('rowVariosAutores').hidden = true;
    }

}
function setTypeAPA(){
    document.getElementById('div-editorial').hidden = true;
    document.getElementById('div-titlecap').hidden = true;
    document.getElementById('div-numcap').hidden = true;

    document.getElementById('div-titlerev').hidden = true;
    document.getElementById('div-volumen').hidden = true;

    document.getElementById('div-nameweb').hidden = true;

    document.getElementById('div-nameperiodista').hidden = true;

    document.getElementById('div-nameinsti').hidden = true;

    document.getElementById('div-subtitle').hidden = true;
    document.getElementById('div-nameeditor').hidden = true;

    if(document.getElementById('cboTipoAPA').value == 1){
        document.getElementById('div-editorial').hidden = false;
        document.getElementById('div-titlecap').hidden = false;
        document.getElementById('div-numcap').hidden = false;
    }else if(document.getElementById('cboTipoAPA').value == 2){
        document.getElementById('div-titlerev').hidden = false;
        document.getElementById('div-volumen').hidden = false;
    }else if(document.getElementById('cboTipoAPA').value == 3){
        document.getElementById('div-nameweb').hidden = false;
    }else if(document.getElementById('cboTipoAPA').value == 4){
        document.getElementById('div-nameperiodista').hidden = false;
    }else if(document.getElementById('cboTipoAPA').value == 5){
        document.getElementById('div-nameinsti').hidden = false;
    }else{
        document.getElementById('div-subtitle').hidden = false;
        document.getElementById('div-nameeditor').hidden = false;
    }
}
var iAutor = 0;
function addAutor(){

    txtautor = document.getElementById('txtAutorAPA').value;
    if(txtautor!= ""){
        arrayAutores.push(txtautor);
        document.getElementById('rowAddAutor').innerHTML += '<div id="rAutor'+iAutor+'"><div class="input-group" ><input type="text" class="form-control box-autor" id="addAutor'+iAutor+'" value="'+txtautor+'" aria-describedby="btn'+iAutor+'" readonly >'+
                                            '<button class="btn btn-outline-danger" type="button" id="btn'+iAutor+'" onclick="deleteAutor('+iAutor+');" style="height: 25px; font-size:1.2vh;">x</button></div></div>';
        document.getElementById('txtAutorAPA').value="";
        iAutor +=1;
    }else{
        alert("Falta rellenar el autor");
    }
}
function deleteAutor(indice){
    if(indice >= 0){
        document.getElementById('rAutor'+indice).remove();
    }
}
//Funciones para el agregado de las imagenes en cada campo requerido

//Variables que ayudan al posicionamiento de TextArea e Images
var contadorGrupo=[0,0,0,0,0,0,0,0,0,0,0,0];
var cont_grupos = 0; //Esta variable es para obtener el numero de grupos que hay
var posImg = 0;
var contadorTxtArea =[0,0,0,0,0,0,0,0,0,0,0,0];
//Variable para los textos que necesiten imagenes
var temas_array=["RP","ANT","JI","FP"];
var array_ngi = [];
var num_img_grupo=[];
var num_grupos_img = 0;
var isDeleteImg=[];

function newGroupImage(iTema){
    fila = '<div class="row"><div class="mt-2" style="width:90px;"><input class="form-control text-center" style="border:none;" id="pCuentaImagen_'+temas_array[iTema]+'_'+contadorGrupo[iTema]+'" readonly>'+
            '</div><div class="btn-delete-group ml-1 mt-2" style="width:auto;"><a href="#" onclick="deleteGroup();"><i class="bx bx-sm bx-message-alt-x"></i>Eliminar grupo</a></div><div class="galerias"><div id="galeria_'+temas_array[iTema]+'_'+contadorGrupo[iTema]+'" style="display: grid;grid-auto-flow: column; max-width:auto;">'+
            '</div><div class="card" style="width: 12rem;" id="addimg_'+temas_array[iTema]+'_'+contadorGrupo[iTema]+'"><div class="card-body" onclick="newImagen('+iTema+','+contadorGrupo[iTema]+');" style="display:flex; align-items:center; text-align:center; justify-content:center; border: 1px dashed black;"><a ><i class="bx bx-sm bx-image-add"></i></br>Agregar imagen</a></div></div></div></div>'; //Esta card es para la imagen que se vaya desplazando
    document.getElementById('personalizado'+iTema).innerHTML +=fila;
    document.getElementById('insertImage'+temas_array[iTema]).hidden=true;
    document.getElementById('btnContinuar'+temas_array[iTema]).hidden=false;
    array_ngi.push(1);
    num_img_grupo.push(0);
    isDeleteImg.push(false);
    newImagen(iTema,contadorGrupo[iTema]);
    contadorGrupo[iTema] = contadorGrupo[iTema] + 1;
}
// "<input class='btn btn-success' type='button' value='+' id='btnAddFile_"+pos_grupo+"_"+array_ngi[pos_grupo]+"' onclick = 'newImagen("+iTema+",0,"+pos_grupo+","+array_ngi[pos_grupo]+");'>"
//Funcion para agregar un nuevo input de tipo file/imagen.
function newImagen(iTema,pos_grupo){
    posImg = array_ngi[pos_grupo]-1;
    fila = "<div class='card' style='width: 12rem; margin-right: 8px;' id='contenedor_"+temas_array[iTema]+"_"+pos_grupo+"_"+array_ngi[pos_grupo]+"'>"+
    "<img src='/img/profile-notfound.jpg' class='card-img-top img-fluid' alt='...' id='preview_"+temas_array[iTema]+"_"+pos_grupo+"_"+array_ngi[pos_grupo]+"'><div class='card-body'>"+
    "<input class='form-control form-control-sm' name='imagenes"+temas_array[iTema]+"[]' id='in_"+iTema+"_"+pos_grupo+"_"+array_ngi[pos_grupo]+"' type='file' onchange='cargaImg(this,"+iTema+","+pos_grupo+","+array_ngi[pos_grupo]+");' style='max-width:auto;'>"+
    "<input type='button' class='btn btn-danger mt-2' value='Delete' onclick='btnDeleteImg("+iTema+","+pos_grupo+","+array_ngi[pos_grupo]+")'>"+
    "</div></div>";

    document.getElementById('galeria_'+temas_array[iTema]+'_'+ pos_grupo).innerHTML +=fila;

    array_ngi[pos_grupo]=array_ngi[pos_grupo]+1;
    num_img_grupo[pos_grupo]=num_img_grupo[pos_grupo]+1;
    document.getElementById('pCuentaImagen'+"_"+temas_array[iTema]+"_"+pos_grupo).value = num_img_grupo[pos_grupo]+"/10";
    isDeleteImg[pos_grupo]=false;
}

//RECORDATORIO: CAMBIAR ESTA MRD
//Tratar con la funcion onchange dentro del input.
function cargaImg(element, iTema, pos_grupo,posimg){
        const imgpreview = document.querySelector('#preview_'+temas_array[iTema]+'_'+pos_grupo+'_'+posimg);
        let extPermitidas = /(.jpg|.png)$/i;
        if(!extPermitidas.exec(element.value)){
            alert('El archivo debe ser JPG o PNG');
            element.value = '';
        }else{
            const archivos = element.files;
            if(!archivos || !archivos.length){
                imgpreview.src = "";
            }
            const archivito = archivos[0];
            const objectURL = URL.createObjectURL(archivito);
            imgpreview.src = objectURL;
        }
}

//Funcion para agregar un txtarea de continuacion al file/imagen.
function btnContinuarTxt(iTema){
    gFOTOS_GENERAL[iTema].push(contadorGrupo[iTema]); //Evaluando eliminar esta linea
    document.getElementById('btnContinuar'+temas_array[iTema]).hidden=true;
    fila = "<div class='col-12 col-md-10 mt-2'><textarea class='form-control' name='txtArea"+temas_array[iTema]+"[]' id='newTextArea_"+temas_array[iTema]+"_"+contadorTxtArea[iTema]+"' style='height: 100px; resize:none;'></textarea></div>";
    document.getElementById('personalizado'+iTema).innerHTML +=fila;
    document.getElementById('insertImage'+temas_array[iTema]).hidden=false;
    contadorTxtArea[iTema]=contadorTxtArea[iTema]+1;
}
//Funcion para eliminar un contenedor de una imagen
function btnDeleteImg(iTema,pos_grupo,pos_contenedor){
    document.getElementById('contenedor_'+temas_array[iTema]+'_'+pos_grupo+'_'+pos_contenedor).hidden=true;
    num_img_grupo[pos_grupo]=num_img_grupo[pos_grupo]-1;
    document.getElementById('pCuentaImagen'+"_"+temas_array[iTema]+"_"+pos_grupo).value = num_img_grupo[pos_grupo]+"/10";
    isDeleteImg[pos_grupo]=true;

}

function deleteGroup(){
    alert('Eliminado');
}



//Funcion para tabla de reporte rol Director
var dato = [];
var filaDato = [];

/*window.onload = function() {
    rol = document.getElementById('rol').value;
    if (rol == "d-CTesis2022-1") {
        dato = document.getElementById('Codigo_Avance').value;
    }else if(rol == "a-CTesis2022-1"){
        dato = document.getElementById('Codigo_Avance_Asesor').value;
    }

    filaDato = dato.split('-');
    for (let i = 0; i < filaDato.length-1; i++) {
        alumno = filaDato[i].split('_');

        fila = '<tr><td><input name="alumnos_porcen_table[]" type="hidden" value="'+alumno[0]+'.'+parseInt(alumno[1])+'">'+alumno[0]+'</td><td><div class="progress" role="progressbar" aria-label="Example with label" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width: '+alumno[1]+'%">'+parseInt(alumno[1])+' %</div></div></td></tr>';
        document.getElementById('table-reportes').innerHTML +=fila;
    }

}
*/
//Funcion para descargar reporte de avance de proyecto de tesis
// function descargarReporteAvance(){
//     document.form-reporteProyT.submit();
// }
