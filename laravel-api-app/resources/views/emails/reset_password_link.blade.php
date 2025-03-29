<x-mail::message>
# Reset password link

You are receiving this email because we received a password reset request for your account.

<x-mail::button :url="$url">
Reset password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
