@component('mail::message')
# Hello {{ $name }},

Thank you for submitting your sign-up request to PSU HelpDeskPro. We have received your request and are currently reviewing it.

Please wait for further notification regarding the approval of your account. If you have any questions in the meantime, feel free to contact our support team.

@component('mail::button', ['url' => route('contact.support')])
Contact Support
@endcomponent

Thank you for your patience. We appreciate your interest in PSU HelpDeskPro!

Best regards,  
{{ config('app.name') }} Team
@endcomponent
