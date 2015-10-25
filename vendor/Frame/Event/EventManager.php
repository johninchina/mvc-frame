<?php
namespace Frame\Event;

class EventManager
{
	protected $listeners = array();
	
	protected $sortedListeners = array();
	
	public function attach($eventName, $callback = null, $priority = 0)
	{
		if ($eventName instanceof ListenerInterface) {
			return $eventName->attach($this);
		}
		if (null === $callback) {
			throw new \Exception(sprintf("Event '%s''s callback is needed.", $eventName));
		}
		$this->listeners[$eventName][$priority][] = $callback;
		unset($this->sortedListeners[$eventName]);
	}
	
	public function detach($eventName, $callback)
	{
		if (!isset($this->listeners[$eventName])) {
			return;
		}
		if (null === $callback) {
			throw new \Exception(sprintf("Event '%s''s callback is needed.", $eventName));
		}
		foreach ($this->listeners[$eventName] as $priority=>$listeners) {
			if (false !== ($key = array_search($callback, $listeners, true))) {
				unset($this->listeners[$eventName][$priority][$key], $this->sortedListeners[$eventName]);
			}
		}
	}
	
	public function trigger($eventName, Event $event = null)
	{
		if (null === $event) {
			$event = new Event();
		}
		$event->stop(false);
		
		if (!isset($this->listeners[$eventName])) {
			return $event;
		}
		$listeners = $this->getListeners($eventName);
		foreach ($listeners as $listener) {
			$result[] = call_user_func($listener, $event);
			if ($event->isStopped()) {
				break;
			}
		}
		return array_pop($result);
	}
	
	public function getListeners($eventName = null)
	{
		if (null !== $eventName) {
			if (!isset($this->sortedListeners[$eventName])) {
				$this->sortListeners($eventName);
			}
			return $this->sortedListeners[$eventName];
		}
		foreach ($this->listeners as $eventName=>$listener) {
			if (!isset($this->sortedListeners[$eventName])) {
				$this->sortListeners($eventName);
			}
		}
		return array_filter($this->sortedListeners);
	}
	
	protected function sortListeners($eventName)
	{
		$this->sortedListeners[$eventName] = array();
		if (isset($this->listeners[$eventName])) {
			ksort($this->listeners[$eventName]);
			$this->sortedListeners[$eventName] = call_user_func_array('array_merge', $this->listeners[$eventName]);
		}
	}
}