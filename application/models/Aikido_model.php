<?php
class Aikido_model extends CI_Model 
{
	private $AIKIDO_CFG_PATH;
	private $AIKIDO_IO_PATH;
	private $AIKIDO_ACTIONS_PATH;
	
	public function __construct()
	{
		parent::__construct();
		$this->AIKIDO_CFG_PATH = FCPATH . "data/config/aikidocfg.xml";
		$this->AIKIDO_IO_PATH = FCPATH . "data/config/aikidoio.xml";
		$this->AIKIDO_ACTIONS_PATH = FCPATH . "data/config/aikidoact.xml";
	}
	
	public function get_aikido_config()
	{
		$configxml = simplexml_load_file($this->AIKIDO_CFG_PATH);
		$rows;
		$ri = 0;
		
		foreach($configxml->row as $rowxml)
		{
			$rows[$ri]['active'] = ($rowxml['active'] != "false");
			$rows[$ri]['input']['type'] = $rowxml->input['type'];
			$rows[$ri]['input']['id'] = $rowxml->input['id'];
			$rows[$ri]['output']['type'] = $rowxml->output['type'];
			$rows[$ri]['output']['id'] = $rowxml->output['id'];
			
			$ai = 0;
			foreach($rowxml->action as $actionxml)
			{
				$rows[$ri]['actions'][$ai]['id'] = $actionxml['id'];
				
				$oi = 0;
				foreach($actionxml->option as $optionxml)
				{
					$rows[$ri]['actions'][$ai]['options'][$oi] = (string)$optionxml;
					$oi++;
				}
				$ai++;
			}
			$ri++;
		}
		
		return $rows;
	}
	
	public function get_aikido_io()
	{
		$ioxml = simplexml_load_file($this->AIKIDO_IO_PATH);
		$iotypes;
		
		foreach($ioxml->iotype as $typexml)
		{
			$ti = (int)$typexml['id'];
			$iotypes[$ti]['name'] = $typexml['name'];
			
			foreach($typexml->io as $ioxml)
			{
				$ii = (int)$ioxml['id'];
				$iotypes[$ti]['ios'][$ii]['name'] = $ioxml['name'];
				$iotypes[$ti]['ios'][$ii]['path'] = $ioxml['path'];
			}
		}
		return $iotypes;
	}
	
	public function get_aikido_actions()
	{
		$actionsxml = simplexml_load_file($this->AIKIDO_ACTIONS_PATH);
		$actions;
		
		foreach($actionsxml->action as $actionxml)
		{
			$ai = (int)$actionxml['id'];
			$actions[$ai]['text'] = $actionxml['text'];
			$actions[$ai]['exec'] = $actionxml['exec'];
			
			$actions[$ai]['param'] = $this->parse_action_param($actionxml->param);
		}
		
		return $actions;
	}
	
	private function parse_action_param($paramxml)
	{
		$param['type'] = $paramxml['type'];
		if(isset($paramxml['val']))
		{
			$param['val'] = $paramxml['val'];
		}
		
		if(isset($paramxml->option))
		{
			$oi = 0;
			foreach($paramxml->option as $optionxml)
			{
				$param['options'][$oi]['text'] = $optionxml['text'];
				$param['options'][$oi]['val'] = $optionxml['val'];
				
				$param['options'][$oi]['param'] = $this->parse_action_param($optionxml->param);
				$oi++;
			}
		}
		
		if(isset($paramxml->param))
		{
			$param['param'] = $this->parse_action_param($paramxml->param);
		}
	}
}
