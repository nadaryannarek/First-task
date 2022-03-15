<?php

function round_up ( $value, $precision ): string
{
    $pow = pow ( 10, $precision );
    return number_format(( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow, 2 ,'.', '');
}
