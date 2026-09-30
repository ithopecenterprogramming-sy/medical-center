<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            static::logAudit($model, 'created', null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $oldValues = array_intersect_key($model->getOriginal(), $model->getChanges());
            $newValues = $model->getChanges();

            unset($oldValues['updated_at'], $newValues['updated_at']);

            if (!empty($newValues)) {
                static::logAudit($model, 'updated', $oldValues, $newValues);
            }
        });

        // تم التغيير من deleted إلى deleting لالتقاط الحدث والبيانات قبل الحذف والمسح النهائي
        static::deleting(function ($model) {
            $action = method_exists($model, 'isForceDeleting') && $model->isForceDeleting() ? 'force_deleted' : 'deleted';
            static::logAudit($model, $action, $model->getAttributes(), null);
        });

        if (method_exists(static::class, 'restored')) {
            static::restored(function ($model) {
                static::logAudit($model, 'restored', null, $model->getAttributes());
            });
        }
    }

    protected static function logAudit($model, string $action, ?array $oldValues = null, ?array $newValues = null): void
    {
        $user = Auth::user();
        $userName = $user?->name ?? 'النظام';
        $modelName = static::getModelDisplayName(get_class($model));

        AuditLog::create([
            'user_id'        => $user?->id,
            'name'           => $userName,
            'notes'          => static::generateNotes($userName, $action, $modelName, $model),
            'action'         => $action,
            'auditable_type' => get_class($model),
            'auditable_id'   => $model->getKey(),
            'route'          => request()->path(),
            'method'         => request()->method(),
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
            'old_values'     => $oldValues,
            'new_values'     => $newValues,
            'created_at'     => now(),
        ]);
    }

    protected static function generateNotes(string $userName, string $action, string $modelName, $model): string
    {
        $targetName = $model->name ?? $model->title ?? "رقم #{$model->getKey()}";

        return match ($action) {
            'created'       => "قام {$userName} بإنشاء {$modelName} جديد: ({$targetName}).",
            'updated'       => "قام {$userName} بتحديث بيانات {$modelName}: ({$targetName}).",
            'deleted'       => "قام {$userName} بحذف {$modelName}: ({$targetName}).",
            'force_deleted' => "قام {$userName} بالحذف النهائي لـ {$modelName}: ({$targetName}).",
            'restored'      => "قام {$userName} باستعادة {$modelName}: ({$targetName}).",
            default         => "قام {$userName} بإجراء ({$action}) على {$modelName}.",
        };
    }

    protected static function getModelDisplayName(string $class): string
    {
        return match ($class) {
            'App\Models\Clinic'     => 'العيادة',
            'App\Models\Department' => 'القسم',
            'App\Models\Specialty'  => 'التخصص',
            'App\Models\User'       => 'المستخدم',
            'App\Models\Doctor'     => 'الطبيب',
            default                 => class_basename($class),
        };
    }
}