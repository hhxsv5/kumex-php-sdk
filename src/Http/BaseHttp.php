<?php

namespace KuMEX\SDK\Http;

abstract class BaseHttp implements IHttp
{
    protected $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }
}