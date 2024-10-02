<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CorrectFileName implements Rule
{
    protected $documentField;

    public function __construct($documentField)
    {
        $this->documentField = $documentField; // Store the attribute name
    }

    public function passes($attribute, $value)
    {
        // Create the expected file name format without spaces
        $expectedFileName = str_replace(' ', '_', $this->documentField) . '.' . $value->getClientOriginalExtension();

        // Check if the uploaded file name matches the expected format (case-insensitive, no spaces)
        return strcasecmp(str_replace(' ', '_', $value->getClientOriginalName()), $expectedFileName) === 0;
    }

    public function message()
    {
        return 'The uploaded file name must be in the format of the attribute name, ignoring case and spaces.';
    }
}
