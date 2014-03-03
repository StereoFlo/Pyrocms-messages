<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Messages extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Messages',
				'ru' => 'Сообщения',
			),
			'description' => array(
				'en' => 'You can use this module for send messages on the SMPP protocol.',
				'ru' => 'Вы можете использовать этот модуль для отправки сообщений по протоколу SMPP.',
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'utilities',
			'sections' => array(
			    'settings' => array(
				    'name' => 'shortcutSetting',
				    'uri' => 'admin/messages',
				),
				'messages' => array(
				    'name' => 'shortcutVievMessages',
				    'uri' => 'admin/messages/view'
				),
			),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('messages_settings');
		$this->dbforge->drop_table('messages_content');
		
		$messages_settings = "
			CREATE TABLE ".$this->db->dbprefix('messages_settings')." (
			`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`host` VARCHAR(255) NULL ,
			`port` VARCHAR(255) NULL ,
			`user` VARCHAR(255) NULL ,
			`pass` VARCHAR(255) NULL ,
			`src_number` VARCHAR( 255 ) NULL,
			`template` TEXT NULL
			) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Config for Messages';
		";
		$messages_content = "
			CREATE TABLE ".$this->db->dbprefix('messages_content')." (
			`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`to` VARCHAR(255) NULL ,
			`from` VARCHAR(255) NULL ,
			`from_id` VARCHAR(255) NULL ,
			`ip` VARCHAR(255) NULL ,
			`message` VARCHAR(255) NULL ,
			`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
			) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Messages table';
		";		
		if($this->db->query($messages_settings) and $this->db->query($messages_content)){
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('messages_settings');
		$this->dbforge->drop_table('messages_content');
		return TRUE;
	}


	public function upgrade($old_version)
	{
		return TRUE;
	}

	public function help()
	{
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
