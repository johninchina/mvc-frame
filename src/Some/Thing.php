<?php
namespace Some;

class Thing
{
	// 这个目录存放自定义的组件类，然后在config.php里指定即可使用
	// 例如：在./src下新建Route目录，在./src/Route目录下创建My类Route\My
	// 然后在config.php的route段添加
	// ...
	//	'route_class'	=> 'Route\My',
	// ...
	// 这样就可使用自定义的route代替系统内置的route
	// 其他的组件也一样，比如event_manager、request、response、locale等
	// 同时，也可以添加自定义的类
	// 比如Listener\My、Service\MyFactory等
	// 当然，有些类需要实现某些接口，或者实现抽象类的抽象方法
}