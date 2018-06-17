<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Message Key
    |--------------------------------------------------------------------------
    |
    | When your api sends on a response, what do you want the key to be?
    | Api::respondWithMessage('the default key is message')
    | { "message" : "the default key is message" }
    |
    */

    'message_key' => 'message',

    /*
    |--------------------------------------------------------------------------
    | Error message Key
    |--------------------------------------------------------------------------
    |
    | When your api sends on an error message, what do you want the key to be?
    | It can be the same as with a message, but some want to customize
    | { "error" : "something bad happened so here is your error" }
    |
    */

    'error_message_key' => 'error',

    /*
    |--------------------------------------------------------------------------
    | Error message Key
    |--------------------------------------------------------------------------
    |
    | Sometimes you may want to send an array or errors with your error message.
    | Customize the key for this array here, the default is "errors".
    | But some people prefer "data" or something else generic.
    |
    */

    'error_data_key' => 'errors' // NOTE: cannot be the same key as error_message_key or your data will not appear.
];