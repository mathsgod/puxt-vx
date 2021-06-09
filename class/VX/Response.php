<?php

namespace VX;

class Response
{
    public function page(string $title, string $context): array
    {
    }

    public function redirect(string $url): array
    {
        return [
            "type" => "redirect",
            "body" => $url
        ];
    }

    public function notify(string $title, string $message): array
    {
        return [
            "type" => "notify",
            "body" => [
                "title" => $title,
                "message" => $message
            ]
        ];
    }

    public function message($body): array
    {
        return [
            "type" => "message",
            "body" => $body
        ];
    }
}
