<?php

namespace TookanTech\Chapaar\Drivers\Ghasedak;

use TookanTech\Chapaar\Contracts\DriverMessage;

class FarapayamakMessage implements DriverMessage
{
    protected string $content = '';

    protected string $from = '';

    protected string $to = '';

    protected int $template = 0;

    protected array $tokens = [];

    protected bool $flash = false;

    /**
     * @var int Set 1 to send text message and 2 to send voice message.
     */
    protected int $type = 1;

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

    public function getTo(): string
    {
        return $this->to;
    }

    public function setTo(array|string $to): static
    {
        if (is_array($to)) {
            $to = $this->getTemplate() ? implode(',', $to) : reset($to);
        }

        $this->to = $to;

        return $this;
    }

    public function getTemplate(): int
    {
        return $this->template;
    }

    public function setTemplate($template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getTokens(): string
    {
        return implode(';', $this->tokens);
    }

    public function setTokens(array $tokens): self
    {
        $this->tokens = $tokens;

        return $this;
    }

    public function isFlash(): bool
    {
        return $this->flash;
    }

    public function setFlash(bool $flash): void
    {
        $this->flash = $flash;
    }
}
