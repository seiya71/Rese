<p>{{ $user->name }} さん、</p>
<p>メールアドレスを確認するには、以下のリンクをクリックしてください。</p>
<a href="{{ route('verification.verify', ['id' => $user->id, 'hash' => sha1($user->email)]) }}">
    メールアドレスを確認する
</a>
<p>このリンクの有効期限は 60 分です。</p>