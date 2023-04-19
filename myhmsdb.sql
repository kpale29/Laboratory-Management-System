
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


-- INSERT INTO `doctor` (`username`, `password`, `email`, `spec`, `docFees`) VALUES
-- ('ashok', 'ashok123', 'ashok@gmail.com', 'General', 500),
-- ('arun', 'arun123', 'arun@gmail.com', 'Cardiologist', 600),
-- ('Dinesh', 'dinesh123', 'dinesh@gmail.com', 'General', 700),
-- ('Ganesh', 'ganesh123', 'ganesh@gmail.com', 'Pediatrician', 550),
-- ('Kumar', 'kumar123', 'kumar@gmail.com', 'Pediatrician', 800),
-- ('Amit', 'amit123', 'amit@gmail.com', 'Cardiologist', 1000),
-- ('Abbis', 'abbis123', 'abbis@gmail.com', 'Neurologist', 1500),
-- ('Tiwary', 'tiwary123', 'tiwary@gmail.com', 'Pediatrician', 450);

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

-- INSERT INTO `paciente` (`fname`, `lname`, `gender`, `email`, `contact`, `password`, `cpassword`) VALUES
-- ('Ram', 'Kumar', 'Male', 'ram@gmail.com', '9876543210', 'ram123', 'ram123'),
-- ('Alia', 'Bhatt', 'Female', 'alia@gmail.com', '8976897689', 'alia123', 'alia123'),
-- ('Shahrukh', 'khan', 'Male', 'shahrukh@gmail.com', '8976898463', 'shahrukh123', 'shahrukh123'),
-- ('Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'kishan123', 'kishan123'),
-- ('Gautam', 'Shankararam', 'Male', 'gautam@gmail.com', '9070897653', 'gautam123', 'gautam123'),
-- ('Sushant', 'Singh', 'Male', 'sushant@gmail.com', '9059986865', 'sushant123', 'sushant123'),
-- ('Nancy', 'Deborah', 'Female', 'nancy@gmail.com', '9128972454', 'nancy123', 'nancy123'),
-- ('Kenny', 'Sebastian', 'Male', 'kenny@gmail.com', '9809879868', 'kenny123', 'kenny123'),
-- ('William', 'Blake', 'Male', 'william@gmail.com', '8683619153', 'william123', 'william123'),
-- ( 'Peter', 'Norvig', 'Male', 'peter@gmail.com', '9609362815', 'peter123', 'peter123'),
-- ( 'Shraddha', 'Kapoor', 'Female', 'shraddha@gmail.com', '9768946252', 'shraddha123', 'shraddha123');

create TABLE `examen`(
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `examen` varchar(50) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `cita` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `id_paciente` int(11) NOT NULL,
  `id_doctor` int(11) NOT NULL,
  -- `pnombre` varchar(20) NOT NULL,
  -- `papellido` varchar(20) NOT NULL,
  -- `genero` varchar(10) NOT NULL,
  -- `correo` varchar(30) NOT NULL,
  -- `telefono` varchar(10) NOT NULL,
  -- `doctor` varchar(50) NOT NULL,
  -- `honorarios` int(5) NOT NULL,
  `id_examen` int(1) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `userStatus` int(5) NOT NULL,
  `doctorStatus` int(5) NOT NULL,
  FOREIGN KEY (id_paciente) REFERENCES paciente(id),
  FOREIGN KEY (id_doctor) REFERENCES doctor(id),
  FOREIGN KEY (id_examen) REFERENCES examen(id),
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- INSERT INTO `cita` (`pid`, `ID`, `fname`, `lname`, `gender`, `email`, `contact`, `doctor`, `docFees`, `appdate`, `apptime`, `userStatus`, `doctorStatus`) VALUES
-- (4, 1, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Ganesh', 550, '2020-02-14', '10:00:00', 1, 0),
-- (4, 2, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Dinesh', 700, '2020-02-28', '10:00:00', 0, 1),
-- (4, 3, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Amit', 1000, '2020-02-19', '03:00:00', 0, 1),
-- (11, 4, 'Shraddha', 'Kapoor', 'Female', 'shraddha@gmail.com', '9768946252', 'ashok', 500, '2020-02-29', '20:00:00', 1, 1),
-- (4, 5, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Dinesh', 700, '2020-02-28', '12:00:00', 1, 1),
-- (4, 6, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Ganesh', 550, '2020-02-26', '15:00:00', 0, 1),
-- (2, 8, 'Alia', 'Bhatt', 'Female', 'alia@gmail.com', '8976897689', 'Ganesh', 550, '2020-03-21', '10:00:00', 1, 1),
-- (5, 9, 'Gautam', 'Shankararam', 'Male', 'gautam@gmail.com', '9070897653', 'Ganesh', 550, '2020-03-19', '20:00:00', 1, 0),
-- (4, 10, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Ganesh', 550, '0000-00-00', '14:00:00', 1, 0),
-- (4, 11, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Dinesh', 700, '2020-03-27', '15:00:00', 1, 1),
-- (9, 12, 'William', 'Blake', 'Male', 'william@gmail.com', '8683619153', 'Kumar', 800, '2020-03-26', '12:00:00', 1, 1),
-- (9, 13, 'William', 'Blake', 'Male', 'william@gmail.com', '8683619153', 'Tiwary', 450, '2020-03-26', '14:00:00', 1, 1);


CREATE TABLE `resultado` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  -- `doctor` varchar(50) NOT NULL,
  -- `pid` int(11) NOT NULL,
  -- `pnombre` varchar(50) NOT NULL,
  -- `papellido` varchar(50) NOT NULL,
  -- `examen` varchar(250) NOT NULL,
  `id_cita` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `path_resultado` varchar(250) NOT NULL,
  `comentario` varchar(1000) NOT NULL,
  FOREIGN KEY (id_cita) REFERENCES cita(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- INSERT INTO `resultado` (`doctor`, `pid`, `ID`, `fname`, `lname`, `appdate`, `apptime`, `disease`, `allergy`, `prescription`) VALUES
-- ('Dinesh', 4, 11, 'Kishan', 'Lal', '2020-03-27', '15:00:00', 'Cough', 'Nothing', 'Just take a teaspoon of Benadryl every night'),
-- ('Ganesh', 2, 8, 'Alia', 'Bhatt', '2020-03-21', '10:00:00', 'Severe Fever', 'Nothing', 'Take bed rest'),
-- ('Kumar', 9, 12, 'William', 'Blake', '2020-03-26', '12:00:00', 'Sever fever', 'nothing', 'Paracetamol -> 1 every morning and night'),
-- ('Tiwary', 9, 13, 'William', 'Blake', '2020-03-26', '14:00:00', 'Cough', 'Skin dryness', 'Intake fruits with more water content');

COMMIT;