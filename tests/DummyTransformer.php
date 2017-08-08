<?php

namespace IsaacKenEarl\LaravelApi;

use League\Fractal\TransformerAbstract;

class DummyTransformer extends TransformerAbstract
{

    /**
     * @param \stdClass $object
     * @return array
     */
    public function transform(\stdClass $object)
    {
//        dd(['key' => '123']);
        return (array) json_decode(json_encode($object));
    }
}