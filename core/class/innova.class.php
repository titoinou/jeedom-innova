<?php
/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';

class innova extends eqLogic {
  /*     * *************************Attributs****************************** */

  /*
  * Permet de définir les possibilités de personnalisation du widget (en cas d'utilisation de la fonction 'toHtml' par exemple)
  * Tableau multidimensionnel - exemple: array('custom' => true, 'custom::layout' => false)
  public static $_widgetPossibility = array();
  */

  /*
  * Permet de crypter/décrypter automatiquement des champs de configuration du plugin
  * Exemple : "param1" & "param2" seront cryptés mais pas "param3"
  public static $_encryptConfigKey = array('param1', 'param2');
  */

  /*     * ***********************Methode static*************************** */

  //Fonction exécutée automatiquement toutes les minutes par Jeedom
  public static function cron() {
  	foreach (self::byType('innova') as $eqLogicInnova) {
		if($eqLogicInnova->getIsEnable() == 0){
			$eqLogicInnova->getInfos();
		}
		log::add('mideawifi', 'debug', 'update clim ' . $eqLogicInnova->getName());
	}
  }

  
  /*Fonction exécutée automatiquement toutes les 5 minutes par Jeedom
  public static function cron5() {}
  */
	
  /*
  * Fonction exécutée automatiquement toutes les 10 minutes par Jeedom
  public static function cron10() {}
  */

  /*
  * Fonction exécutée automatiquement toutes les 15 minutes par Jeedom
  public static function cron15() {}
  */

  /*
  * Fonction exécutée automatiquement toutes les 30 minutes par Jeedom
  public static function cron30() {}
  */

  /*
  * Fonction exécutée automatiquement toutes les heures par Jeedom
  public static function cronHourly() {}
  */

  /*
  * Fonction exécutée automatiquement tous les jours par Jeedom
  public static function cronDaily() {}
  */

  /*     * *********************Méthodes d'instance************************* */

  // Fonction exécutée automatiquement avant la création de l'équipement
  public function preInsert() {
  }

  // Fonction exécutée automatiquement après la création de l'équipement
  public function postInsert() {
  }

  // Fonction exécutée automatiquement avant la mise à jour de l'équipement
  public function preUpdate() {
  }

  // Fonction exécutée automatiquement après la mise à jour de l'équipement
  public function postUpdate() {
  }

  // Fonction exécutée automatiquement avant la sauvegarde (création ou mise à jour) de l'équipement
  public function preSave() {
  }

  // Fonction exécutée automatiquement après la sauvegarde (création ou mise à jour) de l'équipement
  public function postSave() {
/*    $order = 1;

		// ================================================================================================================= //
		// ===================================================== INFOS ===================================================== //
		// ================================================================================================================= //

		// etat alimentation
		$infoState = $this->getCmd(null, 'power_state');
		if (!is_object($infoState)) {
			$infoState = new innovaCmd();
			$infoState->setName(__('Etat courant', __FILE__));
		}
		$infoState->setOrder($order++);
		$infoState->setLogicalId('power_state');
		$infoState->setEqLogic_id($this->getId());
		$infoState->setType('info');

		$infoState->setSubType('binary');
		$infoState->setIsVisible(1);
		$infoState->setIsHistorized(1);
		$infoState->setDisplay('forceReturnLineBefore', false);
		$infoState->save();

		// température désirée
		$infoTemp = $this->getCmd(null, 'target_temperature');
		if (!is_object($infoTemp)) {
			$infoTemp = new innovaCmd();
			$infoTemp->setName(__('Température désirée', __FILE__));
		}
		$infoTemp->setOrder($order++);
		$infoTemp->setLogicalId('target_temperature');
		$infoTemp->setEqLogic_id($this->getId());
		$infoTemp->setType('info');
		$infoTemp->setTemplate('dashboard', 'tile'); //template pour le dashboard
		$infoTemp->setSubType('string');
		$infoTemp->setIsVisible(0);
		$infoTemp->setUnite('°C');
		//$infoTemp->setDisplay('generic_type', 'TEMPERATURE');
		$infoTemp->setDisplay('forceReturnLineBefore', false);
		$infoTemp->save();

		// vitesse ventilateur
		$infoSpeedfan = $this->getCmd(null, 'fan_speed');
		if (!is_object($infoSpeedfan)) {
			$infoSpeedfan = new innovaCmd();
			$infoSpeedfan->setName(__('Vitesse', __FILE__));
		}
		$infoSpeedfan->setOrder($order++);
		$infoSpeedfan->setLogicalId('fan_speed');
		$infoSpeedfan->setEqLogic_id($this->getId());
		$infoSpeedfan->setType('info');
		$infoSpeedfan->setSubType('string');
		$infoSpeedfan->setIsVisible(0);
      	$infoSpeedfan->setDisplay('forceReturnLineBefore', false);
		$infoSpeedfan->save();

		// Mode de ventilation
		$infoSwingmode = $this->getCmd(null, 'swing_mode');
		if (!is_object($infoSwingmode)) {
			$infoSwingmode = new innovaCmd();
			$infoSwingmode->setName(__('Direction', __FILE__));
		}
		$infoSwingmode->setOrder($order++);
		$infoSwingmode->setLogicalId('swing_mode');
		$infoSwingmode->setEqLogic_id($this->getId());
		$infoSwingmode->setType('info');
		$infoSwingmode->setSubType('string');
		$infoSwingmode->setIsVisible(0);
      		$infoSwingmode->setDisplay('forceReturnLineBefore', false);
		$infoSwingmode->save();

		// Mode Nuit
		$info = $this->getCmd(null, 'night_mode');
		if (!is_object($info)) {
			$info = new innovaCmd();
			$info->setName(__('Mode éco', __FILE__));
		}
		$info->setOrder($order++);
		$info->setLogicalId('eco_mode');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setTemplate('dashboard', 'default'); //template pour le dashboard
		$info->setSubType('binary');
		$info->setIsVisible(1);
		$info->setIsHistorized(0);
		$info->setDisplay('forceReturnLineBefore', false);
		$info->save();

		// mode opérationnel
		$infoMode = $this->getCmd(null, 'operational_mode');
		if (!is_object($infoMode)) {
			$infoMode = new innovaCmd();
			$infoMode->setName(__('Mode courant', __FILE__));
		}
		$infoMode->setOrder($order++);
		$infoMode->setLogicalId('operational_mode');
		$infoMode->setEqLogic_id($this->getId());
		$infoMode->setType('info');
		/*if ( version_compare(jeedom::version(), "4", "<") ) {
		$infoMode->setTemplate('dashboard', 'displayModeInfo'); //template pour le dashboard en v3
		} else {
		$infoMode->setTemplate('dashboard', 'mideawifi::displayModeInfo'); //template pour le dashboard
		}*/
		/*$infoMode->setSubType('string');
		$infoMode->setIsVisible(0);
		//$infoMode->setDisplay('generic_type', 'MODE_STATE');
		$infoMode->setDisplay('forceReturnLineBefore', true);
		$infoMode->save();

		// température intérieure
		$info = $this->getCmd(null, 'indoor_temperature');
		if (!is_object($info)) {
			$info = new innovaCmd();
			$info->setName(__('Température intérieure', __FILE__));
		}
		$info->setOrder($order++);
		$info->setLogicalId('indoor_temperature');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setTemplate('dashboard', 'default'); //template pour le dashboard
		$info->setSubType('string');
		$info->setIsVisible(1);
		$info->setIsHistorized(1);
		$info->setUnite('°C');
		$info->setDisplay('forceReturnLineBefore', true);
		$info->save();
*/
		// ================================================================================================================= //
		// ==================================================== ACTIONS ==================================================== //
		// ================================================================================================================= //

		// @DEVHELP https://github.com/jeedom/core/blob/06fb34c895b420630bfa9d9317547088b13f81d7/core/config/jeedom.config.php

		// Allumage/Extinction clim
		/*$cmd = $this->getCmd('action', 'setPowerState');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Etat', __FILE__));
		}
		$cmd->setOrder(1);
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setPowerState');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setValue($infoState->getId());
		$cmd->setTemplate('dashboard', 'mideawifi::powerState'); //template pour le dashboard
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();*/
/*
      	$cmd = $this->getCmd('action', 'on');
		if (!is_object($cmd)) {
		$cmd = new innovaCmd();
		$cmd->setName(__('Allumer', __FILE__));
		}
		$cmd->setOrder($order++);
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('on');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setDisplay('generic_type', 'ENERGY_ON');
		$info->setDisplay('forceReturnLineBefore', true);
		//$info->setDisplay('forceReturnLineAfter', true);
		$cmd->save();
      
		// Extinction clim
		$cmd = $this->getCmd('action', 'off');
		if (!is_object($cmd)) {
		$cmd = new innovaCmd();
		$cmd->setName(__('Eteindre', __FILE__));
		}
		$cmd->setOrder($order++);
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('off');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setDisplay('generic_type', 'ENERGY_OFF');
		//$info->setDisplay('forceReturnLineBefore', true);
		$info->setDisplay('forceReturnLineAfter', true);
		$cmd->save();

		// Changement température de consigne
		$cmd = $this->getCmd('action', 'setTemperature');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Température de consigne', __FILE__));
		}
		$cmd->setOrder($order++);
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setTemperature');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('slider');
		$cmd->setConfiguration('minValue', 16);
		$cmd->setConfiguration('maxValue', 30);
		$cmd->setUnite('°C');
		$cmd->setValue($infoTemp->getId());
      		if(version_compare(jeedom::version(), "4", "<")) {
			$cmd->setTemplate('dashboard', 'setTemperature');
          		$cmd->setTemplate('mobile', 'setTemperature');
        	} else {
			$cmd->setTemplate('dashboard', 'mideawifi::setTemperature');
	          	$cmd->setTemplate('mobile', 'mideawifi::setTemperature');
        	}
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();

		// Changement du mode
		$cmd = $this->getCmd('action', 'setMode');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Mode', __FILE__));
		}           
		$cmd->setOrder($order++);
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setMode');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('select');
		$cmd->setValue($infoMode->getId());
		$cmd->setConfiguration('listValue', "auto|auto;cool|climatisation;dry|déshumidificateur;heat|Chauffage;fan_only|Ventilation");
		$cmd->setTemplate('dashboard', 'mideawifi::tmplSelect');
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();

		// Changement de l'orientation de la ventilation
		log::add('mideawifi', 'debug', '===== Save Swingmode =====');
		$cmd = $this->getCmd('action', 'setSwingmode');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Type de ventilation', __FILE__));
		}           
		$cmd->setOrder($order++);
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setSwingmode');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('select');
		// MAJ de l'énumeration des orientations par rapport à la configuration choisie
		$currentSwingmodes = $this->getConfiguration('swingmode');
		log::add('mideawifi', 'debug', 'swingMode sélectionné = ' . $currentSwingmodes);
		if($currentSwingmodes == "Vertical") {
			$cmd->setConfiguration('listValue', "Off|Eteint;Vertical|Vertical");
		} elseif ($currentSwingmodes == "Horizontal") {
			$cmd->setConfiguration('listValue', "Off|Eteint;Horizontal|Horizontal");
		} else {
			$cmd->setConfiguration('listValue', "Off|Eteint;Vertical|Vertical;Horizontal|Horizontal;Both|Les deux");
		}
		// on met à jour la commande info avec la configuration (choix le plus logique) choisie
		$this->checkAndUpdateCmd("swing_mode", $currentSwingmodes);
		$cmd->setValue($infoSwingmode->getId());
		$cmd->setTemplate('dashboard','mideawifi::tmplSelect');
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();

		// Changement de la vitesse de ventilation
		$cmd = $this->getCmd('action', 'setFanspeed');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Vitesse de ventilation', __FILE__));
		}         
		$cmd->setOrder($order++);
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setFanspeed');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('select');
		$cmd->setValue($infoSpeedfan->getId());
		$cmd->setConfiguration('listValue', "Auto|Automatique;High|Rapide;Medium|Moyenne;Low|Lente;Silent|Silencieuse");
		$cmd->setTemplate('dashboard', 'mideawifi::tmplSelect');
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();

		// Mise en route du mode Eco
		$cmd = $this->getCmd('action', 'setEcomode');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Eco', __FILE__));
		}
		$cmd->setOrder($order++);
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setEcomode');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();

		// Mise en route du mode Turbo
		$cmd = $this->getCmd('action', 'setTurbomode');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Turbo', __FILE__));
		}
		$cmd->setOrder($order++);
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setTurbomode');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setDisplay('forceReturnLineBefore', false);
		$cmd->save();

		// Désactivation des modes turbo/eco
		$cmd = $this->getCmd('action', 'setNormalmode');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Normal', __FILE__));
		}         
		$cmd->setOrder($order++);
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setNormalmode');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setDisplay('forceReturnLineBefore', false);
		$cmd->setDisplay('forceReturnLineAfter', true);
		$cmd->save();

		// activation des bips
		$cmd = $this->getCmd('action', 'bipsOn');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Bips ON', __FILE__));
		}         
		$cmd->setOrder($order++);
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('bipsOn');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();

		// Désactivation des bips
		$cmd = $this->getCmd('action', 'bipsOff');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Bips OFF', __FILE__));
		}         
		$cmd->setOrder($order++);
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('bipsOff');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setDisplay('forceReturnLineBefore', false);
		$cmd->save();
		// rafraichir
		$refresh = $this->getCmd(null, 'refresh');
		if (!is_object($refresh)) {
			$refresh = new innovaCmd();
			$refresh->setName(__('Rafraichir', __FILE__));
		}
		$refresh->setEqLogic_id($this->getId());
		$refresh->setLogicalId('refresh');
		$refresh->setType('action');
		$refresh->setSubType('other');
		$refresh->save();

		// à la fin, on contact directement léquipement pour récupérer les infos courantes
		//$this->updateInfos();*/
  }

  // Fonction exécutée automatiquement avant la suppression de l'équipement
  public function preRemove() {
  }

  // Fonction exécutée automatiquement après la suppression de l'équipement
  public function postRemove() {
  }

  /*
  * Permet de crypter/décrypter automatiquement des champs de configuration des équipements
  * Exemple avec le champ "Mot de passe" (password)
  public function decrypt() {
    $this->setConfiguration('password', utils::decrypt($this->getConfiguration('password')));
  }
  public function encrypt() {
    $this->setConfiguration('password', utils::encrypt($this->getConfiguration('password')));
  }
  */

  /*
  * Permet de modifier l'affichage du widget (également utilisable par les commandes)
  public function toHtml($_version = 'dashboard') {}
  */

  /*
  * Permet de déclencher une action avant modification d'une variable de configuration du plugin
  * Exemple avec la variable "param3"
  public static function preConfig_param3() {}
  */

  /*
  * Permet de déclencher une action après modification d'une variable de configuration du plugin
  * Exemple avec la variable "param3"
  public static function postConfig_param3() {}
  */

  /*     * **********************Getteur Setteur*************************** */
  public function getInfos() {
	$serial = $this->getConfiguration('serial');
	$id = $this->getConfiguration('id');
	$uid = $this->getConfiguration('uid');
	$json_string = shell_exec('curl -X POST -H "X-serial: "'.$serial.' -H "X-UID: "'.$uid.' -H "X-Requested-With: XMLHttpRequest" -X POST http://innovaenergie.cloud/api/v/1/status');
        if ($json_string === false) {
            log::add('innova', 'debug', 'Problème de lecture status');
            $request_http->setNoReportError(false);
            $json_string = $request_http->exec(30,1);
            return;
        }
        $info = json_decode($json_string, true);
    	log::add('innova', 'debug', 'test');
	}

	public function updateInfos() {
		$infos = self::getInfos();
		self::_updateInfos($infos);
	}

	private function _updateInfos($infos) {
		$this->checkAndUpdateCmd("power_state", 		$infos["power_state"]);
		$this->checkAndUpdateCmd("power_tone", 			$infos["power_tone"]);
		$this->checkAndUpdateCmd("target_temperature", 	$infos["target_temperature"]);
		$this->checkAndUpdateCmd("operational_mode", 	$infos["operational_mode"]);
		$this->checkAndUpdateCmd("fan_speed", 			$infos["fan_speed"]);
		$this->checkAndUpdateCmd("swing_mode", 			$infos["swing_mode"]);
		$this->checkAndUpdateCmd("eco_mode", 			$infos["night_mode"]);
		$this->checkAndUpdateCmd("indoor_temperature", 	$infos["indoor_temperature"]);
		$this->checkAndUpdateCmd("outdoor_temperature", $infos["outdoor_temperature"]); 
	}

	private function _sendCmdToAC($params) {
		$infos = self::getInfos(); // récup les dernieres infos
		$ip = $this->getConfiguration('ip');
		$id = $this->getConfiguration('id');
		$port = $this->getConfiguration('port');

		$script = "python3 ../../plugins/mideawifi/resources/set.py --ip $ip --id $id --port $port " . $params . " 2>&1";
		log::add("mideawifi", "debug", "script => $script");
		$set = shell_exec($script);
		log::add("mideawifi", "debug", "retour script => $set");

		return true;
	}

	/*public function setPowerState($currentState) {
		$state = !$currentState;
		self::_sendCmdToAC("--power_state $state");

		// MAJ commande info associee
		$this->checkAndUpdateCmd("power_state", $state);
	}*/


	public function allumer() {
		self::_sendCmdToAC("--power_state 1");

		// MAJ commande info associee
		$this->checkAndUpdateCmd("power_state", 1);
	}

	public function eteindre() {
		self::_sendCmdToAC("--power_state 0");

		// MAJ commande info associee
		$this->checkAndUpdateCmd("power_state", 0);
	}

	public function setEcomode() {
		self::_sendCmdToAC("--mode_eco 1");

		// MAJ commande info associee
		$this->checkAndUpdateCmd("eco_mode", 1);
		$this->checkAndUpdateCmd("turbo_mode", 0);
	}

	public function setTurbomode() {
		self::_sendCmdToAC("--mode_turbo 1");

		// MAJ commande info associee
		$this->checkAndUpdateCmd("turbo_mode", 1);
		$this->checkAndUpdateCmd("eco_mode", 0);
	}

	public function setNormalmode() {
		self::_sendCmdToAC("--mode_normal 1");

		// MAJ commandes infos associees
		$this->checkAndUpdateCmd("turbo_mode", 0);
		$this->checkAndUpdateCmd("eco_mode", 0);
	}

	public function setTemperature($consigne) {
		if($consigne < 1 || $consigne > 35)
			return;

		self::_sendCmdToAC("--target_temperature $consigne");

		// MAJ commande info associee
		$this->checkAndUpdateCmd("target_temperature", $consigne);
	}

	public function setMode($mode = 'auto') {
		if(!in_array($mode, ["auto", "cool", "dry", "heat", "fan_only"]))
			return;

		self::_sendCmdToAC("--operational_mode $mode");

		// MAJ commande info associee
		$this->checkAndUpdateCmd("operational_mode", $mode);
	}

	public function setFanspeed($speed = "Auto") {
		if(!in_array($speed, ["Auto", "High", "Medium", "Low", "Silent"]))
			return;
		
		self::_sendCmdToAC("--fan_speed $speed");

		// MAJ commande info associee
		$this->checkAndUpdateCmd("fan_speed", $speed);
	}

	public function setSwingmode($swing = "Both") {
		if(!in_array($swing, ["Off", "Vertical", "Horizontal", "Both"]))
			return;

		self::_sendCmdToAC("--swing_mode $swing");

		// MAJ commande info associee
		$this->checkAndUpdateCmd("swing_mode", $swing);
	}

	public function bipsOn() {
		self::_sendCmdToAC("--prompt_tone 1");
		
		// MAJ commande info associee
		$this->checkAndUpdateCmd("prompt_tone", 1);
	}

	public function bipsOff() {
		self::_sendCmdToAC("--prompt_tone 0");
		
		// MAJ commande info associee
		$this->checkAndUpdateCmd("prompt_tone", 0);
	}
}

class innovaCmd extends cmd {
  /*     * *************************Attributs****************************** */

  /*
  public static $_widgetPossibility = array();
  */

  /*     * ***********************Methode static*************************** */


  /*     * *********************Methode d'instance************************* */

  /*
  * Permet d'empêcher la suppression des commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
  public function dontRemoveCmd() {
    return true;
  }
  */

  // Exécution d'une commande
  public function execute($_options = array()) {
  }

  /*     * **********************Getteur Setteur*************************** */

}
