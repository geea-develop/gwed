<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 16/08/17
 * Time: 17:45
 */

function isDebugMode() {
    return config('app.debug');
}

/**
 * @param $string
 * @return string
 */
function showIfDebug($string) {
    return isDebugMode() ? (string)$string : "";
}

function getGuestTypes() {
    return ['family', 'work', 'friend', 'other'];
}

function getPartners() {
    return ['groom', 'bride'];
}

function getEventNames() {
    return ['Rehearsal', 'Fitting', 'Food tasting', 'Cake tasting', 'Photos'];
}