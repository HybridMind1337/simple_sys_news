<?php
/**
 *
 * @Project: News sys
 * @Author HybridMind <www.webocean.info>
 * @Version: 0.0.1
 * @File funcs.php
 * @Created 29.1.2021 г.
 * @License: MIT
 * @Discord: HybridMind#6095
 *
 */

/**
 * @param $location
 * @param $alert
 * @param $message
 */
function message($location, $alert, $message)
{
    $_SESSION['notifications'] = [
        'status' => 'OK',
        'message' => $message,
        'alert' => $alert
    ];

    header(sprintf("Location: %s", $location));
    exit();
}

/**
 * @return string
 */
function showMessage(): string
{
    if (isset($_SESSION['notifications'])) {
        return sprintf("<div class=\"alert alert-%s text-center\">%s</div>", $_SESSION['notifications']['alert'], $_SESSION['notifications']['message']);
    }
    return '';
}

/**
 * @param $name
 */
function sessionRemove($name)
{
    if (isset($_SESSION[$name])) {
        unset($_SESSION[$name]);
    }
}