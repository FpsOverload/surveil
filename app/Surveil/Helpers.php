<?php

if (! function_exists('prefixedServerName')) {
    /**
     * Get prefixed server name.
     */
    function prefixedServerName($serverName)
    {
        return config('surveil.prefix') . $serverName;
    }
}

if (! function_exists('logPath')) {
    /**
     * Get log path.
     */
    function logPath($logName, $logType = null)
    {
        if ($logType) {
            return config('surveil.logPath') . $logName . '-' . $logType . '.log';
        }

        return config('surveil.logPath') . $logName . '.log';
    }
}
