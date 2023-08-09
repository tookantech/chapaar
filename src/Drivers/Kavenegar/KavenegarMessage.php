<?php

namespace Aryala7\Chapaar\Drivers\Kavenegar;

use Aryala7\Chapaar\Contracts\DriverMessage;

/*
 * @method setTemplate
 */
class KavenegarMessage implements DriverMessage
{
    /**
     * The message type.
     *
     * @var string
     */
    protected string $type = 'text';
    protected string $content;

    protected string $from;

    protected string|array $to;

    protected string $template;

    protected array $tokens = [];

    protected string $date;
    protected string $local_id;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type):self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): self
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return array|string
     */
    public function getTo(): array|string
    {
        return $this->to;
    }

    /**
     * @param array|string $to
     */
    public function setTo(array|string $to): static
    {
        if (is_array($to)) {
            $to = implode(',', $to);
        }
        $this->to = $to;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template): self
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return array
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * @param array $tokens
     */
    public function setTokens(array $tokens): self
    {
        $this->tokens = $tokens;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocalId(): ?string
    {
        return $this->local_id;
    }

    /**
     * @param string $local_id
     */
    public function setLocalId(string $local_id): self
    {
        $this->local_id = $local_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function driver()
    {
        return (new KavenegarConnector);
    }
}
