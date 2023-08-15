<?php

namespace Aryala7\Chapaar\Contracts;

interface DriverMessage
{
    public function setFrom($from);
    public function setTo($from);
    public function setContent(string $content);
    public function setTemplate($template);
    public function setTokens(array $tokens);


}
