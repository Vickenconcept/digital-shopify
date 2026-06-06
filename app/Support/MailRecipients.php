<?php

namespace App\Support;

class MailRecipients
{
    public static function admin(): string
    {
        return (string) config('mail.contact_recipient', config('mail.from.address'));
    }
}
