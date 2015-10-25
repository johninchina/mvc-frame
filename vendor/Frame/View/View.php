<?php
namespace Frame\View;

require_once './vendor/Smarty/Smarty.class.php';

class View extends \Smarty
{
	public function __construct($templateDir = '', $compileDir = '')
	{
		parent::__construct();
		
		if ($templateDir) {
			$this->setTemplateDir($templateDir);
		}
		if ($compileDir) {
			$this->setCompileDir($compileDir);
		}
	}
	
	// 重置smarty的fetch方法，允许template前置'/'
	public function fetch($template = null, $cache_id = null, $compile_id = null, $parent = null, $display = false, $merge_tpl_vars = true, $no_output_filter = false)
	{
		$template = ltrim($template, '/');
		return parent::fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
	}
}