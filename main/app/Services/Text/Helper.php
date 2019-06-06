<?php

namespace App\Services\Text;

class Helper
{
    private $html;

    public function setHtml(string $html): void
    {
        $this->html = html_entity_decode($html);
    }

    public function length(): int
    {
        return mb_strlen($this->getText());
    }

    public function getText(): string
    {
        return strip_tags($this->html);
    }

    public function getHtml(): string
    {
        return $this->html;
    }
}
