<?php

/*
 * Copyright (C) 2013 Mailgun
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Mailgun\Model\Ip;

use Mailgun\Model\ApiResponse;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class UpdateResponse implements ApiResponse
{
    /**
     * @var string
     */
    private $message;

    private function __construct()
    {
    }

    public static function create(array $data)
    {
        $model = new self();
        $model->message = $data['message'];

        return $model;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
