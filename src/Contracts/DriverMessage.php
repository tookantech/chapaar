<?php

namespace TookanTech\Chapaar\Contracts;

use TookanTech\Chapaar\Enums\Drivers;

interface DriverMessage
{
    public function getDriver(): Drivers;

    public function setFrom($from): self;

    public function getFrom();

    public function setTo(array|string $to): self;

    public function getTo();

    public function setContent(string $content): self;

    public function setTemplate($template): self;

    public function getTemplate();

    public function setTokens(array $tokens): self;
}
