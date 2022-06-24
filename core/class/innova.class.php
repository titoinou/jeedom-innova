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
			if($eqLogicInnova->getIsEnable() == 1){
				$eqLogicInnova->updateInfos();
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

		// etat alimentation
		$infoState = $this->getCmd(null, 'power_state');
		if (!is_object($infoState)) {
			$infoState = new innovaCmd();
			$infoState->setName(__('Etat courant', __FILE__));
		}
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
		$infoTemp->setLogicalId('target_temperature');
		$infoTemp->setEqLogic_id($this->getId());
		$infoTemp->setType('info');
		$infoTemp->setTemplate('dashboard', 'tile'); //template pour le dashboard
		$infoTemp->setSubType('string');
		$infoTemp->setIsVisible(1);
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
		$infoSpeedfan->setLogicalId('fan_speed');
		$infoSpeedfan->setEqLogic_id($this->getId());
		$infoSpeedfan->setType('info');
		$infoSpeedfan->setSubType('string');
		$infoSpeedfan->setIsVisible(1);
		$infoSpeedfan->setDisplay('forceReturnLineBefore', false);
		$infoSpeedfan->save();

		// Direction du flux
		$infoSwingmode = $this->getCmd(null, 'swing_mode');
		if (!is_object($infoSwingmode)) {
			$infoSwingmode = new innovaCmd();
			$infoSwingmode->setName(__('Direction du flux', __FILE__));
		}
		$infoSwingmode->setLogicalId('swing_mode');
		$infoSwingmode->setEqLogic_id($this->getId());
		$infoSwingmode->setType('info');
		$infoSwingmode->setSubType('string');
		$infoSwingmode->setIsVisible(1);
		$infoSwingmode->setDisplay('forceReturnLineBefore', false);
		$infoSwingmode->save();

		// Mode Nuit
		$info = $this->getCmd(null, 'night_mode');
		if (!is_object($info)) {
			$info = new innovaCmd();
			$info->setName(__('Mode nuit', __FILE__));
		}
		$info->setLogicalId('night_mode');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setTemplate('dashboard', 'default'); //template pour le dashboard
		$info->setSubType('binary');
		$info->setIsVisible(0);
		$info->setIsHistorized(0);
		$info->setDisplay('forceReturnLineBefore', false);
		$info->save();

		// mode opérationnel
		$infoMode = $this->getCmd(null, 'operational_mode');
		if (!is_object($infoMode)) {
			$infoMode = new innovaCmd();
			$infoMode->setName(__('Mode courant', __FILE__));
		}
		$infoMode->setLogicalId('operational_mode');
		$infoMode->setEqLogic_id($this->getId());
		$infoMode->setType('info');
		$infoMode->setSubType('string');
		$infoMode->setIsVisible(1);
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
	
		$cmd = $this->getCmd('action', 'on');
		if (!is_object($cmd)) {
		$cmd = new innovaCmd();
		$cmd->setName(__('Allumer', __FILE__));
		}
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
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setTemperature');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('slider');
		$cmd->setConfiguration('minValue', 16);
		$cmd->setConfiguration('maxValue', 30);
		$cmd->setUnite('°C');
		$cmd->setValue($infoTemp->getId());
		$cmd->setTemplate('dashboard', 'setTemperature');
		$cmd->setTemplate('mobile', 'setTemperature');
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();

		// Changement du mode
		$cmd = $this->getCmd('action', 'setMode');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Mode', __FILE__));
		}           
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setMode');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('select');
		$cmd->setValue($infoMode->getId());
		$cmd->setConfiguration('listValue', "auto|auto;cooling|climatisation;dehumidification|déshumidificateur;heating|Chauffage;fanonly|Ventilation");
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();

		// Changement de l'orientation de la ventilation
		$cmd = $this->getCmd('action', 'setSwingmodeOn');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Activer Rotation', __FILE__));
		}           
		$cmd->setTemplate('dashboard', 'swingmode');
                $cmd->setTemplate('mobile', 'swingmode');
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setSwingmodeOn');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('other');
		//$cmd->setConfiguration('listValue', "7|Désactivé;0|Activé");
		$cmd->setValue($infoSwingmode->getId());
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();
		  
	  	$cmd = $this->getCmd('action', 'setSwingmodeOff');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Désactiver Rotation', __FILE__));
		}          
		$cmd->setTemplate('dashboard', 'swingmode');
                $cmd->setTemplate('mobile', 'swingmode');  
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setSwingmodeOff');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('other');
		//$cmd->setConfiguration('listValue', "7|Désactivé;0|Activé");
		$cmd->setValue($infoSwingmode->getId());
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();

		// Changement de la vitesse de ventilation
		$cmd = $this->getCmd('action', 'setFanspeed');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Vitesse de ventilation', __FILE__));
		}         
		$cmd->setIsVisible(1);
		$cmd->setLogicalId('setFanspeed');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('select');
		$cmd->setValue($infoSpeedfan->getId());
		$cmd->setConfiguration('listValue', "0|Automatique;3|Rapide;2|Moyenne;1|Lente");
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();

		// Mise en route du mode Nuit
		$cmd = $this->getCmd('action', 'enableNightmode');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Activer Mode Nuit', __FILE__));
		}
		$cmd->setIsVisible(0);
		$cmd->setLogicalId('enableNightmode');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();
		
		$cmd = $this->getCmd('action', 'disableNightmode');
		if (!is_object($cmd)) {
			$cmd = new innovaCmd();
			$cmd->setName(__('Désactiver Mode Nuit', __FILE__));
		}
		$cmd->setIsVisible(0);
		$cmd->setLogicalId('disableNightmode');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setDisplay('forceReturnLineBefore', true);
		$cmd->save();  
		// à la fin, on contacte directement léquipement pour récupérer les infos courantes
		$this->updateInfos();
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
		$uid = $this->getConfiguration('uid');
		$json_string = shell_exec('curl -X POST -H "X-serial: "'.$serial.' -H "X-UID: "'.strtolower($uid).' -H "X-Requested-With: XMLHttpRequest" -X POST http://innovaenergie.cloud/api/v/1/status');
		if ($json_string === false) {
		    log::add('innova', 'debug', 'Problème de lecture status');
		    return;
		}
		log::add('innova', 'debug', $json_string);
		$infos = json_decode($json_string, true);
		return $infos['RESULT'];
	}

	public function updateInfos() {
		$infos = self::getInfos();
		self::_updateInfos($infos);
	}

	private function _updateInfos($infos) {
		$this->checkAndUpdateCmd("power_state", $infos["ps"]);
		$this->checkAndUpdateCmd("target_temperature", $infos["sp"]);
		$this->checkAndUpdateCmd("operational_mode", $infos["wm"]);
		$this->checkAndUpdateCmd("fan_speed", $infos["fs"]);
		$this->checkAndUpdateCmd("swing_mode", $infos["fr"]);
		$this->checkAndUpdateCmd("night_mode", $infos["nm"]);
		$this->checkAndUpdateCmd("indoor_temperature", 	$infos["t"]);
	}

	private function _sendCmdToAC($param,$variable,$state) {
		$infos = self::getInfos();
		$serial = $this->getConfiguration('serial');
		$uid = $this->getConfiguration('uid');
		$extraData = "";
		$baseUrl = "http://innovaenergie.cloud/api/v/1/";
		if($variable == "target_temperature"){
			$extraData = "--data 'p_temp=".$state."'";
		}
		if($variable == "swing_mode"){
			$extraData = "--data 'value=".$state."'";
		}
		if($variable == "fan_speed"){
			$extraData = "--data 'value=".$state."'";
		}
		$json_string = shell_exec('curl -X POST -H "X-serial: "'.$serial.' -H "X-UID: "'.strtolower($uid).' -H "X-Requested-With: XMLHttpRequest" '.$extraData.' -X POST '.$baseUrl.$param);
		if ($json_string === false) {
		    log::add('innova', 'debug', 'Problème d\'envoi de la commande');
		    return;
		}
		log::add("innova", "debug", $variable." mise à jour à ". $state);
		$this->checkAndUpdateCmd($variable, $state);
		return true;
	}

	public function allumer() {
		self::_sendCmdToAC("power/on","power_state",1);
	}

	public function eteindre() {
		self::_sendCmdToAC("power/off","power_state",0);
	}

	public function ActiverModeNuit() {
		//self::_sendCmdToAC("--mode_eco 1");
	}
	public function DesactiverModeNuit() {
		//self::_sendCmdToAC("--mode_eco 1");
	}
	public function setTemperature($consigne) {
		if($consigne < 16 || $consigne > 35)
			return;

		self::_sendCmdToAC("set/setpoint","target_temperature",$consigne);
	}

	public function setMode($mode) {
		log::add("innova", "debug", "Mode ".$mode." sélectionné");
		if(!in_array($mode, ["heating", "cooling", "dehumidification", "fanonly", "auto"]))
			return;

		self::_sendCmdToAC("set/mode/".$mode,"operational_mode",$mode);
	}

	public function setFanspeed($speed = 0) {
		if(!in_array($speed, [0, 1, 2, 3]))
			return;
		
		/*switch($mode){
			case 0: 
			$modeName="Auto";
			break;
				
			case 1: 
			$modeName="High";
			break;
				
			case 2: 
			$modeName="Medium";
			break;
				
			case 3: 
			$modeName="Low";
			break;
				
			default:
			$modeName="Auto";
			break;
		}*/
		self::_sendCmdToAC("set/fan","fan_speed",$speed);
	}

	public function setSwingmode($swing = 7) {
		if(!in_array($swing, [7, 0]))
			return;

		self::_sendCmdToAC("set/feature/rotation","swing_mode",$swing);
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
  	$eqLogic = $this->getEqLogic(); // Récupération de l’eqlogic
	switch ($this->getLogicalId()) {                
		case 'refresh': 
			$eqLogic->updateInfos();
			break;
		case 'on':
			$eqLogic->allumer();
			break;
		case 'off':
			$eqLogic->eteindre();
			break;
		case 'setNightmode':
			$eqLogic->setNightmode();
			break;
		case 'setTemperature':
			$temp = isset($_options['text']) ? $_options['text'] : $_options['slider'];
			$eqLogic->setTemperature($temp);
			break;
		case 'setMode':
			$eqLogic->setMode($_options['select']);
			break;
		case 'setFanspeed':
			$eqLogic->setFanspeed($_options['select']);
			break;
		case 'setSwingmode':
			$eqLogic->setSwingmode($_options['select']);
			break;       
		default:
			throw new Error('This should not append!');
			log::add('innova', 'warn', 'Erreur execution commande ' . $this->getLogicalId());
			break;
	}
  }

  /*     * **********************Getteur Setteur*************************** */

}
