<?php

/* tests\utilities\functions.php */

function factory_create($class, $attributes = [], $times = null) {
    return factory($class, $times)->create($attributes);
}

function factory_make($class, $attributes = [], $times = null) {
    return factory($class, $times)->make($attributes);
}

function factory_raw($class, $attributes = [], $times = null) {
    return factory($class, $times)->raw($attributes);
}
