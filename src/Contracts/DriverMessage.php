<?php

namespace Aryala7\Chapaar\Contracts;

interface DriverMessage
{
    public function setFrom($from);

    public function getFrom();

    public function setTo($to);

    public function getTo();

    public function setContent(string $content);

    public function setTemplate($template);

    public function getTemplate();

    public function setTokens(array $tokens);
}
