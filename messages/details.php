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
			   'view' => array(
				    'name' => 'shortcutVievMessages',
				    'uri' => 'admin/messages'
			    ),
			   'block' => array(
				    'name' => 'shortcutBlocked',
				    'uri' => 'admin/messages/block'
			    ),
			    'settings' => array(
				    'name' => 'shortcutSetting',
				    'uri' => 'admin/messages/settings',
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
			  id int(11) NOT NULL AUTO_INCREMENT,
			  host varchar(255) DEFAULT NULL,
			  port varchar(255) DEFAULT NULL,
			  user varchar(255) DEFAULT NULL,
			  pass varchar(255) DEFAULT NULL,
			  src_number varchar(255) DEFAULT NULL,
			  template text DEFAULT NULL,
			  ajax int(11) DEFAULT NULL,
			  PRIMARY KEY (id)
			) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Config for Messages';
		";
		$messages_content = "
			CREATE TABLE ".$this->db->dbprefix('messages_content')." (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  `to` varchar(255) DEFAULT NULL,
			  `from` varchar(255) DEFAULT NULL,
			  from_id varchar(255) DEFAULT NULL,
			  ip varchar(255) DEFAULT NULL,
			  message varchar(255) DEFAULT NULL,
			  date timestamp DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (id)
			) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Messages table';
		";		
		$messages_block = "
			CREATE TABLE ".$this->db->dbprefix('messages_block')." (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  user_id int(11) DEFAULT NULL,
			  reason text DEFAULT NULL,
			  PRIMARY KEY (id)
			) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Messages block table';
		";	
		
		$messages_book = "
			CREATE TABLE ".$this->db->dbprefix('messages_book')." (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  user_id int(11) DEFAULT NULL,
			  name varchar(50) DEFAULT NULL,
			  phone varchar(255) DEFAULT NULL,
			  PRIMARY KEY (id)
			) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Messages book table';
		";	
		if($this->db->query($messages_settings) 
			and $this->db->query($messages_content) 
			and $this->db->query($messages_block)
			and $this->db->query($messages_book)
			)
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('messages_settings');
		$this->dbforge->drop_table('messages_content');
		$this->dbforge->drop_table('messages_block');
		$this->dbforge->drop_table('messages_book');
		return TRUE;
	}


	public function upgrade($old_version)
	{
		return TRUE;
	}

	public function help()
	{
		return "No documentation for this module.<br />Contact the module developer for assistance.";
	}
}
