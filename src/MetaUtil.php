<?php

namespace Jitsu;

/**
 * Utilities for introspection and reflection.
 */
class MetaUtil {

	/**
	 * Determine whether a constant by a certain name has been defined.
	 *
	 * @param string $name
	 * @return bool
	 */
	public static function constantExists($name) {
		return defined($name);
	}

	/**
	 * Determine whether a function by a certain name has been defined.
	 *
	 * @param string $name
	 * @return bool
	 */
	public static function functionExists($name) {
		return function_exists($name);
	}

	/**
	 * Determine whether a class by a certain name has been defined.
	 *
	 * @param string $name
	 * @return bool
	 */
	public static function classExists($name) {
		return class_exists($name);
	}

	/**
	 * Determine whether an object has a method by a certain name.
	 *
	 * @param object $obj
	 * @param string $name
	 * @return bool
	 */
	public static function hasMethod($obj, $name) {
		return method_exists($obj, $name);
	}

	/**
	 * Determine whether a class has a static method by a certain name.
	 *
	 * @param string $class_name
	 * @param string $name
	 * @return bool
	 */
	public static function hasStaticMethod($class_name, $name) {
		return method_exists($class_name, $name);
	}

	/**
	 * Call a function by a certain name.
	 *
	 * @param string $name
	 * @param mixed $args,... Arguments to the function.
	 * @return mixed Whatever is returned by the called function.
	 */
	public static function callFunction($name /*, $args... */) {
		$args = array_slice(func_get_args(), 1);
		return call_user_func_array($name, $args);
	}

	/**
	 * Call a method by a certain name on an object.
	 *
	 * @param object $obj
	 * @param string $name
	 * @param mixed $args,... Arguments to the method.
	 * @return mixed Whatever is returned by the called method.
	 */
	public static function callMethod($obj, $name /*, $args... */) {
		$args = array_slice(func_get_args(), 2);
		return call_user_func_array(array($obj, $name), $args);
	}

	/**
	 * Call a static method by a certain name from a certain class.
	 *
	 * @param string $class_name
	 * @param string $name
	 * @param mixed $args,... Arguments to the method.
	 * @return mixed Whatever is returned by the called method.
	 */
	public static function callStaticMethod($class_name, $name /*, $args... */) {
		$args = array_slice(func_get_args(), 2);
		return call_user_func_array(array($class_name, $name), $args);
	}

	/**
	 * Call the constructor of a class by a certain name.
	 *
	 * @param string $class_name
	 * @param mixed $args,... Arguments to the constructor.
	 * @return object The newly constructed object, as if `new` had been
	 *                used.
	 */
	public static function callConstructor($class_name /*, $args... */) {
		$args = array_slice(func_get_args(), 1);
		return self::apply_constructor($class_name, $args);
	}

	/**
	 * Call a function with an array of arguments.
	 *
	 * @param string $name
	 * @param array $args
	 * @return mixed
	 */
	public static function applyFunction($name, $args) {
		return call_user_func_array($name, $args);
	}

	/**
	 * Call a method on an object with an array of arguments.
	 *
	 * @param object $obj
	 * @param string $name
	 * @param array $args
	 * @return mixed
	 */
	public static function applyMethod($obj, $name, $args) {
		return call_user_func_array(array($obj, $name), $args);
	}

	/**
	 * Call a static method with an array of arguments.
	 *
	 * @param string $class_name
	 * @param string $name
	 * @param array $args
	 * @return mixed
	 */
	public static function applyStaticMethod($class_name, $name, $args) {
		return call_user_func_array(array($class_name, $name), $args);
	}

	/**
	 * Call a class constructor with an array of arguments.
	 *
	 * @param string $class_name
	 * @param array $args
	 * @return object The newly constructed object, as if `new` had been
	 *                used.
	 */
	public static function applyConstructor($class_name, $args) {
		return (new \ReflectionClass($class_name))->newInstanceArgs($args);
	}

	/**
	 * Get the class or type of a value as a string.
	 *
	 * @param mixed $value
	 * @return string
	 */
	public static function typeName($value) {
		return is_object($value) ? get_class($value) : gettype($value);
	}

	/**
	 * Enumerate all of the public methods of an object.
	 *
	 * @param object $obj
	 * @return \ReflectionMethod[]
	 */
	public static function publicMethods($obj) {
		$r = new \ReflectionObject($obj);
		return $r->getMethods(\ReflectionMethod::IS_PUBLIC);
	}

	/**
	 * Add a callback to the chain of autoloader callbacks.
	 *
	 * Not necessary if Composer is used.
	 *
	 * @param callable $callback
	 */
	public static function registerAutoloader($callback) {
		spl_autoload_register($callback);
	}

	/**
	 * Register an autoloader which maps a namespace to one or more
	 * filesystem directories.
	 *
	 * Not necessary if Composer is used.
	 *
	 * @param string $namespace
	 * @param string|string[] $dirs
	 */
	public static function autoloadNamespace($namespace, $dirs) {
		$trimmed = trim($namespace, '\\');
		$prefix = strlen($trimmed) === 0 ? '' : $trimmed . '\\';
		$dirs = (array) $dirs;
		foreach($dirs as &$dir) {
			$dir = rtrim($dir, '/') . '/';
		}
		spl_autoload_register(function($class) use ($prefix, $dirs) {
			if(($suffix = StringUtil::remove_prefix($class, $prefix)) !== null) {
				$path = str_replace('\\', '/', $suffix) . '.php';
				foreach($dirs as $dir) {
					$filename = $dir . $path;
					if(is_file($filename)) {
						require $filename;
						return;
					}
				}
			}
		});
	}
}
