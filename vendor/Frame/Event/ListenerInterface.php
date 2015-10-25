<?php
namespace Frame\Event;

interface ListenerInterface
{
	public function attach(EventManager $eventManager);
}