<x-mail::message>


Your tenant account has been created successfully. Here are your login credentials:

**Email:** {{ $credentials['email'] }}  

You can access your dashboard at:  
{{ $credentials['domain'] }}

Please change your password after your first login.
    

<x-mail::button :url="$credentials['domain']">
Go to Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
