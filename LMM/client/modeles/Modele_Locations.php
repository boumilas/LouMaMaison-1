<?php
/**
* @file         /Modele_Locations.php
* @brief        Projet WEB 2
* @details                              
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018  
*/

	/**
	* @class 	Modele_Locations - herite de BaseDao
	* @details  Classe qui lie les requetes d'objects Location a la BD
	*					- definit les requetes specifiques a la classe
	*
***	* 	... 5 methodes	|	getTableName(), creerLocation(), afficheLocation(), misAjourChampUnique(), 
	*						obtenir_par_idApt()
	*/
	class Modele_Locations extends BaseDAO
	{

		/**  
		* @brief     	Renvoie le nom de la table location
		* @param   		Aucun
		* @return    	Le nom de la table location
		*/
		public function getTableName()
		{
			return "location";
		}

		/**  
		* @brief     	Créer location d'un appartement
		* @details   	Inscrire la création d'une location à la BD
		* @param   		<object>      	Location
		* @return    	Résultat de la requête SQL
		 */ 
		public function creerLocation(Location $Location)

		{
			$query = "INSERT INTO " . $this->getTableName() . " (dateDebut, dateFin, id_appartement, id_userClient,  nbPersonnes) VALUES (?, ?, ?, ?, ?)";
			$data = array($Location->getDateDebut(), $Location->getDateFin(), $Location->getIdAppartement(), $Location->getIdUserClient(),  $Location->getNbPersonnes());
			return $this->requete($query, $data);
		}
				
		/**  
		* @brief     	Afficher des locations avec status différents
		* @param   		<int>   $valideParPrestataire : validé ou non par proprio
		* @param   		<int>   $validePaiement : le paiment validé ou non 
		* @param   		<int>   $dateNow : date d'aujourd'hui
		* @return    	<...> 	Résultat de la requête SQL
		*/
        public function afficheLocation($valideParPrestataire, $validePaiement, $dateNow) 
        {
            $query = "SELECT * FROM " . $this->getTableName() . " WHERE valideParPrestataire = ? AND validePaiement = ? AND dateDebut > ?";
            $donnees = array($valideParPrestataire, $validePaiement, $dateNow);
            $resultat = $this->requete($query, $donnees);
            return $resultat->fetchAll();
        }
		 
        /**
		* @brief		Fonction pour changer le status de validation
		* @details		Permet de changer le statut des champs: validePaiement et 	valideParPrestataire
		* @param 		<VAR>		$leChamp		Le champ à modifier (validePaiement / valideParPrestataire)
		* @param 		<VAR>		$laValeur		La nouvelle valeur de ce champ
		* @param 		<VAR>		$id 			id de location dans la base de données
		* @return    	<bool>		résultat de la requete
		*/
		public function misAjourChampUnique($leChamp, $laValeur, $id)
		{
			return $this->miseAjourChamp($leChamp, $laValeur, $id);	 
		}

		/**  
		* @brief     	Fonction de recherche d'une location par appartement
		* @details   	Recherche une ou plusieurs location(s) associee(s) a un appartement
		* @param   		<int>		$idApt			Identifiant d'appartement
		* @param   		<int>		$colonneIdApt	Le nom de la colonne id_appartement
		* @return    	Résultat de la requête SQL
		*/
		public function obtenir_par_idApt($idApt, $colonneIdApt) {

			$query = "SELECT * from " . $this->getTableName() . " WHERE " . $colonneIdApt ."= ?"; 
			$donnees = array($idApt);
			$resultat = $this->requete($query, $donnees);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Location');
			return $resultat->fetchAll();
		}
	}

?>