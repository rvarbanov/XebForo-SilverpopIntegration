<?php

class SilverpopIntegration_Option {
    private static $prefix = 'silverpop';

    public static function get($key) {
        return XenForo_Application::get('options')->get(static::$prefix . $key);
    }
}
