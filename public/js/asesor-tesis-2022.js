/*Arreglos*/
let obj_keyword = [];

/*Recibido de la base de datos*/
const get_keyword = document.getElementById('get_keyword').value;
// const get_resultadosImg = document.getElementById('resultados_getImg').value;
// const get_resultadosTxt = document.getElementById('resultados_getTxt').value;
// const get_anexosImg = document.getElementById('anexos_getImg').value;
// const get_anexosTxt = document.getElementById('anexos_getTxt').value;

/*Dibujar los keywords al inicio*/
if(get_keyword != ""){
    obj_keyword = JSONtoArray(get_keyword);
    drawChipsKeyword();
}

/*Recibir los datos de keyword en formato JSON y asignarle a un array de objetos.*/
function JSONtoArray(v_json){
    let array_objetos = [];
    let jsonParse = JSON.parse(v_json);
    jsonParse.forEach((item)=>{
        let objeto = {id:item.id_detalle_keyword,keyword:item.keyword};
        array_objetos.push(objeto)
    });
    console.log(array_objetos);
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
