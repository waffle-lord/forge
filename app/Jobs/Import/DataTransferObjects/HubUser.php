<?php

namespace App\Jobs\Import\DataTransferObjects;

class HubUser
{
    public function __construct(
        public int $userID,
        public string $username,
        public string $email,
        public string $password,
        public string $registrationDate,
        public ?bool $banned,
        public ?string $banReason,
        public ?string $banExpires,
        public ?string $coverPhotoHash,
        public ?string $coverPhotoExtension,
        public ?int $rankID,
        public ?string $rankTitle,
    ) {
        //
    }
}
