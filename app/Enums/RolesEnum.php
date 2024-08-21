<?php

namespace App;

enum RolesEnum: string
{
    case ADMINISTRATOR = "ADMINISTRATOR";
    case SIMPLE_USER = "SIMPLE_USER";
    case ARTIST = "ARTIST";

    public function rank(): int
    {
        return match ($this) {
            self::ADMINISTRATOR => 1,
            self::SIMPLE_USER => 2,
            self::ARTIST => 3,
        };
    }
    public function label(): string
    {
        return match ($this) {
            PermissionEnum::ADMINISTRATOR => 'سوپر ادمین',
            PermissionEnum::SIMPLE_USER => 'یوزر عادی ',
            PermissionEnum::ARTIST => ' آرتیست ',
        
        };
    }
}
