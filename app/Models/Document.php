<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'valid_id',
        'birth_certificate',
        'medical_certificate',
        'nbi_clearance',
        'marriage_certificate',
        'passport',
        'description',
        'status',
    ];


    public function checkCompletion(): void
    {
        $requiredFiles = [
            'valid_id',
            'birth_certificate',
            'medical_certificate',
            'nbi_clearance',
            'passport',
        ];

        $allFilesUploaded = true;

        foreach ($requiredFiles as $file) {
            if (empty($this->$file)) {  // This ensures both null and empty values are handled
                $allFilesUploaded = false;
                break;
            }
        }

        // If all required files are uploaded, set status to 'completed'
        if ($allFilesUploaded) {
            $this->update(['status' => 'completed']);
        } else {
            // Optionally, set it back to 'pending' if not all files are uploaded
            $this->update(['status' => 'pending']);
        }
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    /**
     * Check if all required documents are uploaded.
     *
     * @return bool
     */
}
