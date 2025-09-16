<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;

class CustomVerifyEmail extends BaseVerifyEmail
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('【Rese】メールアドレス確認のお願い')
            ->line('会員登録ありがとうございます。')
            ->line('以下のボタンをクリックして認証を完了してください。')
            ->action('メールアドレスを認証する', $url)
            ->line('このリンクは60分で無効になります。')
            ->line('もし本メールに心当たりがない場合は破棄してください。');
    }
}
