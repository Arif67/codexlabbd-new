<?php

namespace App\Services\Contracts;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Builder;

interface ContactServiceInterface
{
    public function store(array $data): ContactMessage;

    /** Query builder for DataTables (admin). */
    public function query(): Builder;

    public function find(int $id): ContactMessage;

    public function markAsRead(ContactMessage $message): ContactMessage;

    public function delete(ContactMessage $message): void;

    public function unreadCount(): int;
}
