<?php

namespace Aryala7\Chapaar\Drivers\Ghasedak;

use Aryala7\Chapaar\Contracts\DriverMessage;

class GhasedakMessage implements DriverMessage
{
    protected string $content;

    protected string $from;

    protected array|string $to;

    protected string $template;

    protected string $check_id;

    protected array $tokens = [];

    protected string $date;

    /**
     * @var int Set 1 to send text message and 2 to send voice message.
     */
    protected int $type;

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

    public function getTemplate(): string
    {
        return $this->template;
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

    public function getCheckId(): string
    {
        return $this->check_id;
    }

    public function setCheckId(string $check_id): void
    {
        $this->check_id = $check_id;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }
}