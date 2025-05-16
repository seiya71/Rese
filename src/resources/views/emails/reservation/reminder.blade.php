@component('mail::message')
# ご予約のリマインダー

{{ $reservation->user->name }}様

本日 {{ $reservation->reservation_date->format('Y年m月d日') }} に以下のご予約があります：

- 店舗名：{{ $reservation->shop->name }}
- 時間：{{ $reservation->start_time }}

お忘れなきよう、よろしくお願いいたします。

@endcomponent
