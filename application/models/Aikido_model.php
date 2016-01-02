<?php
class Aikido_model extends CI_Model 
{
	private static $AIKIDO_CFG_PATH;
	private static $AIKIDO_IO_PATH;
	private static $AIKIDO_ACTIONS_PATH;
	
	static function init()
	{
		$AIKIDO_CFG_PATH = FCPATH . "data/aikidocfg.xml";
		$AIKIDO_IO_PATH = FCPATH . "data/aikidoio.xml";
		$AIKIDO_ACTIONS_PATH = FCPATH . "data/aikidoact.xml";
	}
	
	public function get_aikido_config()
	{
		$configxml = simplexml_load_file($AIKIDO_CFG_PATH);
		return $configxml;
	}
	
	public function get_aikido_io()
	{
		$ioxml = simplexml_load_file($AIKIDO_IO_PATH);
	}
	
	public function get_aikido_actions()
	{
		$actionsxml = simplexml_load_file($AIKIDO_ACTIONS_PATH);
	}
}
