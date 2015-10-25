<?php
namespace Frame\Route;

interface RouteInterface
{
	public function match($pathinfo);
}