<?php
class SimpleSSH {
	private $connection;
	private $host;

	/**
	 * [__construct create connection to remote host]
	 * @param string $host user hostname/ip
	 * @param string $port host port
	 * @param string $user ssh username
	 * @param string $pass ssh password
	 */
	function __construct($host, $port, $user, $pass)
	{
		$this->host = $host;
		$this->connection = ssh2_connect($host, $port);
		ssh2_auth_password($this->connection, $user, $pass);
	}

	/**
	 * [execute execute comand on connected machine]
	 * @param  string   $command ssh standard commands
	 * @return string[]          [description]
	 */
	function	execute($command){
		$stream = ssh2_exec($this->connection, $command);
		stream_set_blocking($stream, true);
		$output = stream_get_contents($stream);
		$output = array_filter(explode("\n", $output));
		return $output;
	}

	/**
	 * [disconect description]
	 * @return string [description]
	 */
	function	disconect(){
		ssh2_exec($this->connection, "exit");
		return "disconected from " . $this->host;
	}
}
