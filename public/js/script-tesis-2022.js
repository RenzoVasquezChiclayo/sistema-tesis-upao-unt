
/*Arreglos*/
let array_keyword = [];
let array_autores = [];
let obj_keyword = [];
let obj_resultadosImg = [];
let obj_resultadosTxt = [];
let obj_anexosImg = [];
let obj_anexosTxt = [];

let keyword_deleted=[];
let array_rowField = [{'field':'resultados','counter':0},{'field':'anexos','counter':0}]; // Contiene el contador de rows de cada campo que lleva imagenes.
let array_taField = [{'field':'resultados','counter':0},{'field':'anexos','counter':0}]; // Contiene el contador de textarea.
let array_sendRow = []; //Se enviara esta lista de rows resultados, que seran capturados en el controller.
let array_sendRowA = []; //Se enviara esta lista de rows anexos, que seran capturados en el controller.
let array_imgRow = []; // Contiene el contador de imagenes de cada row. // {'idrow': 0,'field': 'resultados','counter':0}
const array_campos = ['resultados','anexos'];

/*Variables*/
let iAutor = 0;
var indice_referencia=0;
var iObjetivo=0;
const cod_matricula = document.getElementById('txtCodMatricula').value; // Codigo de matricula del alumno
/*Pruebas*/
/** */

/*Recibido de la base de datos*/
const get_keyword = document.getElementById('get_keyword').value;
const get_resultadosImg = document.getElementById('resultados_getImg').value;
const get_resultadosTxt = document.getElementById('resultados_getTxt').value;
const get_anexosImg = document.getElementById('anexos_getImg').value;
const get_anexosTxt = document.getElementById('anexos_getTxt').value;

/*Dibujar los keywords al inicio*/
if(get_keyword != ""){
    obj_keyword = JSONtoArray(get_keyword);
    drawChipsKeyword();
}
/*Dibujar las imagenes de resultados al inicio*/
if(get_resultadosImg !="[]"){
    obj_resultadosImg = JSONtoArrayImage(get_resultadosImg);
    /*Dibujar los cuadros de texto*/
    obj_resultadosTxt = get_resultadosTxt.split('%&%');
    initImageTxt('resultados',obj_resultadosTxt.length>1);
}

/*Dibujar las imagenes de anexos al inicio*/
if(get_anexosImg !="[]"){
    obj_anexosImg = JSONtoArrayImage(get_anexosImg);
    /*Dibujar los cuadros de texto*/
    obj_anexosTxt = get_anexosTxt.split('%&%');
    initImageTxt('anexos',obj_anexosTxt.length>1);
}


const btnAgregar = document.getElementById('btn_agregark');
btnAgregar.addEventListener('click',()=>{
    btnAgregar.disabled = (array_keyword.length + obj_keyword.length > 4);
});

/*Inicializar las imagenes que estan en bd.*/
function initImageTxt(fieldname,containText){
    let actualGroup = -1;
    let contadorGrupo = 0;
    let obj_initImg = (fieldname == "resultados") ? obj_resultadosImg : obj_anexosImg;
    let obj_initTxt = (fieldname == "resultados") ? obj_resultadosTxt : obj_anexosTxt;

    if(containText){
        document.getElementById(`txt${fieldname}`).value = obj_initTxt[0];
    }
    // console.log(`entro: ${obj_initImg}`);
    for(let i=0; i<obj_initImg.length;i++){
        // objeto -> {id:item.id, tipo:item.tipo, grupo:item.grupo, ruta:item.ruta}
        // Imprime imagen
        if(contadorGrupo >= 5){
            document.getElementById(`${fieldname}_addimg_${actualGroup}`).disabled = true;
        }
        if(actualGroup != obj_initImg[i].grupo){
            if(actualGroup >= 0){
                document.getElementById(`${fieldname}_counterlocal_${actualGroup}`).value = `${contadorGrupo}/5`;
                contadorGrupo = 0;
            }
            actualGroup = obj_initImg[i].grupo;
            document.getElementById(`${fieldname}_btn_addImage`).click();
            if(actualGroup+1 < obj_initTxt.length){
                // Imprime el texto
                const indexArray = array_taField.map(item => item.field).indexOf(fieldname);
                const counterRow = array_taField[indexArray].counter;
                document.getElementById(`${fieldname}_btn_addField`).click();
                document.getElementById(`${fieldname}_textfield_${counterRow}`).value = obj_initTxt[actualGroup+1];
            }
        }
        contadorGrupo ++;  //Aumenta el numero de img que existen en el grupo
        const imageField = document.createElement('img');
        imageField.style.width = "200px";
        imageField.style.height = "200px";
        imageField.src = `./cursoTesis-2022/img/${cod_matricula}-Tesis/${fieldname}/${obj_initImg[i].ruta}`;
        document.getElementById(`${fieldname}_listimg_${obj_initImg[i].grupo}`).appendChild(imageField);

        if(i >= obj_initImg.length-1){
            document.getElementById(`${fieldname}_counterlocal_${actualGroup}`).value = `${contadorGrupo}/5`;
            contadorGrupo = 0;
        }

    }


}


/*Funcion para validar que el titulo no sea mayor de 20 palabras*/
function validaText() {
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


function guardarCopia(){
    document.getElementById('isSaved').value="true";
    registerProject();
}

/* Valido para los campos opcionales*/
function displayOptional(element){
    //Separamos el id para obtener el nombre
    const array_element = element.id.split('-')
    const isVisible = document.getElementById(`d-${array_element[1]}`).hidden;
    if(isVisible){
        document.getElementById(`icon-${array_element[1]}`).hidden = !isVisible;
        document.getElementById(`btn-${array_element[1]}`).hidden = isVisible;
        document.getElementById(`d-${array_element[1]}`).hidden = !isVisible;
    }else{
        document.getElementById(`icon-${array_element[1]}`).hidden = !isVisible;
        document.getElementById(`btn-${array_element[1]}`).hidden = isVisible;
        document.getElementById(`d-${array_element[1]}`).hidden = !isVisible;
    }
}


/*Funcion para dirigir a la ruta guardar y registrar los datos de la tesis*/
function registerProject(){
    document.getElementById('list_keyword').value = array_keyword.toString();
    document.getElementById('resultados_sendRow').value = array_sendRow.toString();
    document.getElementById('anexos_sendRow').value = array_sendRowA.toString();
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
                document.formTesis2022.submit();
            }
        })

    }


}

function addKeyword(){
    const ckeyword = document.getElementById('i_keyword').value;
    if(ckeyword != ""){
        const fila ='<div id="chip_'+array_keyword.length+'" class="col-6 col-sm-3 chip">'+
                            '<div><strong>'+ckeyword+'</strong></div>'+
                            '<button type="button" onclick="deleteKeyword('+array_keyword.length+');"><i class="bx bx-xs bx-x"></i></button>'+
                    '</div>';
        document.getElementById('chips').innerHTML += fila;
        array_keyword.push(ckeyword);
    }else{
        alert('Falta escribir la palabra clave.');
    }
    document.getElementById('i_keyword').value = "";
}

function deleteKeyword(position){
    // Eliminar mediante la posicion del elemento.
    array_keyword.splice(position, 1);
    document.getElementById(`chip_${position}`).remove();
    btnAgregar.disabled = (array_keyword.length + obj_keyword.length > 4);
}

/*Esta funcion nos permite ordenar el array, sacando los elementos de arreglo y poniendolos en orden sin espacios. */
function ordenarArray(arreglo) {
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
// ------------------------------------------
function agregarObjetivo() {

    tipo = document.getElementById("cboObjetivo");
    txtTipo = tipo.options[tipo.selectedIndex].text;

    descripcion = document.getElementById("taObjetivo").value;

    fila = '<tbody><tr id="filaO'+iObjetivo+'"><td><input type="hidden" name="idtipoObj[]" value="'+txtTipo+'">'+txtTipo+'</td><td><input type="hidden" name="iddescripcionObj[]" value="'+descripcion+'">'+descripcion+'</td><td align="center"><a href="#" class="btn btn-danger" onclick="quitarObjetivo('+iObjetivo+')"><i class="bx bx-x"></i>Eliminar</a></td></tr></tbody>';
    document.getElementById('objetivoTable').innerHTML +=fila;

    iObjetivo++;
    document.getElementById('taObjetivo').value="";

}
function quitarObjetivo(item)
{
    document.getElementById('filaO'+item).remove();
    //iObjetivo--;
}

// -----------------------------
function agregarReferenciaB() {
    let listAutor="";
    let autores4table = "";
    if(array_autores.length > 0){
        array_autores=ordenarArray(array_autores);
        for(i=0; i<array_autores.length;i++){
            if(i==0){
                autores4table += array_autores[i];
                listAutor += array_autores[i];
            }else{
                listAutor += "_" + array_autores[i];
                if(i==array_autores.length-1){
                    autores4table += ' y ' + array_autores[i];
                }else{
                    autores4table += ', ' + array_autores[i];
                }
            }
        }
    }else{
        listAutor = document.getElementById('txtAutorAPA').value;
        autores4table = listAutor;
    }

    array_autores=[];
    //Reiniciamos el contador de autores a 0.
    iAutor = 0;

    document.getElementById('array_autores').value = listAutor;
    const tipoAPA = document.getElementById("cboTipoAPA").selectedIndex;

    const fPublicacion = document.getElementById('txtFechaPublicacion').value;
    const tituloTrabajo = document.getElementById('txtTituloTrabajo').value;
    const fuente = document.getElementById('txtFuente').value;

    const editorial = document.getElementById('txtEditorial').value;
    const itCapitulo = document.getElementById('txtTitleCap').value;
    const numCapitulos = document.getElementById('txtNumCapitulo').value;

    const titRevista = document.getElementById('txtTitleRev').value;
    const volumenRevista = document.getElementById('txtVolumen').value;

    const nombreWeb = document.getElementById('txtNameWeb').value;

    const nombrePeriodista = document.getElementById('txtNamePeriodista').value;

    const nombreInstitucion = document.getElementById('txtNameInsti').value;

    const subtitInfo = document.getElementById('txtSubtitle').value;
    const nombreEditorInfo = document.getElementById('txtNameEditor').value;

    if (tipoAPA == 1) {
        if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && editorial!="" && itCapitulo!="" && numCapitulos!=""){
            fila ='<tbody><tr id="fila'+indice_referencia+'"><td align="center"><a href="#" class="btn btn-danger" onclick="quitarReferenciaB('
                +indice_referencia+')"><i class="bx bx-x"></i>Eliminar</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
                +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
                +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
                +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
                +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
                +fuente+'">'+fuente+'</td><td><input type="hidden" name="ideditorial[]" value="'
                +editorial+'">'+editorial+'</td><td><input type="hidden" name="idtitCapitulo[]" value="'
                +itCapitulo+'">'+itCapitulo+'</td><td><input type="hidden" name="idnumCapitulos[]" value="'
                +numCapitulos+'">'+numCapitulos+'</td></tr></tbody>';
            document.getElementById('detalleReferencias').innerHTML += fila;
            indice_referencia++;
            clearReferences();

        }else{
            document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
        }
    } else if(tipoAPA == 2) {
        if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && titRevista!="" && volumenRevista!=""){
            fila ='<tbody><tr id="fila'+indice_referencia+'"><td align="center"><a href="#" class="btn btn-danger" onclick="quitarReferenciaB('
                +indice_referencia+')"><i class="bx bx-x"></i>Eliminar</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
                +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
                +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
                +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
                +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
                +fuente+'">'+fuente+'</td><td><input type="hidden" name="idtitRevista[]" value="'
                +titRevista+'">'+titRevista+'</td><td><input type="hidden" name="idvolumenRevista[]" value="'
                +volumenRevista+'">'+volumenRevista+'</td></tr></tbody>';
            document.getElementById('detalleReferencias').innerHTML +=fila;
            indice_referencia++;
            clearReferences();
        }else{
            document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
        }
    } else if(tipoAPA == 3) {
        if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && nombreWeb!=""){
            fila ='<tbody><tr id="fila'+indice_referencia+'"><td align="center"><a href="#" class="btn btn-danger" onclick="quitarReferenciaB('
                +indice_referencia+')"><i class="bx bx-x"></i>Eliminar</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
                +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
                +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
                +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
                +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
                +fuente+'">'+fuente+'</td><td><input type="hidden" name="idnombreWeb[]" value="'
                +nombreWeb+'">'+nombreWeb+'</td></tr></tbody>';
            document.getElementById('detalleReferencias').innerHTML +=fila;
            indice_referencia++;
            clearReferences();
        }else{
            document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
        }

    } else if(tipoAPA == 4) {
        if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && nombrePeriodista!=""){
            fila ='<tbody><tr id="fila'+indice_referencia+'"><td align="center"><a href="#" class="btn btn-danger" onclick="quitarReferenciaB('
                +indice_referencia+')"><i class="bx bx-x"></i>Eliminar</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
                +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
                +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
                +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
                +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
                +fuente+'">'+fuente+'</td><td><input type="hidden" name="idnombrePeriodista[]" value="'
                +nombrePeriodista+'">'+nombrePeriodista+'</td></tr></tbody>';
            document.getElementById('detalleReferencias').innerHTML +=fila;
            indice_referencia++;
            clearReferences();
        }else{
            document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
        }
    } else if(tipoAPA == 5) {
        if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && nombreInstitucion!=""){
            fila ='<tbody><tr id="fila'+indice_referencia+'"><td align="center"><a href="#" class="btn btn-danger" onclick="quitarReferenciaB('
                +indice_referencia+')"><i class="bx bx-x"></i>Eliminar</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
                +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
                +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
                +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
                +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
                +fuente+'">'+fuente+'</td><td><input type="hidden" name="idnombreInstitucion[]" value="'
                +nombreInstitucion+'">'+nombreInstitucion+'</td></tr></tbody>';
            document.getElementById('detalleReferencias').innerHTML+=fila;
            indice_referencia++;
            clearReferences();
        }else{
            document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
        }
    } else if(tipoAPA == 6) {
        if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && subtitInfo!="" && nombreEditorInfo!=""){
            fila ='<tbody><tr id="fila'+indice_referencia+'"><td align="center"><a href="#" class="btn btn-danger" onclick="quitarReferenciaB('
                +indice_referencia+')"><i class="bx bx-x"></i>Eliminar</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
                +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
                +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
                +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
                +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
                +fuente+'">'+fuente+'</td><td><input type="hidden" name="idsubtitInfo[]" value="'
                +subtitInfo+'">'+subtitInfo+'</td><td><input type="hidden" name="idnombreEditorInfo[]" value="'
                +nombreEditorInfo+'">'+nombreEditorInfo+'</td></tr></tbody>';
            document.getElementById('detalleReferencias').innerHTML += fila;
            indice_referencia++;
            clearReferences();
        }else{
            document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
        }
    }
    return indice_referencia;
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
function addAutor(){
    txtautor = document.getElementById('txtAutorAPA').value;
    if(txtautor!= ""){
        array_autores.push(txtautor);
        document.getElementById('rowAddAutor').innerHTML += '<div id="rAutor'+iAutor+'"><div class="input-group" ><input type="text" class="form-control box-autor" id="addAutor'+iAutor+'" value="'+txtautor+'" aria-describedby="btn'+iAutor+'" readonly >'+
                                            '<button class="btn btn-outline-danger" type="button" id="btn'+iAutor+'" onclick="deleteAutor('+iAutor+');" style="height: 25px; font-size:1.2vh;">x</button></div></div>';
        document.getElementById('txtAutorAPA').value="";
        iAutor +=1;
    }else{
        alert("Falta rellenar el autor");
    }
}
function deleteAutor(indiceAutor){
    if(indiceAutor >= 0){
        document.getElementById('rAutor'+indiceAutor).remove();
    }
}

/*Recibir los datos de keyword en formato JSON y asignarle a un array de objetos.*/
function JSONtoArray(v_json){
    let array_objetos = [];
    let jsonParse = JSON.parse(v_json);
    jsonParse.forEach((item)=>{
        let objeto = {id:item.id_detalle_keyword,keyword:item.keyword};
        array_objetos.push(objeto)
    });
    // console.log(array_objetos)
    return array_objetos;
}

/*Recibir los datos de imagenes en formato JSON y asignarle a un array de objetos.*/
function JSONtoArrayImage(v_json){
    let array_objetos = [];
    let jsonParse = JSON.parse(v_json);
    jsonParse.forEach((item)=>{
        let objeto = {id:item.id, tipo:item.tipo, grupo:item.grupo, ruta:item.ruta};
        array_objetos.push(objeto)
    });
    // console.log(array_objetos)
    return array_objetos;
}


/*Dibujar los chips en caso existan keywords guardados*/
function drawChipsKeyword(){
    obj_keyword.forEach((item)=>{
        const fila ='<div id="getchip_'+item.id+'" class="col-6 col-sm-3 chip">'+
                            '<div><strong>'+item.keyword+'</strong></div>'+
                            '<button type="button" onclick="throwKeyword('+item.id+');"><i class="bx bx-xs bx-x"></i></button>'+
                    '</div>';
        document.getElementById('chips').innerHTML += fila;
    });
}
function throwKeyword(v_idkeyword){
    obj_keyword = obj_keyword.filter((item)=> item.id!=v_idkeyword);
    console.log(obj_keyword);
    console.log(array_keyword);
    document.getElementById(`getchip_${v_idkeyword}`).remove();
    keyword_deleted.push(v_idkeyword);
    btnAgregar.disabled = (array_keyword.length + obj_keyword.length > 4);
}

/*Agregar imagenes y separar campos*/
function addRowImage(element){
    const fieldbyid = element.id.split('_')[0];
    const indexArray = array_rowField.map(item => item.field).indexOf(fieldbyid);
    const counterRow = array_rowField[indexArray].counter;
    const contenedorRow = document.getElementById(`${fieldbyid}_contenedor`);

    const contenedorField = document.createElement('div');
    contenedorField.id = `${fieldbyid}_rowImage_${counterRow}`;
    contenedorField.className= "row";
    const firstDivField = document.createElement('div');
    firstDivField.className = "my-2 d-flex";
    const inputField = document.createElement('input');
    inputField.className="form-control input-counter text-center me-3";
    inputField.id=`${fieldbyid}_counterlocal_${counterRow}`;
    inputField.readOnly = true;
    inputField.value = "0/0";
    const linkField = document.createElement('a');
    linkField.href = "#";
    linkField.style.color = 'red';
    linkField.setAttribute('onclick',`deleteRow('${fieldbyid}',${counterRow});`);
    linkField.textContent = "Eliminar grupo";
    firstDivField.appendChild(inputField);
    firstDivField.appendChild(linkField);
    const secondDivField = document.createElement('div');
    secondDivField.className = "col";
    const buttonField = document.createElement('button');
    buttonField.id=`${fieldbyid}_addimg_${counterRow}`;
    buttonField.className="btn btn-success";
    buttonField.type = "button";
    buttonField.setAttribute('onclick',`addImage('${fieldbyid}',${counterRow});`);
    buttonField.textContent = "Agregar figura";
    /*Agrego a un array, para luego saber que rows se estan enviando.*/
    switch (fieldbyid) {
        case 'resultados':
            array_sendRow.push(counterRow);
            break;
        case 'anexos':
            array_sendRowA.push(counterRow);
            break;
        default:
            console.log("something's wrong");
            break;
    }

    /** */
    secondDivField.appendChild(buttonField);
    const thridDivField = document.createElement('div');
    thridDivField.id= `${fieldbyid}_listimg_${counterRow}`;
    thridDivField.className = "row my-3 d-flex";
    contenedorField.appendChild(firstDivField);
    contenedorField.appendChild(secondDivField);
    contenedorField.appendChild(thridDivField);
    if(contenedorRow.hidden) contenedorRow.hidden = false;
    contenedorRow.appendChild(contenedorField);

    document.getElementById(`${fieldbyid}_btn_addField`).hidden=false;
    document.getElementById(`${fieldbyid}_btn_addImage`).hidden=true;

    array_rowField[indexArray].counter ++;
    // newImagen(iTema,contadorGrupo[iTema]);
    // contadorGrupo[iTema] = contadorGrupo[iTema] + 1;

}

function deleteRow(fieldname,counterget){
    document.getElementById(`${fieldname}_rowImage_${counterget}`).remove();
    switch(fieldname){
        case 'resultados':
            array_sendRow = array_sendRow.filter((item)=>item!=counterget);
            break;
        case 'anexos':
            array_sendRowA = array_sendRowA.filter((item)=>item!=counterget);
            break;
        default:
            console.log("Something's wrong")
            break;
    }

    document.getElementById(`${fieldname}_btn_addField`).hidden=true;
    document.getElementById(`${fieldname}_btn_addImage`).hidden=false;

    const indexArray = array_taField.map(item => item.field).indexOf(fieldname);
    const counterRow = parseInt(array_taField[indexArray].counter,10);

    console.log(`comienza: ${counterget}; termina: ${counterRow}`);
    let intCounter = parseInt(counterget,10);
    if(counterRow < intCounter && counterRow>0){
        intCounter = counterRow-1;
    }
    for(let xcounter = intCounter; xcounter<counterRow;xcounter++){

        if(document.getElementById(`${fieldname}_text_${xcounter}`) !== null){
            document.getElementById(`${fieldname}_text_${xcounter}`).remove();
            break;
        }
    }

}

function addImage(fieldname, numberRow){
    let objImagen = {};
    let pos_elemento = array_imgRow.map(item => item.idrow).indexOf(numberRow);
    const numberImages = parseInt(document.getElementById(`${fieldname}_counterlocal_${numberRow}`).value.split('/')[0],10)+1;

    if(pos_elemento>=0){
        objImagen = array_imgRow[pos_elemento];
    }else{
        objImagen = {'idrow': numberRow,'field': fieldname,'counter':0};
        array_imgRow.push(objImagen);
        pos_elemento = 0;
    }
    const counterImgRow = array_imgRow[pos_elemento].counter;

    // fila = '<div class="m-2 d-flex" id="'+fieldname+'_img_'+counterImgRow+'">'+
    //             '<input class="form-control form-control-sm" type="file">'+
    //             '<button class="btn btn-warning" type="button" onclick="deleteImgRow(`'+fieldname+'`,'+counterImgRow+','+numberRow+');"><i class="bx bx-minus"></i>Eliminar</button>'+
    //         '</div>';
    const contenedorField = document.createElement('div');
    contenedorField.id = `${fieldname}_img_${counterImgRow}_${numberRow}`;
    contenedorField.className = "m-2 d-flex";
    const inputField = document.createElement('input');
    inputField.type = "file";
    inputField.className="form-control form-control-md";
    inputField.name = `${fieldname}_img_${numberRow}[]`;
    const buttonField = document.createElement('button');
    buttonField.className="btn btn-danger ms-2";
    buttonField.type="button";
    buttonField.textContent="Eliminar";
    buttonField.setAttribute('onclick',`deleteImgRow('${fieldname}',${counterImgRow},${numberRow});`);
    contenedorField.appendChild(inputField);
    contenedorField.appendChild(buttonField);

    console.log(counterImgRow);
    document.getElementById(`${fieldname}_listimg_${numberRow}`).appendChild(contenedorField);
    document.getElementById(`${fieldname}_counterlocal_${numberRow}`).value = `${numberImages}/5`;
    array_imgRow[pos_elemento].counter++;
    if(numberImages>=5) document.getElementById(`${fieldname}_addimg_${numberRow}`).disabled = true;
}

function deleteImgRow(fieldname,numberImgRow,counterRow){
    document.getElementById(`${fieldname}_img_${numberImgRow}_${counterRow}`).remove();
    const numberImages = parseInt(document.getElementById(`${fieldname}_counterlocal_${counterRow}`).value.split('/')[0],10) - 1;
    document.getElementById(`${fieldname}_counterlocal_${counterRow}`).value = `${numberImages}/5`;
    if(numberImages<=5) document.getElementById(`${fieldname}_addimg_${counterRow}`).disabled = false;
}

function addTextField(element){
    const fieldbyid = element.id.split('_')[0];
    const indexArray = array_taField.map(item => item.field).indexOf(fieldbyid);
    const counterRow = array_taField[indexArray].counter;
    const contenedorRow = document.getElementById(`${fieldbyid}_contenedor`);


    const contenedorField = document.createElement('div');
    contenedorField.className="col-12 col-md-10 my-2";
    contenedorField.id = `${fieldbyid}_text_${counterRow}`;
    const tareaField = document.createElement('textarea');
    tareaField.className="form-control";
    tareaField.name = `txt${fieldbyid}[]`;
    tareaField.id = `${fieldbyid}_textfield_${counterRow}`;
    const linkField = document.createElement('a');
    linkField.textContent = "Eliminar texto";
    linkField.style.color = "red";
    linkField.href = "#";
    linkField.id = `${fieldbyid}_deleteText_${counterRow}`;
    linkField.setAttribute('onclick',`deleteTextField('${fieldbyid}',${counterRow});`);
    contenedorField.appendChild(tareaField);
    contenedorField.appendChild(linkField);

    contenedorRow.appendChild(contenedorField);
    document.getElementById(`${fieldbyid}_btn_addField`).hidden=true;
    document.getElementById(`${fieldbyid}_btn_addImage`).hidden=false;
    array_taField[indexArray].counter++;
}

function deleteTextField(fieldname,counterRow){
    document.getElementById(`${fieldname}_text_${counterRow}`).remove();
    document.getElementById(`${fieldname}_btn_addField`).hidden=false;
    document.getElementById(`${fieldname}_btn_addImage`).hidden=true;
}

/* Para eliminar los antiguos datos. [objetivos, referencias]
 Tal vez luego se implemente para las imagenes de resultados y anexos*/
function deleteOldData(item){
    const iditem = item.id;
    const idindice = iditem.split("-");
    let code = document.getElementById('x'+iditem).value;
    if(document.getElementById('listOld'+idindice[0]).value == ""){
        document.getElementById('listOld'+idindice[0]).value = code;
    }else{
        document.getElementById('listOld'+idindice[0]).value += ","+code;
    }
    if(idindice[0]=='lobj'){
        document.getElementById('filaO'+idindice[1]).remove();
    }else if(idindice[0]=='lref'){
        document.getElementById('filaRe'+idindice[1]).remove();
    }
}
