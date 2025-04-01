@component('mail::message')
# Welcome to PSU HelpDeskPro, {{ $user->name }}!

Your sign-up request has been approved. You can now log in to your PSU student account using the following credentials:

@component('mail::panel')
**Student ID:** {{ $user->student_id }} <br>
**Password:** {{ $user->student_id }} (please change this upon first login)
@endcomponent

@component('mail::button', ['url' => route('login.student')])
Login to Your Account
@endcomponent

Here's some important information to get you started:

1. Please change your password immediately after your first login.
2. Update your profile information to ensure we have your most current details.
3. Familiarize yourself with the student portal and its features.

If you have any questions or need assistance, please don't hesitate to contact our support team.

Thank you for joining PSU. We look forward to supporting you in your academic journey!

Best regards,<br>
{{ config('app.name') }} Team
@endcomponent