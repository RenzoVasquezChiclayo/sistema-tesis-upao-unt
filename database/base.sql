/* Creacion de la base de datos */

drop database if exists ;
create database dbSistemaContabilidad;
use dbSistemaContabilidad;

/* Creacion de la tabla Usuarios */
create table usuario(
    username        char(10),
    contra          varchar(50),
    rol             varchar(25),
    primary key(username)
);

/* Creacion de la tabla Sede */
create table sede(
    cod_sede        char(02),
    nombre          varchar(25),
    primary key(cod_sede)
);

/* Creacion de la tabla Facultades */
create table facultad(
    cod_facultad    char(04),
    nombre          varchar(60),
    primary key(cod_facultad)
);

/* Creacion de la tabla Escuela */
create table escuela(
    cod_escuela     char(04),
    nombre          varchar(40),
    cod_facultad    char(04),
    primary key(cod_escuela),
    foreign key(cod_facultad) references facultad(cod_facultad)
);


/* Creacion de la tabla TipoInvestigacion */

create table tipoinvestigacion(
    cod_tinvestigacion  char(04),
    descripcion         varchar(15),
    cod_escuela         char(04),
    primary key(cod_tinvestigacion),
    foreign key(cod_escuela) references escuela(cod_escuela)
);

create table subtipo_investigacion(
    cod_subtipo         int auto_increment,
    sublinea            varchar(40),
    sub_sublinea        varchar(40),
    cod_tinvestigacion  char(04),
    primary key(cod_subtipo),
    foreign key(cod_tinvestigacion) references tipoinvestigacion(cod_tinvestigacion)
);




/* Creacion de la tabla Asesor */
create table asesor(
    cod_docente         char(04),
    nombres             varchar(50),
    grado_academico     varchar(30),
    titulo_profesional  varchar(30),
    direccion           varchar(30),
    primary key(cod_docente)
);

/* Creacion de la tabla Egresado */
create table egresado(
    cod_matricula       char(10),
    dni                 varchar(08),
    apellidos           varchar(30),
    nombres             varchar(30),
    primary key(cod_matricula)
);

/* Creacion de la tabla Formato del titulo profesional */
/*Cambiar el cod_formato*/
create table formato_titulo(
    codigo              int auto_increment,
    cod_formato         char(04),

    cod_matricula       char(10),
    tit_profesional     varchar(60),
    fecha_nacimiento    date,
    direccion           varchar(70),
    tele_fijo           char(8),
    tele_celular        varchar(12),
    correo              varchar(50),
    modalidad_titulo    varchar(30),
    sgda_especialidad   varchar(50),
    prog_extraordinario varchar(50),
    fecha_sustentacion  date,
    fecha_colacion      date,
    centro_labores      varchar(25),
    colegio             varchar(50),
    tipo_colegio        varchar(15),
    cod_escuela         char(04),
    cod_sede            char(02),
    estado              tinyint,
    fecha               date,

    cod_tinvestigacion  char(04),
    cod_docente         char(04),
    primary key(codigo),
    foreign key(cod_matricula) references egresado(cod_matricula),
    foreign key(cod_escuela) references escuela(cod_escuela),
    foreign key(cod_sede) references sede(cod_sede),
    foreign key(cod_tinvestigacion) references tipoinvestigacion(cod_tinvestigacion),
    foreign key(cod_docente) references asesor(cod_docente)
);

/* Creacion de la tabla Proyecto Investigacion */
create table proyInvestigacion(
    cod_proyinvestigacion   int auto_increment,

    titulo              text,
    /* Egresado */
    cod_matricula       char(10),
    nombres             varchar(60),

    /*Formato de titulo*/
    direccion           varchar(70),
    escuela             varchar(40),

    /* Asesor */
    nombre_asesor       varchar(50),
    grado_asesor        varchar(30),
    titulo_asesor       varchar(30),
    direccion_asesor    varchar(30),

    cod_tinvestigacion  char(04),
    ti_finpersigue      varchar(15),
    ti_disinvestigacion varchar(15),
    localidad           varchar(30),
    institucion         varchar(30),
    meses_ejecucion     int,

    /* Diagrama de gantt */
    t_ReparacionInstrum varchar(30),
    t_RecoleccionDatos  varchar(30),
    t_AnalisisDatos     varchar(30),
    t_ElaboracionInfo   varchar(30),
    /* -------------- */

    financiamiento      text,

    real_problematica   text,
    antecedentes        text,
    justificacion       text,
    formulacion_prob    text,

    marco_teorico       text,
    marco_conceptual    text,
    marco_legal         text,
    form_hipotesis      text,

    objeto_estudio      text,
    poblacion           text,
    muestra             text,
    metodos             text,

    /* PDF*/
    tecnicas_instrum    text,
    instrumentacion     text,
    /* -------------- */
    estg_metodologicas   text,
    primary key(cod_proyinvestigacion)
);

create table presupuesto(
    cod_presupuesto         int auto_increment,
    codeUniversal           varchar(15),
    denominacion            varchar(50),
    primary key(cod_presupuesto)
);

create table presupuesto_proyecto(
    cod_presProyecto        int auto_increment,
    precio                  float,
    cod_presupuesto         int,
    cod_proyinvestigacion   int,
    primary key(cod_presProyecto),
    foreign key(cod_presupuesto) references presupuesto(cod_presupuesto),
    foreign key(cod_proyinvestigacion) references proyInvestigacion(cod_proyinvestigacion)

);


create table objetivo(
    cod_objetivo            int auto_increment,
    tipo                    varchar(25),
    descripcion             text,
    cod_proyinvestigacion   int,
    primary key(cod_objetivo),
    foreign key(cod_proyinvestigacion) references proyInvestigacion(cod_proyinvestigacion)
);

create table variableOP(
    cod_variable            int auto_increment,
    descripcion             varchar(80),
    cod_proyinvestigacion   int,
    primary key(cod_variable),
    foreign key(cod_proyinvestigacion) references proyInvestigacion(cod_proyinvestigacion)
);

create table recursos(
    cod_recurso             int auto_increment,
    tipo                    varchar(40) not null,
    subtipo                 varchar(25),
    descripcion             varchar(80),
    cod_proyinvestigacion   int,
    primary key(cod_recurso),
    foreign key(cod_proyinvestigacion) references proyInvestigacion(cod_proyinvestigacion)
);

create table tiporeferencia(
    cod_tiporeferencia  int auto_increment,
    tipo                varchar(30),
    primary key(cod_tiporeferencia)
);

create table referencias(
    cod_referencias     int auto_increment,
    cod_tiporeferencia      int,

    /*Aqui ira todo lo relacionado a normas APA*/
    autor               text,
    fPublicacion        varchar(30),
    titulo              varchar(60),
    fuente              varchar(60),

    /*Libro*/
    editorial           varchar(25),
    title_cap           varchar(25),
    num_capitulo        varchar(20),
    /*Revista*/
    title_revista       varchar(25),
    volumen             varchar(20),
    /*Pagina Web*/
    name_web            varchar(25),
    /*Articulo*/
    name_periodista     varchar(25),
    /*Tesis*/
    name_institucion    varchar(25),
    /*Informe-Reporte*/
    subtitle            varchar(25),
    name_editor         varchar(25),

    cod_proyinvestigacion   int,
    primary key(cod_referencias),
    foreign key(cod_tiporeferencia) references tiporeferencia(cod_tiporeferencia),
    foreign key(cod_proyinvestigacion) references proyInvestigacion(cod_proyinvestigacion)
);


create table img_egresado(
    cod_img             int auto_increment,
    referencia          varchar(40),
    cod_matricula        char(10),
    primary key(cod_img),
    foreign key(cod_matricula) references egresado(cod_matricula)
);

insert into facultad values('0001','CIENCIAS ECONOMICAS');
insert into sede values('01','TRUJILLO'),('02','VALLE'),('03','HUAMACHUCO');
insert into escuela values('0001','CONTABILIDAD Y FINANZAS','0001'),('0002','ADMINISTRACION','0001'),('0003','ECONOMICA','0001');


-- insert into egresado values('1013300719','73273542','Vasquez Chiclayo','Renzo','Contado Publico',now(),'bernardo ohiggins 1888','0445345','+51936759308','renzo@gmail.com','Modalidad',now(),now(),'SysConta','GUE','Particular','0001','01');
insert into egresado(cod_matricula,dni,apellidos,nombres) values('1013300719','73273542','Vasquez Chiclayo','Renzo');

insert into asesor values('3245','Luis Boy Chavil','Doctor','Ingenieriero en Sistemas','Los Olivos 430'),
('2641','NELSON OCTAVIO RUIZ CERDAN','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),('2841','DOMINGO ESTUARDO OLIVER LINARES','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),
('3387','SANTIAGO NESTOR BOCANEGRA OSORIO','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),('1179','AUGUSTO RICARDO MORENO RODRIGUEZ','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),
('4113','ROSA AMABLE SALCEDO DAVALOS','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),('2149','ANTONIO CHOLAN CALDERON','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),
('4532','CRISTIAN AUSBERTO PARIMANGO REBAZA','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),('4609','WINSTON ROLANDO REAÑO PORTAL','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),
('4028','JAIME GILBERTO MONTENEGRO RIOS','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),('5766','JUAN CARLOS MIRANDA ROBLES','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),
('5582','YONI MATEO VALIENTE SALDAÑA','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),('5714','CESAR AUGUSTO HERRERA ASMAT','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),
('5437','JORGE EDWIN MANTILLA SEVILLANO','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),('4993','JAVIER LEOPOLDO ULLOA SICCHA','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),
('5581','RAFAEL EDUARDO PAREDES TEJADA','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),('5909','ALFREDO RUBEN SAAVEDRA RODRIGUEZ','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),
('5107','ANA MARIA CUADRA MIDZUARAY','NOMBRADO','Ingenieriero en Sistemas','Los Olivos 430'),('6489','JUAN URQUIZO CUELLAR','CONTRATADO','Ingenieriero en Sistemas','Los Olivos 430'),
('5125','ROLANDO DE LA CRUZ ASMAT','CONTRATADO','Ingenieriero en Sistemas','Los Olivos 430'),('5127','SARA ISABEL CABANILLAS ÑAÑO','CONTRATADO','Ingenieriero en Sistemas','Los Olivos 430'),
('6430','RUBY MARILU LUJAN CHINININ','CONTRATADO','Ingenieriero en Sistemas','Los Olivos 430'),('5132','MAURO CESAR ARMAS AGUILAR','CONTRATADO','Ingenieriero en Sistemas','Los Olivos 430');

insert into tiporeferencia(tipo) values('Libro'),('Revista'),('Pagina web'),('Articulo en un periodico'),('Tesis o disertaciones'),('Informes/Reportes');

insert into tipoinvestigacion values('0001','CONTABILIDAD','0001'),('0002','FINANZAS','0001');
-- insert into subtipo_investigacion(sublinea,sub_sublinea,cod_tinvestigacion) values ()
insert into presupuesto(codeUniversal,denominacion) values('2.3.1.5.1','De oficina'),('2.3.1.9.1','Materiales y utiles de enseñanza'),('2.3.2.1.2','Viaje Domestico'),('2.3.2.2.1','Servicios De Energia Electrica, Agua y Gas'),('2.3.2.2.2','Servicios De Telefonia e Internet');

insert into usuario values('1013300719','admin','estudiante'),('jmiranda','password','director');
