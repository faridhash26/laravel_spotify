<?php

namespace App;

enum PermissionEnum: string
{
    case DELETE_USER = "DELETE_USER";
    case ADDING_SONG = 'ADDING_SONG';
    case RETRIVERED_ALBUMS = 'RETRIVERED_ALBUMS';
    public function label(): string
    {
        return match ($this) {
            PermissionEnum::ROLE_ADMINISTRATOR => 'مشاهده‌ی لیست فراخوان‌ها',
        
        };
    }
}
