<?php

namespace Jitsu;

/**
 * Utilities for introspection and reflection.
 */
class MetaUtil {

	public static function constantExists($name) {
		return defined($name);
	}

	public static function functionExists($name) {
		return function_exists($name);
	}

	public static function classExists($name) {
		return class_exists($name);
	}

	public static function hasMethod($obj, $name) {
		return method_exists($obj, $name);
	}

	public static function hasStaticMethod($class_name, $name) {
		return method_exists($class_name, $name);
	}

	public static function callFunction($name /* , $arg1, ... */) {
		$args = array_slice(func_get_args(), 1);
		return call_user_func_array($name, $args);
	}

	public static function callMethod($obj, $name /* , $arg1, ... */) {
		$args = array_slice(func_get_args(), 2);
		return call_user_func_array(array($obj, $name), $args);
	}

	public static function callStaticMethod($class_name, $name /* , $arg1, ... */) {
		$args = array_slice(func_get_args(), 2);
		return call_user_func_array(array($class_name, $name), $args);
	}

	public static function callConstructor($class_name /* , $arg1, ... */) {
		$args = array_slice(func_get_args(), 1);
		return self::apply_constructor($class_name, $args);
	}

	public static function applyFunction($name, $args) {
		return call_user_func_array($name, $args);
	}

	public static function applyMethod($obj, $name, $args) {
		return call_user_func_array(array($obj, $name), $args);
	}

	public static function applyStaticMethod($class_name, $name, $args) {
		return call_user_func_array(array($class_name, $name), $args);
	}

	public static function applyConstructor($class_name, $args) {
		return (new \ReflectionClass($class_name))->newInstanceArgs($args);
	}

	/* Get the class or type of a value as a string. */
	public static function typeName($value) {
		return is_object($value) ? get_class($value) : gettype($value);
	}

	public static function publicMethods($obj) {
		$r = new \ReflectionObject($obj);
		return $r->getMethods(\ReflectionMethod::IS_PUBLIC);
	}

	public static function registerAutoloader($callback) {
		spl_autoload_register($callback);
	}

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
