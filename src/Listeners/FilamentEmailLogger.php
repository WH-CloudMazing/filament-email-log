<?php

namespace Cloudmazing\FilamentEmailLog\Listeners;

use Illuminate\Mail\Events\MessageSent;

class FilamentEmailLogger
{
    public function handle(MessageSent $event)
    {
        $rawMessage = $event->sent->getSymfonySentMessage();
        $email = $event->message;

        $subject = $event->data['mailable_subject'] ?? null;

        config('filament-email-log.models.email')::log([
            'from' => $this->RecipientsToString($email->getFrom()),
            'to' => $this->RecipientsToString($email->getTo()),
            'cc' => $this->RecipientsToString($email->getCc()),
            'bcc' => $this->RecipientsToString($email->getBcc()),
            'subject' => $email->getSubject(),
            'html_body' => $email->getHtmlBody(),
            'text_body' => $email->getTextBody(),
            'raw_body' => $rawMessage->getMessage()->toString(),
            'sent_debug_info' => $rawMessage->getDebug(),
            'mailer' => $event->data['mailer'],
            'mailable_subject_type' => $subject?->getMorphClass(),
            'mailable_subject_id' => $subject?->id ?? null,
        ]);
    }

    private function RecipientsToString(array $recipients): string
    {
        return implode(
            ',',
            array_map(function ($email) {
                return "{$email->getAddress()}".($email->getName() ? " <{$email->getName()}>" : '');
            }, $recipients)
        );
    }
}
