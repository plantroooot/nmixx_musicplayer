<?php

class DBConnection {

	var $hostname;
	var $username;
	var $password;
	var $database;

	function __construct($target = "default") {
		// 기본 DB접속
		
		$db['default']['hostname'] = 'localhost';
		$db['default']['username'] = 'root';
		$db['default']['password'] = 'dksktkd12#';
		$db['default']['database'] = 'mixxplayer';

		$this->hostname = $db[$target]['hostname'];
		$this->username = $db[$target]['username'];
		$this->password = $db[$target]['password'];
		$this->database = $db[$target]['database'];
	}

	function getConnection() {

		$conn = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
		mysqli_select_db($conn, $this->database) or die('DB연결 실패');
//		if ($this->hostname !=
		//mysqli_query("SET NAMES 'utf8'");
		mysqli_query($conn,'set names utf8');
		return $conn;
	}

}
?>