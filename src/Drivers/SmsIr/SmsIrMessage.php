<?php

namespace Aryala7\Chapaar\Drivers\SmsIr;

use Aryala7\Chapaar\Contracts\DriverMessage;

class SmsIrMessage implements DriverMessage
{
    protected string $content = '';

    protected string $from = '';

    protected array|string $to = '';

    protected int $template = 0;

    protected array $tokens = [];

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function setFrom($from): self
    {
        $this->from = $from;

        return $this;
    }

    public function getTo(): array|string
    {
        return $this->to;
    }

    public function setTo($to): static
    {
        $this->to = $to;

        return $this;
    }

    public function getTemplate(): int
    {
        return (int) $this->template;
    }

    public function setTemplate($template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getTokens(): array
    {
        return $this->tokens;
    }

    public function setTokens(array $tokens): self
    {
        $this->tokens = $tokens;

        return $this;
    }
}
