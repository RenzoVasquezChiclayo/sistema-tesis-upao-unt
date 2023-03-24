/*Arreglos*/
let obj_keyword = [];

let obj_resultadosImg = [];
let obj_resultadosTxt = [];
let obj_anexosImg = [];
let obj_anexosTxt = [];

let array_rowField = [{'field':'resultados','counter':0},{'field':'anexos','counter':0}]; // Contiene el contador de rows de cada campo que lleva imagenes.
let array_taField = [{'field':'resultados','counter':0},{'field':'anexos','counter':0}]; // Contiene el contador de textarea.
let array_imgRow = []; // Contiene el contador de imagenes de cada row. // {'idrow': 0,'field': 'resultados','counter':0}

/*Recibido de la base de datos*/
const get_keyword = document.getElementById('get_keyword').value;
const get_resultadosImg = document.getElementById('resultados_getImg').value;
const get_resultadosTxt = document.getElementById('resultados_getTxt').value;
const get_anexosImg = document.getElementById('anexos_getImg').value;
const get_anexosTxt = document.getElementById('anexos_getTxt').value;

const cod_matricula = document.getElementById('txtCodMatricula').value; // Codigo de matricula del alumno

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

/*Inicializar las imagenes que estan en bd.*/
function initImageTxt(fieldname,containText){
    let actualGroup = -1;
    let contadorGrupo = 0;
    let obj_initImg = (fieldname == "resultados") ? obj_resultadosImg : obj_anexosImg;
    let obj_initTxt = (fieldname == "resultados") ? obj_resultadosTxt : obj_anexosTxt;

    if(containText){
        document.getElementById(`ta${fieldname}`).value = obj_initTxt[0];
    }

    for(let i=0; i<obj_initImg.length;i++){
        // Imprime imagen
        if(contadorGrupo >= 5){
            document.getElementById(`${fieldname}_addimg_${actualGroup}`).disabled = true;
        }
        if(actualGroup != obj_initImg[i].grupo){
            // if(actualGroup >= 0){
            //     document.getElementById(`${fieldname}_counterlocal_${actualGroup}`).value = `${contadorGrupo}/5`;
            //     contadorGrupo = 0;
            // }
            actualGroup = obj_initImg[i].grupo;
            addRowImage(fieldname); // Creamos los contenedores de las imagenes

            if(actualGroup+1 < obj_initTxt.length){
                // Imprime el texto
                const indexArray = array_taField.map(item => item.field).indexOf(fieldname);
                const counterRow = array_taField[indexArray].counter;
                addTextField(fieldname); // Creamos los textareas
                document.getElementById(`${fieldname}_textfield_${counterRow}`).value = obj_initTxt[actualGroup+1];
            }
        }
        contadorGrupo ++;  //Aumenta el numero de img que existen en el grupo
        const imageField = document.createElement('img');
        imageField.style.width = "200px";
        imageField.style.height = "200px";
        imageField.src = `./cursoTesis-2022/img/${cod_matricula}-Tesis/${fieldname}/${obj_initImg[i].ruta}`;
        document.getElementById(`${fieldname}_listimg_${obj_initImg[i].grupo}`).appendChild(imageField);

        // if(i >= obj_initImg.length-1){
        //     document.getElementById(`${fieldname}_counterlocal_${actualGroup}`).value = `${contadorGrupo}/5`;
        //     contadorGrupo = 0;
        // }
    }
}

/*Recibir los datos de imagenes en formato JSON y asignarle a un array de objetos.*/
function JSONtoArrayImage(v_json){
    let array_objetos = [];
    let jsonParse = JSON.parse(v_json);
    jsonParse.forEach((item)=>{
        let objeto = {id:item.id, tipo:item.tipo, grupo:item.grupo, ruta:item.ruta};
        array_objetos.push(objeto)
    });
    return array_objetos;
}

/*Recibir los datos de keyword en formato JSON y asignarle a un array de objetos.*/
function JSONtoArray(v_json){
    let array_objetos = [];
    let jsonParse = JSON.parse(v_json);
    jsonParse.forEach((item)=>{
        let objeto = {id:item.id_detalle_keyword,keyword:item.keyword};
        array_objetos.push(objeto)
    });
    return array_objetos;
}

/*Dibujar los chips en caso existan keywords guardados*/
function drawChipsKeyword(){
    obj_keyword.forEach((item)=>{
        const fila ='<div id="getchip_'+item.id+'" class="col-6 col-sm-3 chip">'+
                            '<div><strong>'+item.keyword+'</strong></div>'+
                    '</div>';
        document.getElementById('chips').innerHTML += fila;
    });
}

/*Agregar estructura de la lista de imagenes*/
function addRowImage(fieldname){

    /*Buscar dentro del arreglo que lleva el contador*/
    const indexArray = array_rowField.map(item => item.field).indexOf(fieldname);
    const counterRow = array_rowField[indexArray].counter;
    const contenedorRow = document.getElementById(`${fieldname}_contenedor`);

    /*Creamos el row para las imagenes*/
    const contenedorField = document.createElement('div');
    contenedorField.id = `${fieldname}_rowImage_${counterRow}`;
    contenedorField.className= "row";
    // const firstDivField = document.createElement('div');
    // firstDivField.className = "my-2 d-flex";
    /*Input donde ira el contador de imagenes*/
    // const inputField = document.createElement('input');
    // inputField.className="form-control input-counter text-center me-3";
    // inputField.id=`${fieldname}_counterlocal_${counterRow}`;
    // inputField.readOnly = true;
    // inputField.value = "0/0";
    // firstDivField.appendChild(inputField);

    const secondDivField = document.createElement('div');
    secondDivField.id= `${fieldname}_listimg_${counterRow}`;
    secondDivField.className = "row my-3 d-flex";
    // contenedorField.appendChild(firstDivField);
    contenedorField.appendChild(secondDivField);
    if(contenedorRow.hidden) contenedorRow.hidden = false;
    contenedorRow.appendChild(contenedorField);

    array_rowField[indexArray].counter ++;
}


/*Agregar campos textarea para los textos*/
function addTextField(fieldname){
    const indexArray = array_taField.map(item => item.field).indexOf(fieldname);
    const counterRow = array_taField[indexArray].counter;
    const contenedorRow = document.getElementById(`${fieldname}_contenedor`);

    const contenedorField = document.createElement('div');
    contenedorField.className="col-12 col-md-10 my-2";
    contenedorField.id = `${fieldname}_text_${counterRow}`;
    const tareaField = document.createElement('textarea');
    tareaField.className="form-control";
    tareaField.name = `txt${fieldname}[]`;
    tareaField.id = `${fieldname}_textfield_${counterRow}`;
    tareaField.readOnly = true;
    contenedorField.appendChild(tareaField);

    contenedorRow.appendChild(contenedorField);
    array_taField[indexArray].counter++;
}
