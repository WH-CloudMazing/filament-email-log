<?php

namespace Cloudmazing\FilamentEmailLog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Config;

/**
 * Email
 *
 * @property string $from
 * @property string $to
 * @property string $cc
 * @property string $bcc
 * @property string $subject
 * @property string $text_body
 * @property string $html_body
 * @property string $raw_body
 * @property string $sent_debug_info
 * @property string|null $mailer
 * @property string|null $mailable_subject_type
 * @property int|null $mailable_subject_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read Model|null $mailableSubject
 */
class Email extends Model
{
    use HasFactory;
    use Prunable;

    protected $table = 'filament_email_log';

    protected $guarded = [];

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        return static::where('created_at', '<=', now()->subDays(Config::get('filament-email-log.keep_email_for_days')));
    }

    public function mailableSubject(): MorphTo
    {
        return $this->morphTo('mailable_subject');
    }

    public static function log(array $data): static
    {
        return static::create($data);
    }
}
