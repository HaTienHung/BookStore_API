<?php

namespace App\Policies;

use App\Enums\Constant;
use App\Enums\RoleType;
use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class BookPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role->name === RoleType::ADMIN->value) {
            return true;
        }

        return null;
    }
    private function checkBookOwnership(User $user, $book): Response
    {
        return $user->publisher?->id === $book->publisher_id
            ? Response::allow()
            : Response::denyAsNotFound('You do not own this book.', Constant::NOT_FOUND_CODE);
    }
    private function checkBooksOwnership($user, $book, $args): Response
    {

        $invalidCount = $book->whereIn('id', $args['ids'])
            ->where('publisher_id', '!=', $user->publisher?->id)
            ->count();

        return $invalidCount === 0  ? Response::allow()
            : Response::denyAsNotFound('You do not own one or more of these books.', Constant::NOT_FOUND_CODE);
    }
    /**
     * Determine if the given post can be updated by the user.
     */
    public function update(User $user, $book): Response
    {
        // Log::info("Hello");
        return $this->checkBookOwnership($user, $book);
    }

    public function view(User $user, $book): Response
    {
        // Log::info("Hello");
        return $this->checkBookOwnership($user, $book);
    }
    public function bulkDelete(User $user, Book $book, $ids)
    {
        return $this->checkBooksOwnership($user, $book, $ids);
    }
    public function bulkRestore(User $user, Book $book, array $ids)
    {
        return $this->checkBooksOwnership($user, $book, $ids);
    }
}
