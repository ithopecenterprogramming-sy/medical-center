<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserAvatar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    /**
     * إرفاق الخاصية تلقائياً عند تحويل الموديل لـ Array أو JSON
     */
    protected $appends = [
        'url',
    ];

    /**
     * Accessor لإنشاء رابط الصورة باستخدام Storage::url()
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->file_path) {
                    return null;
                }

                // الدالة المعتمدة لإرجاع الـ URL المباشر عبر Storage
                return Storage::url($this->file_path);
            }
        );
    }

    /**
     * علاقة الصورة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}