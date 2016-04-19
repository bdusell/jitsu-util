<?php

/**
 * General utility functions.
 */

namespace Jitsu;

/**
 * A collection of general-purpose static methods.
 */
class Util {

	/**
	 * Get the string representation of a value.
	 *
	 * Returns the result of the built-in `print_r` function.
	 *
	 * @param mixed $var
	 * @return string
	 */
	public static function str($var) {
		return print_r($var, true);
	}

	/**
	 * Get a PHP-code representation of a value as a string.
	 *
	 * Returns the result of the built-in `var_export` function.
	 *
	 * @param mixed $var
	 * @return string
	 */
	public static function repr($var) {
		return var_export($var, true);
	}

	/**
	 * Print values to *stdout*. Intended for debugging.
	 *
	 * Prints all of its arguments to **stdout** as PHP code using
	 * `var_export`, separated by spaces and terminated with a newline.
	 * Returns the last argument, which makes it easy to insert a call
	 * into the middle of an expression to print an intermediate value.
	 *
	 * @param mixed $args,...
	 * @return mixed The last argument.
	 */
	public static function p(/* $args... */) {
		$first = true;
		foreach(func_get_args() as $arg) {
			if(!$first) echo ' ';
			var_export($arg);
			$first = false;
		}
		echo "\n";
		if(func_num_args() > 0) {
			return func_get_arg(func_num_args() - 1);
		}
	}

	/**
	 * Transclude a PHP file in a private variable scope.
	 *
	 * This `include`s a file within its own variable scope, which may
	 * optionally be populated with an array of values.
	 *
	 * @param string $filename
	 * @param array|null $variables
	 */
	public static function template(/* $filename, $variables */) {
		if(func_num_args() > 1 && is_array(func_get_arg(1))) extract(func_get_arg(1));
		include func_get_arg(0);
	}

	/**
	 * Tell whether an array or object has a certain key or property.
	 *
	 * Unlike `isset`, this works even when the value in question is
	 * `null`.
	 *
	 * @param array|object $arr_or_obj
	 * @param int|string $key_or_name
	 * @return bool
	 */
	public static function has($arr_or_obj, $key_or_name) {
		if(is_array($arr_or_obj)) {
			return self::hasKey($arr_or_obj, $key_or_name);
		} else {
			return self::hasProp($arr_or_obj, $key_or_name);
		}
	}

	/**
	 * Get the value under a key in an array or a property in an object.
	 *
	 * Optionally provide a default value to use if the key or property
	 * does not exist.
	 *
	 * @param array|object $arr_or_obj
	 * @param int|string $key_or_name
	 * @return mixed
	 */
	public static function get($arr_or_obj, $key_or_name) {
		if(is_array($arr_or_obj)) {
			return self::getKey($arr_or_obj, $key_or_name);
		} else {
			return self::getProp($arr_or_obj, $key_or_name);
		}
	}

	/**
	 * Set a key in an array or a property in an object to some value.
	 *
	 * @param array|object $arr_or_obj
	 * @param int|string $key_or_name
	 * @param mixed $value
	 */
	public static function set($arr_or_obj, $key_or_name, $value) {
		if(is_array($arr_or_obj)) {
			$arr_or_obj[$key_or_name] = $value;
		} else {
			$arr_or_obj->$key_or_name = $value;
		}
	}

	/**
	 * Get a reference to the value under a key in an array or a property
	 * in an object.
	 *
	 * Sets the value to a default value if it does not exist yet.
	 *
	 * @param array|object $arr_or_obj
	 * @param int|string $key_or_name
	 * @param mixed $default
	 */
	public static function &getRef(&$arr_or_obj, $key_or_name, $default) {
		if(is_array($arr_or_obj)) {
			if(!self::hasKey($arr_or_obj, $key_or_name)) {
				$arr_or_obj[$key_or_name] = $default;
			}
			return $arr_or_obj[$key_or_name];
		} else {
			if(!self::hasProp($arr_or_obj, $key_or_name)) {
				$arr_or_obj->$key_or_name = $default;
			}
			return $arr_or_obj->$key_or_name;
		}
	}

	/**
	 * Determine whether an array contains a certain key.
	 *
	 * Works even if the value is `null`.
	 *
	 * @param array $array
	 * @param int|string $key
	 * @return bool
	 */
	public static function hasKey($array, $key) {
		return array_key_exists($key, $array);
	}

	/**
	 * Get a value from an array, or a default value if the key is not
	 * present.
	 *
	 * @param array $array
	 * @param int|string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public static function getKey($array, $key, $default = null) {
		if(array_key_exists($key, $array)) {
			return $array[$key];
		} else {
			return $default;
		}
	}

	/**
	 * Determine whether an object has a property with a certain name.
	 *
	 * @param object $obj
	 * @param string $name
	 * @return bool
	 */
	public static function hasProp($obj, $name) {
		return property_exists($obj, $name);
	}

	/**
	 * Get the value of a property in an object or a default value if the
	 * object does not have a property by that name.
	 *
	 * @param object $obj
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public static function getProp($obj, $name, $default = null) {
		if(property_exists($obj, $name)) {
			return $obj->$name;
		} else {
			return $default;
		}
	}
}
