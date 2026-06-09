<?php

namespace App\Services;

use App\Models\ContactMessage;
use App\Services\Contracts\ContactServiceInterface;
use Illuminate\Database\Eloquent\Builder;

class ContactService implements ContactServiceInterface
{
    public function store(array $data): ContactMessage
    {
        return ContactMessage::create($data);
    }

    public function query(): Builder
    {
        return ContactMessage::query();
    }

    public function find(int $id): ContactMessage
    {
        return ContactMessage::query()->findOrFail($id);
    }

    public function markAsRead(ContactMessage $message): ContactMessage
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return $message;
    }

    public function delete(ContactMessage $message): void
    {
        $message->delete();
    }

    public function unreadCount(): int
    {
        return ContactMessage::query()->where('is_read', false)->count();
    }
}
