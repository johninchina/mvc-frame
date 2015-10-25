<?php
namespace Frame\View;

class ViewModel
{
	protected $template;
	
	protected $variables;
	
	public function __construct($template = '', $variables = array())
	{
		$this->setTemplate($template);
		$this->setVariables($variables);
	}
	
	public function setTemplate($template)
	{
		$this->template = $template;
	}
	
	public function getTemplate()
	{
		return $this->template;
	}
	
	public function setVariables($variables)
	{
		$this->variables = $variables;
	}
	
	public function getVariables()
	{
		return $this->variables;
	}
}