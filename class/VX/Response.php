<?php

namespace VX;

class Response
{
    public function page(string $title, string $context): array
    {
    }

    /**
     * code
     * 200 OK,
     * 201 Created,
     * 202 Accepted,
     * 204 No Content,
     * 205 Reset Content,
     * 206 Partial Content,
     * 400 Bad Request,
     * 401 Unauthorized,
     * 403 Forbidden,
     * 404 Not Found
     */
    public function code(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header("location: " . $url);
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
