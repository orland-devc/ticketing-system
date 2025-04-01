@component('mail::message')
# Hello {{ $name }},

We regret to inform you that your sign-up request for PSU HelpDeskPro has been rejected.

If you believe this was a mistake or if you have any further questions, please contact our support team for clarification.

@component('mail::button', ['url' => route('contact.support')])
Contact Support
@endcomponent

Thank you for your interest in PSU. We wish you all the best in your future endeavors.

Best regards,  
{{ config('app.name') }} Team
@endcomponent
