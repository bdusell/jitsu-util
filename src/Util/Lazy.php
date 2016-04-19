<?php

namespace Jitsu\Util;

/**
 * A base class for defining lazily-instantiated classes.
 *
 * Lazy objects behave just like those of another class, except they are not
 * instantiated until the first time one of their members is accessed.
 *
 * Subclass this class and define `const T` in the subclass as the name of the
 * proxied class. The subclass is the lazy class.
 */
class Lazy {

	private $instance = null;
	private $args;

	public function __construct() {
		$this->args = func_get_args();
	}

	public function __call($name, $args) {
		$this->instantiate();
		return call_user_func_array(array($this->instance, $name), $args);
	}

	public function __get($name) {
		$this->instantiate();
		return $this->instance->$name;
	}

	public function __set($name, $value) {
		$this->instantiate();
		$this->instance->$name = $value;
	}

	public function __isset($name) {
		$this->instantiate();
		return isset($this->instance->$name);
	}

	public function __unset($name) {
		$this->instantiate();
		unset($this->instance->$name);
	}

	public function __toString() {
		$this->instantiate();
		return (string) $this->instance;
	}

	public function __clone() {
		$this->instantiate();
		return clone $this->instance;
	}

	public function __invoke() {
		$this->instantiate();
		return call_user_func_array($this->instance, func_get_args());
	}

	public function __debugInfo() {
		$this->instantiate();
		return $this->instance->__debugInfo();
	}

	public function __sleep() {
		$this->instantiate();
		return $this->instance->__sleep();
	}

	public function __wakeup() {
		$this->instantiate();
		return $this->instance->__wakeup();
	}

	/**
	 * Instantiate the underlying object without needing to reference one
	 * of its members.
	 */
	public function instantiate() {
		if($this->instance === null) {
			$class = constant(get_called_class() . '::T');
			$this->instance = \Jitsu\MetaUtil::applyConstructor($class, $this->args);
			$this->args = null;
		}
	}

	/**
	 * Tell whether the underlying object has been instantiated.
	 *
	 * @return bool
	 */
	public function isInstantiated() {
		return $this->instance !== null;
	}
}
