<?php
class Aikido_model extends CI_Model 
{
	private static $AIKIDO_CFG_PATH;
	private static $AIKIDO_IO_PATH;
	private static $AIKIDO_ACTIONS_PATH;
	
	static function init()
	{
		$AIKIDO_CFG_PATH = FCPATH . "data/config/aikidocfg.xml";
		$AIKIDO_IO_PATH = FCPATH . "data/config/aikidoio.xml";
		$AIKIDO_ACTIONS_PATH = FCPATH . "data/config/aikidoact.xml";
	}
	
	public function get_aikido_config()
	{
		$configxml = simplexml_load_file($AIKIDO_CFG_PATH);
		$rows;
		$ri = 0;
		
		foreach($configxml->row as $rowxml)
		{
			$rows[$ri]['active'] = (bool) $rowxml['active'];
			$rows[$ri]['input']['type'] = (int)$rowxml->input['type'];
			$rows[$ri]['input']['id'] = (int)$rowxml->input['id'];
			$rows[$ri]['output']['type'] = (int)$rowxml->output['type'];
			$rows[$ri]['output']['id'] = (int)$rowxml->output['id'];
			
			$ai = 0;
			foreach($rowxml->action as $actionxml)
			{
				$rows[$ri]['actions'][$ai]['id'] = (int)$actionxml['id'];
				
				$oi = 0;
				foreach($actionxml->option as $optionxml)
				{
					$rows[$ri]['actions'][$ai]['options'][$oi] = (string)$optionxml;
					$oi++;
				}
				$ai++;
			}
			$i++;
		}
		
		return $rows;
	}
	
	public function get_aikido_io()
	{
		$ioxml = simplexml_load_file($AIKIDO_IO_PATH);
		$iotypes;
		
		foreach($ioxml->iotype as $typexml)
		{
			$ti = (int)$typexml['id'];
			$iotypes[$ti]['name'] = (string)$typexml['name'];
			
			foreach($typexml->io as $ioxml)
			{
				$ii = (int)$ioxml['id'];
				$iotypes[$ti]['ios'][$ii]['name'] = (string)$ioxml['name'];
				$iotypes[$ti]['ios'][$ii]['path'] = (string)$ioxml['path'];
			}
		}
		return $iotypes;
	}
	
	public function get_aikido_actions()
	{
		$actionsxml = simplexml_load_file($AIKIDO_ACTIONS_PATH);
		$actions;
		
		foreach($actionsxml->action as $actionxml)
		{
			$ai = (int)$actionxml['id'];
			$actions[$ai]['text'] = (string)$actionxml['text'];
			$actions[$ai]['exec'] = (string)$actionxml['exec'];
			
			$actions[$ai]['param'] = parse_action_param($actionxml->param);
		}
		
		return $iotypes;
	}
	
	private function parse_action_param($paramxml)
	{
		$param['type'] = (string)$paramxml['type'];
		if(isset($paramxml['val']))
		{
			$param['val'] = (string)$paramxml['val'];
		}
		
		$oi = 0;
		foreach($paramxml->option as $optionxml)
		{
			$param['options'][$oi]['text'] = $optionxml['text'];
			$param['options'][$oi]['val'] = $optionxml['val'];
			
			$param['options'][$oi]['param'] = parse_action_param($optionxml->param);
			$oi++;
		}
		
		$param['param'] = parse_action_param($paramxml->param);
	}
}
