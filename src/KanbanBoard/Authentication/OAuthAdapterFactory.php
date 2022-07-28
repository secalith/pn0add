<?php

namespace App\KanbanBoard\Authentication;

class OAuthAdapterFactory extends AdapterFactory
{
    public function createAdapter($params)
    {
        $adapter = new AuthAdapter_Db();
        $adapter->doSomething();

        return $adapter;
    }
}