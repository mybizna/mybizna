<?php

use Illuminate\Support\MessageBag;

// Create a new MessageBag instance.
$messageBag = new MessageBag;


function messageBag()
{
    global $messageBag;

    return $messageBag;
    //function logic
}
/*
function second_function()
{
    //function logic
}
*/
