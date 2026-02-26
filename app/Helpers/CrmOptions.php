<?php

namespace App\Helpers;

class CrmOptions
{
    public static function countries(): array
    {
        return [
            'United States', 'United Kingdom', 'Canada', 'Australia', 'Germany',
            'France', 'Spain', 'Italy', 'Netherlands', 'Sweden', 'Norway', 'Denmark',
            'Finland', 'Switzerland', 'Austria', 'Belgium', 'Portugal', 'Poland',
            'Japan', 'China', 'India', 'South Korea', 'Singapore', 'Malaysia',
            'Philippines', 'Indonesia', 'Thailand', 'Vietnam', 'Brazil', 'Mexico',
            'Argentina', 'Colombia', 'Chile', 'South Africa', 'Nigeria', 'Kenya',
            'Egypt', 'UAE', 'Saudi Arabia', 'Turkey', 'Israel', 'Other',
        ];
    }

    public static function states(): array
    {
        return [
            'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado',
            'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho',
            'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
            'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
            'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada',
            'New Hampshire', 'New Jersey', 'New Mexico', 'New York',
            'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon',
            'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota',
            'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington',
            'West Virginia', 'Wisconsin', 'Wyoming', 'Other',
        ];
    }

    public static function cities(): array
    {
        return [
            'New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia',
            'San Antonio', 'San Diego', 'Dallas', 'San Jose', 'Austin', 'Jacksonville',
            'Fort Worth', 'Columbus', 'Charlotte', 'Seattle', 'Denver', 'Boston',
            'Nashville', 'Baltimore', 'London', 'Paris', 'Berlin', 'Madrid', 'Rome',
            'Amsterdam', 'Toronto', 'Sydney', 'Melbourne', 'Singapore', 'Tokyo',
            'Dubai', 'Other',
        ];
    }

    public static function currencies(): array
    {
        return ['USD', 'EUR', 'GBP', 'JPY', 'CAD', 'AUD', 'CHF', 'CNY', 'INR', 'SGD', 'AED', 'SAR', 'BRL', 'MXN'];
    }

    public static function languages(): array
    {
        return ['English', 'Spanish', 'French', 'German', 'Italian', 'Portuguese',
                'Dutch', 'Swedish', 'Norwegian', 'Danish', 'Finnish', 'Japanese',
                'Chinese', 'Korean', 'Arabic', 'Hindi', 'Other'];
    }

    public static function industries(): array
    {
        return ['Technology', 'Finance', 'Healthcare', 'Education', 'Manufacturing',
                'Retail', 'Real Estate', 'Media', 'Legal', 'Consulting', 'Transportation',
                'Energy', 'Agriculture', 'Entertainment', 'Non-Profit', 'Government', 'Other'];
    }

    public static function sources(): array
    {
        return ['Website', 'Referral', 'Social Media', 'Email Campaign', 'Cold Call',
                'Trade Show', 'Advertisement', 'Partner', 'Other'];
    }

    public static function priorities(): array
    {
        return ['Low', 'Medium', 'High', 'Urgent'];
    }

    public static function dealStatuses(): array
    {
        return ['New', 'In Progress', 'Won', 'Lost', 'On Hold'];
    }

    public static function projectStatuses(): array
    {
        return ['Not Started', 'In Progress', 'On Hold', 'Completed', 'Cancelled'];
    }

    public static function taskStatuses(): array
    {
        return ['Todo', 'In Progress', 'Under Review', 'Completed'];
    }

    public static function proposalStatuses(): array
    {
        return ['Draft', 'Sent', 'Accepted', 'Declined', 'Expired'];
    }

    public static function contractTypes(): array
    {
        return ['Service Agreement', 'NDA', 'Partnership', 'Employment', 'Vendor', 'Other'];
    }

    public static function invoiceStatuses(): array
    {
        return ['Draft', 'Sent', 'Paid', 'Overdue', 'Cancelled'];
    }

    public static function paymentMethods(): array
    {
        return ['Bank Transfer', 'Credit Card', 'PayPal', 'Stripe', 'Cheque', 'Cash', 'Other'];
    }

    public static function estimationStatuses(): array
    {
        return ['Draft', 'Sent', 'Approved', 'Declined', 'Expired'];
    }

    public static function activityTypes(): array
    {
        return ['Call', 'Meeting', 'Email', 'Task', 'Follow Up', 'Demo', 'Other'];
    }

    public static function campaignTypes(): array
    {
        return ['Email', 'SMS', 'Social Media', 'Display Ads', 'Content', 'Referral', 'Event', 'Other'];
    }

    public static function periods(): array
    {
        return ['Daily', 'Weekly', 'Monthly', 'Quarterly', 'Yearly'];
    }

    public static function projectTimings(): array
    {
        return ['Fixed', 'Hourly', 'Monthly Retainer', 'Milestone-based'];
    }

    public static function projectTypes(): array
    {
        return ['Internal', 'External', 'Research', 'Development', 'Maintenance', 'Other'];
    }
}
