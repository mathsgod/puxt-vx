<?php

namespace VX\Authentication;

interface UserRepositoryInterface
{


    public function authenticate(string $identity, ?string $credential): ?UserInterface;
}
