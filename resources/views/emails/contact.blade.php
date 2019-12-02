

@component('mail::message')
    Hi,

    A Gwed2 user has sent you a message.

    Name: {{ $contact['name'] }}

    E-mail: {{ $contact['email'] }}

    Message: {{ $contact['msg'] }}

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent