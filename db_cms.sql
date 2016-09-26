-- phpMyAdmin SQL Dump
-- version 4.6.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 26, 2016 at 11:42 AM
-- Server version: 5.6.30-1
-- PHP Version: 5.6.21-2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_article`
--

CREATE TABLE `tb_article` (
  `art_cod` int(11) NOT NULL,
  `art_title` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `art_sub_title` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `art_sumary` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `art_content` text COLLATE utf8_spanish_ci,
  `cod_section` int(11) NOT NULL,
  `art_img_main` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `art_thumbnail` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `art_date_create` varchar(16) COLLATE utf8_spanish_ci DEFAULT NULL,
  `art_date_published` datetime NOT NULL,
  `art_metatag` varchar(400) COLLATE utf8_spanish_ci NOT NULL,
  `art_status` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `art_main` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `art_cod_gallery` int(11) NOT NULL,
  `art_creator` int(11) NOT NULL,
  `art_show_index` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `art_url_es` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `art_title_es` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `art_sub_title_es` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `art_sumary_es` varchar(400) COLLATE utf8_spanish_ci DEFAULT NULL,
  `art_content_es` text COLLATE utf8_spanish_ci,
  `cod_language` varchar(3) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_containers`
--

CREATE TABLE `tb_containers` (
  `cont_cod` int(11) NOT NULL,
  `cont_name` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cont_real_name` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `date_creation` date DEFAULT NULL,
  `cont_path` varchar(160) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cont_parent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_correos`
--

CREATE TABLE `tb_correos` (
  `id_registro` int(11) NOT NULL,
  `nombre_apellido` varchar(90) DEFAULT NULL,
  `correo` varchar(90) DEFAULT NULL,
  `status` varchar(1) DEFAULT 'A',
  `razsoc` varchar(100) DEFAULT NULL,
  `rif` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `inquietud` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_files`
--

CREATE TABLE `tb_files` (
  `fil_real_name` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fil_router` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fil_type` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fil_date_upload` date DEFAULT NULL,
  `cont_cod` int(11) DEFAULT NULL,
  `fil_name` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fil_cod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_gallery`
--

CREATE TABLE `tb_gallery` (
  `gal_cod` int(11) NOT NULL,
  `gal_name` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `gal_date` varchar(16) COLLATE utf8_spanish_ci DEFAULT NULL,
  `gal_type` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `gal_status` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cod_language` varchar(3) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_gallery_file`
--

CREATE TABLE `tb_gallery_file` (
  `gal_detail_id` int(11) NOT NULL,
  `gal_parent` int(11) DEFAULT NULL,
  `gal_file_patch` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `gal_url` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `gal_file_descrip` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `gal_file_credito` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_idiomas`
--

CREATE TABLE `tb_idiomas` (
  `id_language` int(11) NOT NULL,
  `language` varchar(45) DEFAULT NULL,
  `status` varchar(1) DEFAULT 'A',
  `cod_language` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_idiomas`
--

INSERT INTO `tb_idiomas` (`id_language`, `language`, `status`, `cod_language`) VALUES
(2, 'Español', 'A', 'es');

-- --------------------------------------------------------

--
-- Table structure for table `tb_menu`
--

CREATE TABLE `tb_menu` (
  `cod_menu` int(11) NOT NULL,
  `name_menu` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `addr_menu` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `active` int(11) DEFAULT NULL,
  `cod_menu_parent` int(11) DEFAULT NULL,
  `class_ico` char(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `title_menu` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `type_menu` char(1) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `tb_menu`
--

INSERT INTO `tb_menu` (`cod_menu`, `name_menu`, `addr_menu`, `active`, `cod_menu_parent`, `class_ico`, `title_menu`, `type_menu`) VALUES
(1, 'Usuarios', '/Security', 1, 0, NULL, NULL, 'S'),
(2, 'Mi Cuenta', '/Security/User/my-account', 1, 1, NULL, NULL, 'S'),
(3, 'Registro de Usuarios', '/Security/User/view-user', 1, 1, 'ico-user', 'Gestionar Usuarios del Sistema', 'S'),
(4, 'Procesar Registro de Usuarios', '/Security/User/view-user/add-user', 1, 3, NULL, NULL, 'S'),
(5, 'Procesar Actualizacion de Usuarios', '/Security/User/view-user/edit-user', 1, 3, NULL, NULL, 'S'),
(6, 'Elimianar Usuarios', '/Security/User/view-user/delete-user', 1, 3, NULL, NULL, 'S'),
(7, 'Administración del Sistema', '/Security/Module', 1, 0, NULL, NULL, 'S'),
(8, 'Gestionar Opciones del Sistema', '/Security/Module/view-module', 1, 7, 'ico-module', 'Gestionar Opciones del Sistema', 'S'),
(9, 'Perfiles de Usuario', '/Security/Profile/view-profile-user', 1, 1, 'ico-perfiles', 'Gestionar Perfiles de Usaurios', 'S'),
(10, 'Registrar Perfiles', '/Security/Profile/view-profile-user/add-profile', 1, 9, 'ico-perfiles', 'Gestionar Perfiles de Usaurios', 'S'),
(11, 'Actualizar Perfiles', '/Security/Profile/view-profile-user/edit-profile', 1, 9, 'ico-perfiles', 'Gestionar Perfiles de Usaurios', 'S'),
(12, 'Registrar Opciones del Sistema', '/Security/Module/view-module/add-module', 1, 8, 'ico-module', 'Gestionar Modulos del Sistema', 'S'),
(13, 'Contenidos', '/Content', 1, 0, NULL, 'Gestionar Contenidos', 'L'),
(14, 'Crear Nuevos Artículos', '/Content/Adm/create-article', 1, 13, 'ico-content', 'Gestionar Artículos: Crear Nuevos Artículos', 'L'),
(15, 'Gestionar Artículos', '/Content/Adm/general-article', 1, 13, 'ico-gestion-art', ' Gestionar Artículos: Listado de Artículos', 'L'),
(17, 'Gestionar Secciones', '/Tmp-Struct/Section/general-section', 1, 18, 'ico-section', 'Gestionar Secciones del Template', 'L'),
(18, 'Estructura', '/Tmp-Struct', 1, 0, 'ico-content', 'Estructura', 'L'),
(20, 'Multimedia', '/Content/Multimedia', 1, 0, 'ico-multimedia', 'Multimedia', 'L'),
(21, 'Gestionar Contenedores', '/Multimedia/Container/view-content', 1, 20, 'ico-container', 'Gestionar Contenedores Multimedia', 'L'),
(22, 'Actualizar Opciones del Sistema', '/Security/Module/view-module/edit-module', 1, 8, '', 'Actualizar Opciones', 'S'),
(23, 'Gestionar Galerias', '/Multimedia/Galleries/view-galleries', 1, 20, 'ico-multimedia', 'Gestionar Galerias', 'L'),
(24, 'Crear contenedores multimedia', '/Multimedia/Container/view-content/create-cluster', 1, 21, 'ico-multimedia', 'Gestionar Contenedores Multimedia', 'L'),
(25, 'Eliminar Contenedores', '/Multimedia/Container/view-content/delete-container', 1, 21, 'ico-container', 'Gestionar Contenedores Multimedia', 'L'),
(26, 'Eliminar Archivos', '/Multimedia/Container/view-content/delete-file', 1, 21, 'ico-container', 'Gestionar Contenedores Multimedia', 'L'),
(27, 'Subir Archivos a Contenedores', '/Multimedia/Container/view-content/upload-file', 1, 21, 'ico-multimedia', 'Gestionar Contenedores Multimedia', 'L'),
(28, 'Crear Secciones', '/Tmp-Struct/Section/general-section/add-section', 1, 17, 'ico-module', 'Gestionar Secciones del Template', 'L'),
(29, 'Eliminar Secciones', '/Tmp-Struct/Section/general-section/delete-section', 1, 17, 'ico-section', 'Gestionar Secciones del Template', 'L'),
(30, 'Inhabilitar Secciones', '/Tmp-Struct/Section/general-section/disabled-section', 1, 17, 'ico-section', 'Gestionar Secciones del Template', 'L'),
(31, 'Habilitar Secciones', '/Tmp-Struct/Section/general-section/enabled-section', 1, 17, 'ico-section', 'Gestionar Secciones del Template', 'L'),
(32, 'Actualizar sección', '/Tmp-Struct/Section/general-section/edit-section', 1, 17, 'ico-section', 'Gestionar Secciones del Template', 'L'),
(33, 'Eliminar Areas de las secciones', '/Tmp-Struct/Section/general-section/delete-area', 1, 17, 'ico-section', 'Gestionar Secciones del Template', 'L'),
(34, 'Eliminar opciones del sistema', '/Security/Module/view-module/delete-module', 1, 8, 'ico-module', 'Gestionar Modulos del Sistema', 'S'),
(40, 'Registrar artículo', '/Content/Adm/create-article/add-article', 1, 14, 'ico-content', 'Gestionar Artículos: Crear Nuevos Artículos', 'L'),
(41, 'Gestionar Slider', '/Multimedia/Slider/view-slider', 1, 20, 'ico-slider', 'Gestionar Slider', 'L'),
(42, 'Registrar nuevo slider', '/Multimedia/Slider/view-slider/add-slider', 1, 41, 'ico-slider', 'Gestionar Slider', 'L'),
(43, 'Editar slider', '/Multimedia/Slider/view-slider/edit-slider', 1, 41, 'ico-slider', 'Gestionar Slider', 'L'),
(44, 'Actualizar artículos', '/Content/Adm/create-article/edit-article', 1, 15, 'ico-content', 'Gestionar Artículos', 'L'),
(45, 'Gestionar Eventos', '/Content/Event/list', 0, 13, 'ico-content', 'Gestionar Eventos', 'L'),
(46, 'Guardar Eventos', '/Content/Event/create-event/add-event', 0, 45, 'ico-content', 'Gestionar Eventos', 'L'),
(47, 'Registrar Eventos', '/Content/Event/create-event', 0, 45, 'ico-content', 'Registrar Eventos', 'L'),
(48, 'Actualizar Evento', '/Content/Event/create-event/edit-event', 0, 45, 'ico-content', 'Gestionar Eventos', 'L'),
(49, 'Actualizar Galerías', '/Multimedia/Galleries/view-galleries/edit-gallery', 1, 23, 'ico-multimedia', 'Gestionar Galerías', ''),
(50, 'Grabar Galerías', '/Multimedia/Galleries/create-gallery/add-gallery', 1, 23, 'ico-multimedia', 'Gestionar Galerías', ''),
(60, 'Crear galerías', '/Multimedia/Galleries/create-gallery', 1, 23, 'ico-multimedia', 'Gestión de Galerías Multimedia', 'L'),
(61, 'Inhabilitar artículo', '/Content/Adm/general-article/disabled-article', 1, 15, 'ico-gestion-art', 'Inhabilitar artículo', 'L'),
(62, 'Habilitar artículo', '/Content/Adm/general-article/enabled-article', 1, 15, 'ico-gestion-art', 'Habilitar artículo', 'L'),
(63, 'Eliminiar artículo', '/Content/Adm/general-article/delete-article', 1, 15, 'ico-gestion-art', 'Actualizar artículo', 'L'),
(64, 'Gestionar lenguaje', '/Content/language/list-language', 1, 13, 'ico-module', 'Gestionar lenguaje', 'L'),
(65, 'Gestionar lenguaje', '/Content/language/list-language', 1, 64, 'ico-module', 'Gestionar lenguaje', 'L'),
(66, 'Crear idioma', '/Content/language/create-language', 1, 64, 'ico-module', 'Crear idioma', 'L'),
(67, 'Crear idioma', '/Content/language/create-language/add-language', 1, 66, 'ico-module', 'Crear idioma', 'L'),
(68, 'Eliminar idioma', '/Content/language/list-language/delete-language', 1, 66, 'ico-module', 'Eliminar idioma', 'L'),
(69, 'Eliminar galerias', '/Multimedia/Galleries/view-galleries/delete-gallery', 1, 23, 'ico-multimedia', 'Gestionar Galerias', 'L');

-- --------------------------------------------------------

--
-- Table structure for table `tb_permission`
--

CREATE TABLE `tb_permission` (
  `cod_module` int(11) DEFAULT NULL,
  `permission` int(11) DEFAULT NULL,
  `cod_profile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `tb_permission`
--

INSERT INTO `tb_permission` (`cod_module`, `permission`, `cod_profile`) VALUES
(2, 1, 2),
(3, 1, 2),
(9, 1, 2),
(8, 1, 2),
(14, 1, 2),
(15, 1, 2),
(45, 1, 2),
(17, 1, 2),
(21, 1, 2),
(23, 1, 2),
(41, 1, 2),
(2, 1, 3),
(3, 1, 3),
(4, 1, 3),
(5, 1, 3),
(6, 1, 3),
(14, 1, 3),
(40, 1, 3),
(15, 1, 3),
(44, 1, 3),
(17, 1, 3),
(30, 1, 3),
(31, 1, 3),
(32, 1, 3),
(21, 1, 3),
(24, 1, 3),
(25, 1, 3),
(26, 1, 3),
(27, 1, 3),
(23, 1, 3),
(49, 1, 3),
(50, 1, 3),
(60, 1, 3),
(41, 1, 3),
(42, 1, 3),
(43, 1, 3),
(2, 1, 1),
(3, 1, 1),
(4, 1, 1),
(5, 1, 1),
(6, 1, 1),
(9, 1, 1),
(10, 1, 1),
(11, 1, 1),
(8, 1, 1),
(12, 1, 1),
(22, 1, 1),
(34, 1, 1),
(14, 1, 1),
(40, 1, 1),
(15, 1, 1),
(44, 1, 1),
(61, 1, 1),
(62, 1, 1),
(63, 1, 1),
(45, 1, 1),
(46, 1, 1),
(47, 1, 1),
(48, 1, 1),
(64, 1, 1),
(65, 1, 1),
(66, 1, 1),
(67, 1, 1),
(68, 1, 1),
(17, 1, 1),
(28, 1, 1),
(29, 1, 1),
(30, 1, 1),
(31, 1, 1),
(32, 1, 1),
(33, 1, 1),
(21, 1, 1),
(24, 1, 1),
(25, 1, 1),
(26, 1, 1),
(27, 1, 1),
(23, 1, 1),
(49, 1, 1),
(50, 1, 1),
(60, 1, 1),
(69, 1, 1),
(41, 1, 1),
(42, 1, 1),
(43, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_profiles`
--

CREATE TABLE `tb_profiles` (
  `cod_profile` int(11) NOT NULL,
  `name_profile` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `tb_profiles`
--

INSERT INTO `tb_profiles` (`cod_profile`, `name_profile`) VALUES
(1, 'Super Administrador'),
(2, 'demo'),
(3, 'Adminsitrador');

-- --------------------------------------------------------

--
-- Table structure for table `tb_section`
--

CREATE TABLE `tb_section` (
  `cod_section` int(11) NOT NULL,
  `background` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `active_section` int(11) DEFAULT NULL,
  `main_section` int(11) DEFAULT NULL,
  `open_section` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `cod_section_parent` int(11) NOT NULL DEFAULT '0',
  `name_section_es` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descrip_section_es` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `section_url_es` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `title_section_es` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cod_language` varchar(3) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_section_area`
--

CREATE TABLE `tb_section_area` (
  `cod_section` int(11) NOT NULL,
  `cod_area` int(11) NOT NULL,
  `name_area` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `width_area` int(11) DEFAULT NULL,
  `css_area` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `cod_type_content` int(11) DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `background` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `font_color` varchar(16) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_sliders`
--

CREATE TABLE `tb_sliders` (
  `slider_cod` int(11) NOT NULL,
  `slider_date_creation` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `slider_name` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `slider_status` int(11) NOT NULL,
  `slider_name_es` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cod_language` varchar(3) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_slider_assoc_section`
--

CREATE TABLE `tb_slider_assoc_section` (
  `slider_cod` int(11) NOT NULL,
  `cod_section` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_slider_file`
--

CREATE TABLE `tb_slider_file` (
  `cod` int(11) NOT NULL,
  `slider_parent` int(11) NOT NULL,
  `slider_file_patch` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `slider_url` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `slider_file_descrip` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `slider_file_credito` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_type_content`
--

CREATE TABLE `tb_type_content` (
  `cod_type_content` int(11) NOT NULL,
  `type_content` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sql_script` text COLLATE utf8_spanish_ci,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `tb_type_content`
--

INSERT INTO `tb_type_content` (`cod_type_content`, `type_content`, `sql_script`, `active`) VALUES
(1, 'Artículos destacado en secciones', 'select art_url, section_url, art_title, art_sumary, art_img_main\nfrom tb_article a, tb_section b\nwhere a.cod_section = b.cod_section and art_main = \'SI\' and art_date_published <= ? and section_url = ?\norder by art_date_published desc\nlimit 1', 1),
(2, 'Artículos destacado en index', 'select art_url, section_url, art_title, art_sumary, art_thumbnail\nfrom tb_article a, tb_section b\nwhere a.cod_section = b.cod_section and art_show_index = \'SI\' and  art_status = \'SI\' and art_date_published <= ?\norder by art_date_published desc\nlimit 3', 1),
(3, 'Artículos relacionado', 'select art_url, section_url, art_thumbnail , art_title, art_sumary\nfrom tb_article a, tb_section b\nwhere art_main = \'NO\' and art_status = \'SI\' and b.cod_section = a.cod_section and section_url = ? and art_date_create >= ?\norder by art_date_published desc\nlimit 3\n', 1),
(4, 'Artículos relacionado (LINK)', NULL, 0),
(25, 'Detalle del Artículo', 'select art_cod_gallery, art_content, art_img_main, art_title\nfrom tb_article a, tb_section b\nwhere art_status = \'SI\'  and a.cod_section = b.cod_section and section_url = ? and art_date_create >= ?\norder by desc\nlimit 1', 0),
(26, 'Slider', NULL, 1),
(27, 'Galería de imágenes', NULL, 0),
(28, 'Galería de Videos Principal', 'select gal_cod\nfrom tb_gallery a\nwhere gal_status = 1 and gal_type = \'Videos\'\norder by gal_date desc \nlimit 1', 0),
(39, 'Galería de Archivos Descargables', NULL, 0),
(40, 'Lista secciones internas', 'select cod_section, name_section, a.background,title_section, open_section,section_url\nfrom tb_section a\nwhere main_section = 0 and active_section = 1 and cod_section_parent in (select cod_section from tb_section where section_url = ?)', 1),
(41, 'Encuesta', NULL, 0),
(42, 'Personalizado', NULL, 1),
(43, 'Listado de árticulos por seccion', 'select art_thumbnail, art_content,art_title, section_url,art_url from tb_article a, tb_section b where a.cod_section = b.cod_section and section_url = ? and art_status = \'SI\' and art_date_published <= ? order by art_date_published desc', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `coduser` int(11) NOT NULL,
  `nomuser` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usersession` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `passuser` text COLLATE utf8_spanish_ci,
  `codperfil` int(11) DEFAULT NULL,
  `status` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `emailuser` varchar(80) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`coduser`, `nomuser`, `usersession`, `passuser`, `codperfil`, `status`, `emailuser`) VALUES
(777, 'Administrador', 'administrador', 'Vm0wd2VHUXhTWGxTYmxKV1YwZDRXRmxVU2xOV1ZsbDNXa1pPVlUxV2NIcFhhMk0xVmpBeFdHVkVRbUZXVmxsM1ZtMTRZV015U2tWVWJHaG9UVlZ3VlZkV1pIcGxSbGw1Vkd0a1dHSkdjRmhVVkVaSFRURmtWMWRzV214U2JWSkpWbTEwVjFWdFNrZFhia0pXWWxSV1JGcFdXbXRXTVZwMFVteG9hVlpzY0VsV01uUnZVakZWZVZOcmFGWmhlbXhZV1d4b1UxbFdjRmhsUjBaWFlrZFNlVll5ZUVOV01rVjNZMFpTVjFaV2NGTmFSRVpEVld4Q1ZVMUVNRDA9WmpvMk9pSXhNekF5TURJaU93PT0=', 1, 'A', 'programador.angel@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_article`
--
ALTER TABLE `tb_article`
  ADD PRIMARY KEY (`art_cod`),
  ADD UNIQUE KEY `art_url_es_UNIQUE` (`art_url_es`),
  ADD KEY `art_referen_img` (`art_img_main`(255)),
  ADD KEY `art_creator` (`art_creator`),
  ADD KEY `cod_section` (`cod_section`);

--
-- Indexes for table `tb_containers`
--
ALTER TABLE `tb_containers`
  ADD PRIMARY KEY (`cont_cod`);

--
-- Indexes for table `tb_correos`
--
ALTER TABLE `tb_correos`
  ADD PRIMARY KEY (`id_registro`),
  ADD UNIQUE KEY `correo_UNIQUE` (`correo`);

--
-- Indexes for table `tb_files`
--
ALTER TABLE `tb_files`
  ADD PRIMARY KEY (`fil_cod`),
  ADD KEY `cont_cod` (`cont_cod`);

--
-- Indexes for table `tb_gallery`
--
ALTER TABLE `tb_gallery`
  ADD UNIQUE KEY `gal_cod` (`gal_cod`);

--
-- Indexes for table `tb_gallery_file`
--
ALTER TABLE `tb_gallery_file`
  ADD PRIMARY KEY (`gal_detail_id`),
  ADD KEY `gal_cod` (`gal_parent`),
  ADD KEY `file_cod` (`gal_file_patch`(255));

--
-- Indexes for table `tb_idiomas`
--
ALTER TABLE `tb_idiomas`
  ADD PRIMARY KEY (`id_language`);

--
-- Indexes for table `tb_menu`
--
ALTER TABLE `tb_menu`
  ADD PRIMARY KEY (`cod_menu`);

--
-- Indexes for table `tb_permission`
--
ALTER TABLE `tb_permission`
  ADD KEY `cod_module` (`cod_module`),
  ADD KEY `cod_profile` (`cod_profile`);

--
-- Indexes for table `tb_profiles`
--
ALTER TABLE `tb_profiles`
  ADD PRIMARY KEY (`cod_profile`);

--
-- Indexes for table `tb_section`
--
ALTER TABLE `tb_section`
  ADD PRIMARY KEY (`cod_section`);

--
-- Indexes for table `tb_section_area`
--
ALTER TABLE `tb_section_area`
  ADD PRIMARY KEY (`cod_area`),
  ADD KEY `cod_section` (`cod_section`);

--
-- Indexes for table `tb_sliders`
--
ALTER TABLE `tb_sliders`
  ADD PRIMARY KEY (`slider_cod`);

--
-- Indexes for table `tb_slider_assoc_section`
--
ALTER TABLE `tb_slider_assoc_section`
  ADD KEY `slider_cod` (`slider_cod`),
  ADD KEY `cod_section` (`cod_section`);

--
-- Indexes for table `tb_slider_file`
--
ALTER TABLE `tb_slider_file`
  ADD PRIMARY KEY (`cod`),
  ADD KEY `slider_parent` (`slider_parent`);

--
-- Indexes for table `tb_type_content`
--
ALTER TABLE `tb_type_content`
  ADD PRIMARY KEY (`cod_type_content`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`coduser`),
  ADD KEY `codperfil` (`codperfil`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_article`
--
ALTER TABLE `tb_article`
  MODIFY `art_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tb_containers`
--
ALTER TABLE `tb_containers`
  MODIFY `cont_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tb_correos`
--
ALTER TABLE `tb_correos`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `tb_files`
--
ALTER TABLE `tb_files`
  MODIFY `fil_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `tb_gallery`
--
ALTER TABLE `tb_gallery`
  MODIFY `gal_cod` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_gallery_file`
--
ALTER TABLE `tb_gallery_file`
  MODIFY `gal_detail_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_idiomas`
--
ALTER TABLE `tb_idiomas`
  MODIFY `id_language` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_menu`
--
ALTER TABLE `tb_menu`
  MODIFY `cod_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `tb_profiles`
--
ALTER TABLE `tb_profiles`
  MODIFY `cod_profile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_section`
--
ALTER TABLE `tb_section`
  MODIFY `cod_section` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `tb_section_area`
--
ALTER TABLE `tb_section_area`
  MODIFY `cod_area` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_sliders`
--
ALTER TABLE `tb_sliders`
  MODIFY `slider_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_slider_file`
--
ALTER TABLE `tb_slider_file`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `tb_type_content`
--
ALTER TABLE `tb_type_content`
  MODIFY `cod_type_content` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_article`
--
ALTER TABLE `tb_article`
  ADD CONSTRAINT `fk_article_user` FOREIGN KEY (`art_creator`) REFERENCES `tb_user` (`coduser`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cod_section_art` FOREIGN KEY (`cod_section`) REFERENCES `tb_section` (`cod_section`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_files`
--
ALTER TABLE `tb_files`
  ADD CONSTRAINT `tb_files_ibfk_1` FOREIGN KEY (`cont_cod`) REFERENCES `tb_containers` (`cont_cod`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_gallery_file`
--
ALTER TABLE `tb_gallery_file`
  ADD CONSTRAINT `fk_galeria` FOREIGN KEY (`gal_parent`) REFERENCES `tb_gallery` (`gal_cod`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_permission`
--
ALTER TABLE `tb_permission`
  ADD CONSTRAINT `fk_cod_module` FOREIGN KEY (`cod_module`) REFERENCES `tb_menu` (`cod_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cod_profile` FOREIGN KEY (`cod_profile`) REFERENCES `tb_profiles` (`cod_profile`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_section_area`
--
ALTER TABLE `tb_section_area`
  ADD CONSTRAINT `fk_section` FOREIGN KEY (`cod_section`) REFERENCES `tb_section` (`cod_section`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_slider_assoc_section`
--
ALTER TABLE `tb_slider_assoc_section`
  ADD CONSTRAINT `fk_assoc_section` FOREIGN KEY (`cod_section`) REFERENCES `tb_section` (`cod_section`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_assoc_slider` FOREIGN KEY (`slider_cod`) REFERENCES `tb_sliders` (`slider_cod`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_slider_file`
--
ALTER TABLE `tb_slider_file`
  ADD CONSTRAINT `fk_slider_detail` FOREIGN KEY (`slider_parent`) REFERENCES `tb_sliders` (`slider_cod`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `fk_user_profile` FOREIGN KEY (`codperfil`) REFERENCES `tb_profiles` (`cod_profile`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
