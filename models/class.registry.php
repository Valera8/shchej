<?php
defined('_RCHE') or die('Restricted access');
/*Хранилище настроек. Класс реализует интерфейс ArrayAccess, благодаря чему с объектом этого класса можно работать как с обычным массивом. Комменты из https://myrusakov.ru/php-arrayaccess-interface.html*/
class Registry implements ArrayAccess{
	//Массив, в котором хранятся настройки. Внутренний массив к которому мы создаем интерфейс доступа
	private $vars = [];
	// метод для добавления настройки в хранилище
	function set($key, $var) {
		if (isset($this->vars[$key]) == true) {
			throw new Exception('Unable to set var `' . $key . '`. Already set.');
		}
        $this->vars[$key] = $var;
        return true;
	}
	// метод для получения настройки из хранилища
	function get($key) {
		if (isset($this->vars[$key]) == false) {
			return null;
		}
        return $this->vars[$key];
	}
/* ---! в этом методе я исправил remove($var) на remove($key)-----------! */
	function remove($key) {
		unset($this->vars[$key]);
	}
	/*Интерфейс ArrayAccess содержит четыре метода:*/
	/*проверка существования значения в массиве по указанному ключу*/
	function offsetExists($offset) {
		return isset($this->vars[$offset]);
	}
	/*для получения значения из массива по ключу*/
	function offsetGet($offset) {
		return $this->get($offset);
	}
	/*для установки значения в массиве по ключу*/
	function offsetSet($offset, $value) {
		$this->set($offset, $value);
	}
	/*удаление значения из массива по ключу*/
	function offsetUnset($offset) {
		unset($this->vars[$offset]);
	}
}
