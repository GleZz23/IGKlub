drop database if exists igklub_database;
create database igklub_database default character set utf8mb4 default collate utf8mb4_general_ci;
use igklub_database;

-- TABLA CENTRO
create table if not exists centro(
  id_centro int(5) auto_increment primary key,
  nombre varchar(255) not null
);

-- TABLA USUARIO
create table if not exists usuario (
  nickname varchar(255) primary key,
  nombre varchar(255) not null,
  apellidos varchar(255) not null,
  fecha_nacimiento date,
  email varchar(255) not null,
  telefono int(9),
  contrasena varchar(255) not null,
  rol enum('admin', 'irakasle', 'ikasle') not null,
  id_centro int(5),
  cod_grupo char(5),
  imagen varchar(255),
  estado enum('aceptado','denegado','espera') default 'espera' not null,
  foreign key (id_centro) references centro(id_centro) on delete cascade
);

-- TABLA GRUPO
create table if not exists grupo (
  codigo char(5) primary key,
  nombre varchar(20) not null,
  id_centro int(5),
  nivel varchar(10),
  curso varchar(10),
  profesor varchar(255),
  foreign key (profesor) references usuario(nickname) on delete cascade,
  foreign key (id_centro) references centro(id_centro) on delete cascade
);
Alter TABLE usuario add foreign key (cod_grupo) references grupo(codigo) on delete cascade;

-- TABLA LIBRO
create table if not exists libro (
  id_libro int(5) auto_increment primary key,
  titulo varchar(255) not null,
  escritor varchar(255) not null,
  sinopsis varchar(2300),
  formato enum('Nobela','Komikia','Nobela grafikoa','Manga') not null,
  etiqueta varchar(255),
  portada varchar(255),
  edad_media int(2) unsigned default 0,
  num_lectores int unsigned default 0,
  nota_media int(1) unsigned default 0
);

-- TABLA COMENTARIO
create table if not exists comentario (
  id_comentario int(5) auto_increment primary key,
  nickname varchar(255),
  id_libro int(5),
  mensaje varchar(2300) not null,
  fecha datetime,
  estado enum('aceptado','denegado','espera') default 'espera' not null,
  foreign key (nickname) references usuario(nickname) on delete cascade,
  foreign key (id_libro) references libro(id_libro) on delete cascade
);

-- TABLA IDIOMA
create table if not exists idioma (
  id_idioma int(5) auto_increment primary key,
  nombre varchar(255)
);

-- TABLA VALORACION
create table if not exists valoracion (
  id_valoracion int(5) auto_increment primary key,
  nickname varchar(255),
  nota int unsigned not null,
  edad int(2) unsigned not null,
  idioma int(5),
  id_comentario int(5),
  id_libro int(5),
  fecha datetime,
  estado enum('aceptado','denegado','espera') default 'espera' not null,
  foreign key (nickname) references usuario(nickname) on delete cascade,
  foreign key (id_comentario) references comentario(id_comentario) on delete cascade,
  foreign key (idioma) references idioma(id_idioma) on delete cascade
);

-- TABLA SOLICITUD LIBRO
create table if not exists solicitud_libro (
  nickname varchar(255),
  id_libro int(5),
  estado enum('aceptado','denegado','espera') default 'espera' not null,
  foreign key (id_libro) references libro(id_libro) on delete cascade,
  foreign key (nickname) references usuario(nickname) on delete cascade
);

-- TABLA SOLICITUD IDIOMA
create table if not exists solicitud_idioma (
  nickname varchar(255),
  idioma varchar(255),
  id_libro int(5),
  titulo varchar(255) not null,
  estado enum('aceptado','denegado','espera') default 'espera' not null,
  foreign key (nickname) references usuario(nickname) on delete cascade,
  foreign key (id_libro) references libro(id_libro) on delete cascade
);

-- TABLA IDIOMA LIBRO
create table if not exists idioma_libro (
  libro int(5),
  idioma int(5),
  titulo varchar(255) not null,
  foreign key (libro) references libro(id_libro) on delete cascade,
  foreign key (idioma) references idioma(id_idioma) on delete cascade
);

-- TABLA RESPUESTA
create table if not exists respuesta (
  id_comentario int(5),
  id_respuesta int(5) auto_increment primary key,
  nickname varchar(255),
  id_libro int(5),
  mensaje varchar(2300) not null,
  fecha datetime,
  estado enum('aceptado','denegado','espera') default 'espera' not null,
  foreign key (nickname) references usuario(nickname) on delete cascade,
  foreign key (id_libro) references libro(id_libro) on delete cascade,
  foreign key (id_comentario) references comentario(id_comentario) on delete cascade
);

-- CENTROS
INSERT INTO centro VALUES
  ('1', 'I.E.S. Miguel de Unamuno B.H.I.'),
  ('2', 'CIFP Txurdinaga LHII');

-- USUARIO
INSERT INTO usuario (`nickname`, `nombre`, `apellidos`, `fecha_nacimiento`, `email`, `telefono`, `contrasena`, `rol`, `id_centro`, `cod_grupo`, `estado`, `imagen`) VALUES
  ('Admin', 'Administrador', 'de Prueba', '2000-01-01', 'admin@mail.com', NULL, '$2y$10$SZU5HY0RmiNkvpl7rOoPkeERGKXk0bTNZJoBDTAdzR.VYYEHuZx8q', 'admin', NULL, NULL, 'aceptado', 'Admin.png'),
  ('Admin2', 'Administrador', 'de Prueba Segundo', '2000-01-01', 'admin2@mail.com', NULL, '$2y$10$SZU5HY0RmiNkvpl7rOoPkeERGKXk0bTNZJoBDTAdzR.VYYEHuZx8q', 'admin', NULL, NULL, 'aceptado', 'Admin.png'),
  ('Profesor', 'Profesor', 'de Prueba', '2000-01-01', 'profesor@mail.com', 911111111, '$2y$10$SZU5HY0RmiNkvpl7rOoPkeERGKXk0bTNZJoBDTAdzR.VYYEHuZx8q', 'irakasle', 2, NULL, 'espera', 'Profesor.png'),
  ('Alumno', 'Alumno', 'de Prueba', '2000-01-01', 'alumno@mail.com', NULL, '$2y$10$SZU5HY0RmiNkvpl7rOoPkeERGKXk0bTNZJoBDTAdzR.VYYEHuZx8q', 'ikasle', 2, NULL, 'espera', NULL);

-- LIBROS
INSERT INTO libro (titulo, escritor, portada) VALUES 
  ('Malaherba', 'Manuel Jabois', '1.jpg'),
  ('Las L??grimas de Shiva', 'C??sar Mallorqu?? del Corral', '2.jpg'),
  ('Harry Potter', 'J.K. Rowling', '3.jpg'),
  ('Los Futbolisimos', 'Roberto Santiago', '4.jpg'),
  ('Cruzada en Jeans', 'Thea Beckman', '5.jpg'),
  ('My Hero Academia', 'Kohei Horikoshi', '6.jpg'),
  ('Charlie y La F??brica De Chocolate', 'Roald Dahl', '7.jpg'),
  ('Diario de Anne Frank', 'Anne Frank', '8.jpg'),
  ('El Hobbit', 'J.R.R. Tolkien', '9.jpg');

UPDATE `libro` SET `sinopsis` = '??La primera vez que pap?? muri?? todos pensamos que estaba fingiendo.?? <br> As?? empieza Malaherba de Manuel Jabois. Un d??a Mr. Tamburino, Tambu, un ni??o de diez a??os, se encuentra a su padre tirado en la habitaci??n y conoce a Elvis, un nuevo compa??ero de su clase. Descubrir?? por primera vez el amor y la muerte, pero no de la forma que ??l cree. Y los dos, Tambu y Elvis, vivir??n juntos los ??ltimos d??as de la ni??ez, esos en los que a??n pasan cosas que no se pueden explicar y sentimientos a los que todav??a no se sabe poner nombre. <br> Esta es una historia de dos ni??os que viven una extra??a y solitaria historia de amor. Un libro sobre las cosas terribles que se hacen con cari??o, escrito con humor y una prosa r??pida que avanza llevando a Tambu y su hermana Rebe, a Claudia y su hermano Elvis, a la frontera de un mundo nuevo. <br> ??Bien sabe Dios que es m??s peligrosa la pena que el odio, porque el odio puede destruir lo que odias, pero la pena lo destruye todo.??' WHERE `libro`.`id_libro` = 1;
UPDATE `libro` SET `sinopsis` = 'En cierta ocasi??n, hace ya mucho tiempo, vi un fantasma. S??, un espectro, una aparici??n, un esp??ritu; lo puedes llamar como quieras, el caso es que lo vi. Ocurri?? el mismo a??o en que el hombre lleg?? a la Luna y, aunque hubo momentos en los que pas?? mucho miedo, esta historia no es lo que suele llamarse una novela de terror. --Todo comenz?? con un enigma: el misterio de un objeto muy valioso que estuvo perdido durante siete d??cadas. Las L??grimas de Shiva, as?? se llamaba ese objeto extraviado. A su alrededor tuvieron lugar venganzas cruzadas, y amores prohibidos, y extra??as desapariciones.--Hubo un fantasma, s??, y un viejo secreto oculto en las sombras, pero tambi??n hubo mucho m??s.' WHERE `libro`.`id_libro` = 2;
UPDATE `libro` SET `sinopsis` = '??Con las manos temblorosas, Harry le dio la vuelta al sobre y vio un sello de lacre p??rpura con un escudo de armas: un le??n, un ??guila, un tej??n y una serpiente, que rodeaban una gran letra H.?? <br> Harry Potter nunca ha o??do hablar de Hogwarts hasta que empiezan a caer cartas en el felpudo del n??mero 4 de Privet Drive. Llevan la direcci??n escrita con tinta verde en un sobre de pergamino amarillento con un sello de lacre p??rpura, y sus horripilantes t??os se apresuran a confiscarlas. M??s tarde, el d??a que Harry cumple once a??os, Rubeus Hagrid, un hombre gigantesco cuyos ojos brillan como escarabajos negros, irrumpe con una noticia extraordinaria: Harry Potter es un mago, y le han concedido una plaza en el Colegio Hogwarts de Magia y Hechicer??a. ??Est?? a punto de comenzar una aventura incre??ble!' WHERE `libro`.`id_libro` = 3;
UPDATE `libro` SET `sinopsis` = 'El equipo de f??tbol 7 Soto Alto no es solo el equipo de f??tbol del colegio. Es mucho m??s. Nosotros hemos hecho un pacto: nada ni nadie nos separar?? nunca. Siempre jugaremos juntos. Pase lo que pase. As?? que cuando pas?? lo que pas?? no tuvimos m??s remedio que actuar. Preparamos nuestro material de investigadores... y nos lanzamos a la aventura. Por algo somos los Futbol??simos.' WHERE `libro`.`id_libro` = 4;
UPDATE `libro` SET `sinopsis` = 'Una emocionante novela de aventuras ambientada en la Edad Media. Imagina que la m??quina del tiempo en la que viajas te transporta a un lugar que no deseas.Y que cuando est??s a punto de conseguir volver a casa, una cruzada de ni??os se interpone en tu camino. Es exactamente lo que le sucede a Rudolf Hefting. Perdido en una ??poca que no es la suya, no le queda m??s remedio que unirse a la expedici??n. En vaqueros, por supuesto. ' WHERE `libro`.`id_libro` = 5;
UPDATE `libro` SET `sinopsis` = 'Estamos en un mundo donde abundan los superh??roes (y los supervillanos). Los mejores humanos son entrenados en la Academia de H??roes para optimizar sus poderes. <br> Entre la minor??a normal, sin poder alguno, aparece Izuku Midoriya, dispuesto a ser una excepci??n y formarse en la Academia.' WHERE `libro`.`id_libro` = 6;
UPDATE `libro` SET `sinopsis` = 'Charlie y la f??brica de chocolate es una historia de Roald Dahl, el gran autor de literatura infantil. El se??or Wonka, due??o de la magn??fica f??brica de chocolate, ha escondido cinco billetes de oro en sus chocolatinas. Quienes los encuentren ser??n los elegidos para visitar la f??brica. Charlie tiene la fortuna de encontrar uno de esos billetes y, a partir de ese momento, su vida cambiar?? para siempre.' WHERE `libro`.`id_libro` = 7;
UPDATE `libro` SET `sinopsis` = 'Tras la invasi??n de Holanda, los Frank, comerciantes jud??os alemanes emigrados a Amsterdam en 1933, se ocultaron de la Gestapo en una buhardilla anexa al edificio donde el padre de Anne ten??a sus oficinas. Ocho personas permanecieron recluidas desde junio de 1942 hasta agosto de 1944, fecha en que fueron detenidas y enviadas a campos de concentraci??n. Desde su escondite y en las m??s precarias condiciones, Anne, una ni??a de trece a??os, escribi?? su estremecedor Diario: un testimonio ??nico en su g??nero sobre el horror y la barbarie nazi, y sobre los sentimientos y experiencias de la propia Anne y sus acompa??antes. Anne muri?? en el campo de Bergen-Belsen en marzo de 1945. Su Diario nunca morir??.' WHERE `libro`.`id_libro` = 8;
UPDATE `libro` SET `sinopsis` = 'Smaug parec??a profundamente dormido cuando Bilbo espi?? una vez m??s desde la entrada. ??Pero fing??a! ??Estaba vigilando la entrada del t??nel!... Sacado de su c??modo agujero-hobbit por Gandalf y una banda de enanos, Bilbo se encuentra de pronto en medio de una conspiraci??n que pretende apoderarse del tesoro de Smaug el Magn??fico, un enorme y muy peligroso drag??n...' WHERE `libro`.`id_libro` = 9;

INSERT INTO solicitud_libro (nickname, id_libro, estado) VALUES
  (NULL, 1, 'aceptado'),
  (NULL, 2, 'aceptado'),
  (NULL, 3, 'aceptado'),
  (NULL, 4, 'aceptado'),
  (NULL, 5, 'aceptado'),
  (NULL, 6, 'espera'),
  (NULL, 7, 'espera'),
  (NULL, 8, 'espera'),
  ('Alumno', 9, 'espera');

-- IDIOMAS
INSERT INTO `idioma`(`nombre`) VALUES
  ('Gaztelania'),
  ('Euskera'),
  ('Ingelesa'),
  ('Frantsesa'),
  ('Aleman'),
  ('Ukrainera'),
  ('Errumaniera'),
  ('Txinera');

-- BORRAR DATOS DE ALUMNOS
DROP EVENT IF EXISTS `delete_user`;
CREATE DEFINER=`root`@`localhost` EVENT `desactivate_user`
ON SCHEDULE EVERY 1 YEAR STARTS '2023-06-25 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO
UPDATE usuario SET id_centro = NULL, cod_grupo = NULL WHERE rol = 'ikasle';

-- USUARIO PARA LA BBDD
create user 'igklub'@'%' identified by '655Yj6Rc$F@x';
grant all on igklub_database.* to 'igklub'@'%';