<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Application;
use Illuminate\Support\Facades\Log;

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

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    /**
     * Check if all required documents are uploaded.
     *
     * @return bool
     */
    protected static function booted()
    {
        static::updated(function ($document) {

            // Check if the status is 'completed'
            if ($document->status === 'completed') {
                Log::info('Document status updated to completed', [
                    'document_id' => $document->status,
                    'applicant_id' => $document->applicant_id
                ]);

                // Get the applicant's application(s)
                $applications = Application::where('applicant_id', $document->applicant_id) // Onlys assign control numbers to applications that don't have one yet
                    ->first();


                $applications->update([
                    'status' => 'completed', // Optionally, update application status too
                ]);
            }
        });
    }
}
