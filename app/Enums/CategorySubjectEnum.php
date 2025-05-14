<?php

namespace App\Enums;

enum CategorySubjectEnum: string
{
    case SYSTEM_ACCESS_ISSUE = 'System Access Issue';
    case ADMISSIONS = 'Admissions';
    case FACILITY_MAINTENANCE_REQUEST = 'Facility Maintenance Request';
    case TRANSCRIPT_OF_RECORDS_REQUEST = 'Transcript of Records Request';
    case BOOK_BORROWING_EXTENSION = 'Book Borrowing Extension';
    case SCHOLARSHIP_INQUIRY = 'Scholarship Inquiry';
    case EVENT_PARTICIPATION_REQUEST = 'Event Participation Request';
    case TUITION_FEE_DISCREPANCY = 'Tuition Fee Discrepancy';
    case UNIFORM = 'Uniform';
    case CAPSTONE = 'Capstone';

    public function getAssign(): string
    {
        return match ($this) {
            self::SYSTEM_ACCESS_ISSUE => 'Management Information Systems (MIS)',
            self::ADMISSIONS => 'Guidance and Admission Services',
            self::FACILITY_MAINTENANCE_REQUEST => 'General Services',
            self::TRANSCRIPT_OF_RECORDS_REQUEST => 'Registrar',
            self::BOOK_BORROWING_EXTENSION => 'Library Services',
            self::SCHOLARSHIP_INQUIRY => 'Student Services and Alumni Affairs',
            self::EVENT_PARTICIPATION_REQUEST => 'Supreme Student Council',
            self::TUITION_FEE_DISCREPANCY => 'Cashier',
            self::UNIFORM => 'Supply Office Accounting',
            self::CAPSTONE => 'Information Technology',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::SYSTEM_ACCESS_ISSUE => 'System Access Issue',
            self::ADMISSIONS => 'Admissions',
            self::FACILITY_MAINTENANCE_REQUEST => 'Facility Maintenance Request',
            self::TRANSCRIPT_OF_RECORDS_REQUEST => 'Transcript of Records Request',
            self::BOOK_BORROWING_EXTENSION => 'Book Borrowing Extension',
            self::SCHOLARSHIP_INQUIRY => 'Scholarship Inquiry',
            self::EVENT_PARTICIPATION_REQUEST => 'Event Participation Request',
            self::TUITION_FEE_DISCREPANCY => 'Tuition Fee Discrepancy',
            self::UNIFORM => 'Uniform',
            self::CAPSTONE => 'Capstone',
        };
    }

    public function getSubjects(): array
    {
        return match ($this) {
            self::SYSTEM_ACCESS_ISSUE => [
                'Unable to Access Campus Portal',
                'Password Reset Request',
                'Two-Factor Authentication Issue',
                'Error While Logging In to the Student System',
            ],
            self::ADMISSIONS => [
                'Application for Admission Inquiry',
                'Status of Enrollment Application',
                'Request for Admission Requirements Assistance',
                'Updating Submitted Admission Documents',
            ],
            self::FACILITY_MAINTENANCE_REQUEST => [
                'Air Conditioning Issue in Room [Room Number]',
                'Broken Furniture in [Facility Name]',
                'Request for Electrical Maintenance',
                'Water Leak in [Building/Facility]',
                'Lighting Problem in [Location]',
            ],
            self::TRANSCRIPT_OF_RECORDS_REQUEST => [
                'Request for Official Transcript of Records',
                'Inquiry About Transcript Processing Time',
                'Correction Needed in Transcript of Records',
                'Urgent Request for TOR for Job Application',
            ],
            self::BOOK_BORROWING_EXTENSION => [
                'Request for Book Loan Extension for [Book Title]',
                'Overdue Book Extension Request',
                'Library Loan Extension Request for Academic Materials',
                'Request for Extended Borrowing Period for Thesis Reference',
            ],
            self::SCHOLARSHIP_INQUIRY => [
                'Application Status for [Scholarship Name]',
                'Scholarship Requirements Clarification',
                'Request for Scholarship Renewal',
                'Financial Aid Inquiry for the Upcoming Semester',
            ],
            self::EVENT_PARTICIPATION_REQUEST => [
                'Sign-Up for [Event Name]',
                'Request to Participate in [Event or Activity Name]',
                'Clarification on Event Participation Requirements',
                'Request for Event Registration Confirmation',
            ],
            self::TUITION_FEE_DISCREPANCY => [
                'Error in Tuition Fee Statement',
                'Overcharge on Tuition Fee',
                'Request for Tuition Fee Breakdown',
                'Discrepancy in Tuition Payment Record',
            ],
            self::UNIFORM => [
                'Request for Uniform Size Change',
                'Inquiry About Uniform Availability',
                'Order Replacement for Lost Uniform',
                'Request for Assistance with Uniform Fit Issues',
            ],
            self::CAPSTONE => [
                'Approval Request for Capstone Project Title',
                'Inquiry About Capstone Proposal Requirements',
                'Request for Capstone Presentation Schedule',
                'Need Guidance on Capstone Documentation Format',
            ],
        };
    }
}
