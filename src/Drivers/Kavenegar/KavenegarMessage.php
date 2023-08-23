<?php

namespace TookanTech\Chapaar\Drivers\Kavenegar;

use TookanTech\Chapaar\Contracts\DriverMessage;

/*
 * @method setTemplate
 */
class KavenegarMessage implements DriverMessage
{
    /**
     * The message type.
     */
    protected string $type = 'text';

    protected string $content;

    protected string $from = '';

    protected string $to = '';

    protected string $template = '';

    protected array $tokens = [];

    protected string $date = '';

    protected string $local_id = '';

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

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
        if (is_array($to)) {
            $to = implode(',', $to);
        }
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

    public function getLocalId(): ?string
    {
        return $this->local_id;
    }

    public function setLocalId(string $local_id): self
    {
        $this->local_id = $local_id;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }
}
