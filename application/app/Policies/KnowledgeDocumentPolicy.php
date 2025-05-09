<?php

namespace App\Policies;

use App\Models\KnowledgeDocument;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KnowledgeDocumentPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, KnowledgeDocument $knowledgeDocument): bool
    {
        return $user->id === $knowledgeDocument->user_id;
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, KnowledgeDocument $knowledgeDocument): bool
    {
        return $user->id === $knowledgeDocument->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KnowledgeDocument $knowledgeDocument): bool
    {
        return $user->id === $knowledgeDocument->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, KnowledgeDocument $knowledgeDocument): bool
    {
        return $user->id === $knowledgeDocument->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, KnowledgeDocument $knowledgeDocument): bool
    {
        return $user->id === $knowledgeDocument->user_id;
    }
}
