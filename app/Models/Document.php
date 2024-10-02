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
    
    

    public function checkCompletion()
    {
        // Check if all required documents are uploaded (marriage_certificate is optional)
        $allDocumentsUploaded = $this->valid_id &&
                                 $this->birth_certificate &&
                                 $this->medical_certificate &&
                                 $this->nbi_clearance &&
                                 $this->passport;

        // Update the status based on the document checks
        $this->status = $allDocumentsUploaded ? 'completed' : 'pending';
        $this->save(); // Save the model with the updated status
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
