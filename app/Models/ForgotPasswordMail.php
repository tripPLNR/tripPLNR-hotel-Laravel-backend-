<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForgotPasswordMail extends Model
{
    use HasFactory;

    public function isExpire()
    {
        if (strtotime($this->expired_at) < strtotime(now())) {
            $this->delete();
            return true;
        }

        return false;
    }
}
