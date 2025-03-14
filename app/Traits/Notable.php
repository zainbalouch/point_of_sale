<?php

namespace App\Traits;

use App\Models\Note;

trait Notable
{
    /**
     * Get all notes for this model
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }

    /**
     * Add a note to this model
     * 
     * @param string $note
     * @return Note
     */
    public function addNote(string $note)
    {
        return $this->notes()->create([
            'note' => $note,
        ]);
    }
} 