<?php

if (! function_exists('settings')) {
	/**
	 * Get / set the specified settings value.
	 *
	 * If an array is passed as the key, we will assume you want to set an array of values.
	 *
	 * @param  array|string  $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	function settings($key = null, $default = null) {
		if (is_null($key)) {
			return app('anlutro\LaravelSettings\SettingStore');
		}

		return app('anlutro\LaravelSettings\SettingStore')->get($key, $default);
	}
}

if (! function_exists('id_picture')) {
	function id_picture($picture) {
		return $picture ? url('upload/identifications/' . $picture) : url('assets/img/profile.png');
	}
}

if (! function_exists('person_photo')) {
	function person_photo($photo) {
		return $photo ? url('upload/persons/' . $photo) : url('assets/img/profile.png');
	}
}

if (! function_exists('upload_image_url')) {
	function upload_image_url($image, $module) {
		return $image ? url("upload/$module/$image") : url('assets/img/profile.png');
	}
}

if (! function_exists('get_property')) {
	function get_property($object, $property, $default='') {
		if (is_object($object)) {
			return $object->$property;
		}
		return $default;
	}
}

if (! function_exists('make_smart_redirect')) {
    function make_smart_redirect($url, $name, $toRoute = null, $query = null, $ttl = null) {
        $suffix = "__rdt[name]=$name";
        if (! $toRoute) {
            $toRoute = Route::currentRouteName();
            $query = Input::all();
        }
        $suffix .= "&__rdt[route]=$toRoute";
        if ($query) {
            if (is_array($query)) {
                foreach ($query as $k => $v) {
                    $suffix .= "&__rdt[query][$k]=$v";
                }
            } else {
                $suffix .= "&__rdt[query]=$query";
            }
        }
        if ($ttl && $ttl > 0) {
            $suffix .= "&__rdt[ttl]=$ttl";
        }
        if (strrpos($url, '#') === false) {
            $url .= (strrpos($url, '?') === false ? '?' : '&') . $suffix;
        } else {
            $arr = explode('#', $url);
            $url = $arr[0] . (strrpos($arr[0], '?') === false ? '?' : '&') . $suffix . '#' . $arr[1];
        }
        return $url;
    }
}

if (! function_exists('traverse_tree_nodes')) {
    function traverse_tree_nodes($nodes, $defaultNodes = [], $depth = false, $prefix = '‒‒') {
        $items = $defaultNodes ?: [];

        foreach ($nodes as $node) {
            $items[$node->id] = ($depth ? str_repeat($prefix, $node->depth) : $prefix).$node->name;
            $items = $items + traverse_tree_nodes($node->children, null, $depth, $depth ? $prefix : $prefix.$prefix);
        }

        return $items;
    }
}

if (! function_exists('getHumanReadableSize') ) {
    function getHumanReadableSize($sizeInBytes) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        if ($sizeInBytes === 0) {
            return '0 '.$units[1];
        }
        for ($i = 0; $sizeInBytes > 1024; ++$i) {
            $sizeInBytes /= 1024;
        }

        return round($sizeInBytes, 2).' '.$units[$i];
    }
}