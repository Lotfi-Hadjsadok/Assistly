<?php

namespace App\Policies;

use App\Models\KnowledgeWebsite;
use App\Models\User;

class KnowledgeWebsitePolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, KnowledgeWebsite $knowledgeWebsite): bool
    {
        return $user->id == $knowledgeWebsite->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KnowledgeWebsite $knowledgeWebsite): bool
    {
        return $user->id === $knowledgeWebsite->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, KnowledgeWebsite $knowledgeWebsite): bool
    {
        return $user->id === $knowledgeWebsite->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, KnowledgeWebsite $knowledgeWebsite): bool
    {
        return $user->id === $knowledgeWebsite->user_id;
    }
}
