<?php
namespace Frame\Locale;

class Locale
{
	protected $path;
	
	protected $lang;
	
	public function setPath($path)
	{
		$this->path = rtrim($path, '/');
	}
	
	public function setLang($lang)
	{
		$this->lang = $lang;
	}
	
	public function getLang()
	{
		return $this->lang;
	}
	
	public function getPath()
	{
		return $this->path;
	}
	
	public function getLocale()
	{
		$file = $this->path . '/' . $this->lang . '.php';
		if (!file_exists($file)) {
			throw new \Exception(sprintf("Locale file '%s' not exist.", $file));
		}
		$locale = include $file;
		if (!is_array($locale)) {
			throw new \Exception(sprintf("Locale file '%s' must return an array.", $file));
		}
		return $locale;
	}
}