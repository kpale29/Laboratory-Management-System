
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `admin` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `admin` (`usuario`, `password`) VALUES
('admin', 'admin123');

CREATE TABLE `doctor` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `especialidad` varchar(50) NOT NULL,
  `honorarios` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `paciente` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `pnombre` varchar(20) NOT NULL,
  `papellido` varchar(20) NOT NULL,
  `genero` varchar(10) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `password` varchar(30) NOT NULL,
  `cpassword` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


create TABLE `examen`(
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `examen` varchar(50) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `cita` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `id_paciente` int(11) NOT NULL,
  `id_doctor` int(11) NOT NULL,
  `id_examen` int(1) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `userStatus` int(5) NOT NULL,
  `doctorStatus` int(5) NOT NULL,
  FOREIGN KEY (id_paciente) REFERENCES paciente(id),
  FOREIGN KEY (id_doctor) REFERENCES doctor(id),
  FOREIGN KEY (id_examen) REFERENCES examen(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `resultado` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `id_cita` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `path_resultado` varchar(250) NOT NULL,
  `comentario` varchar(1000) NOT NULL,
  FOREIGN KEY (id_cita) REFERENCES cita(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

COMMIT;