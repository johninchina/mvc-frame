<?php
namespace Frame\Util;

class Json
{
	protected $data;
	
	public function __construct($data, $code = 200)
	{
		$this->data = $this->stripTags($data);
	}
	
	public function stripTags($array, & $data=array())
	{
		foreach ($array as $key=>$value){
			if ($key === '@value') {
				continue;
			} elseif ($key === '@attributes') {
				$data = array_merge($data, $value);
				$this->stripTags($value, $data);
			} elseif (is_array($value)) {
				$data[$key] = array();
				$this->stripTags($value, $data[$key]);
			} else {
				$data[$key] = $value;
			}
		}
		return $data;
	}
	
	public function __toString()
	{
		return json_encode($this->data);
	}
	
	public static function toArray($jsonString)
	{
		return self::convertObject(json_decode($jsonString));
	}
	
	public static function convertObject($object)
	{
		if (is_object($object))
			$object = (Array) $object;
		if (is_array($object)) {
			foreach ($object as $key=>$value) {
				$object[$key] = self::convertObject($value);
			}
		}
		return $object;
	}
}