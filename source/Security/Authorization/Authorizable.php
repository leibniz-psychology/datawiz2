<?php

namespace App\Security\Authorization;

interface Authorizable
{
    public function getRoles(): array;

    public function promotion(): void;

    public function demotion(): void;
}
