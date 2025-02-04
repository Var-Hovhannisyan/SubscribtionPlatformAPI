<?php

namespace App\Interfaces;

interface PostSubscriberInterface
{
    public function insert($postId, $subscriberId);
}
