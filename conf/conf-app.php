<?php
	$controller = array(
		"Controller.CLogin.Login" => array("login"),
		"Controller.CSecurity.ControllerSecurity" => array("view-user","view-profile-user","view-module"),
		"Controller.CMedia.CMedia" => array("view-content",'view-slider','view-galleries','create-gallery'),
		"Controller.CSection.CSection" => array("general-section","general-category"),
		"Controller.CContent.ContentController" => array("create-article","create-event","create-language","list-language")
		);
	$model = array(
		"Model.MSecurity.ModelSecurity" => array("view-user","view-profile-user","view-module"),
		"Model.MMedia.Multimedia" => array("view-content",'view-slider','view-galleries','create-gallery'),
		"Model.MSection.Section" => array("general-section","general-category"),
		"Model.MContent.ContentModel" => array("create-article","create-event","general-article","create-language","list-language")
		);

	$conf = array(
		"dirPach" => dirname(__FILE__) . DIRECTORY_SEPARATOR . "..",
		"controller" => $controller,
		"model" => $model
	);
