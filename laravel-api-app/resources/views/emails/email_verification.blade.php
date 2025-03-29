<x-mail::message>
# Email Verification

You are receiving this email because we received a request to verify your email address.

<x-mail::button :url="$url">
Email Verification
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
