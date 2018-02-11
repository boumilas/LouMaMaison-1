<?php
	function __autoload($nomClasse)
	{
		$repertoires = array(
				RACINE . "controleurs/", 
				RACINE . "modeles/",
				RACINE . "vues/"
			);

		foreach($repertoires as $rep)
		{
			$nomFichier = $rep . $nomClasse . ".php";
			if(file_exists($nomFichier))
			{
				require_once($nomFichier);
				return;
			}
		}
	}
	
	//déclaration de la racine du projet
	define("RACINE", $_SERVER["DOCUMENT_ROOT"] . "/LouMaMaison/LMM/client/");
	//déclaration des infos de connexion
	define("HOST", "localhost");
	define("DBNAME", "loumamaison");
	define("USERNAME", "root");
	define("PWD", "");
	define("DBTYPE", "mysql");
?>