<?php
namespace App;

use App\Exceptions\UserApiException;
use Illuminate\Support\Facades\DB;

/**
 * Class UserApiHelper
 * @package App
 */
class UserApiHelper
{
    /**
     * @param $userId
     * @return User
     * @throws UserApiException
     */
    public static function getUserById($userId): User
    {
        /**
         * @var User $user
         */
        if(!($userId = (int) $userId)) {
            throw new UserApiException('Invalid user ID.');
        }

        $user = User::find($userId);

        if(!$user) {
            $user = new User();
            $user->id = $userId;
            $user->balance = 0;

            if(!$user->save())  {
                throw new UserApiException('Could not add new user.');
            }
        }

        return $user;
    }

    /**
     * @param $amount
     * @return int
     * @throws UserApiException
     */
    protected static function chkAmount($amount): int
    {
        if(!($amount = (int) $amount)) {
            throw new UserApiException('Invalid value of the amount.');
        }

        return $amount;
    }

    /**
     * @param $userId
     * @param $amount
     * @throws UserApiException
     */
    public static function deposit($userId, $amount): void
    {
        $user = static::getUserById($userId);
        $amount = static::chkAmount($amount);
        $user->balance += $amount;
        if(!$user->save()) {
            throw new UserApiException('Error of fill up the balance.');
        }
    }

    /**
     * @param $userId
     * @param $amount
     * @throws UserApiException
     */
    public static function withdraw($userId, $amount): void
    {
        $user = static::getUserById($userId);
        $amount = static::chkAmount($amount);
        $user->balance -= $amount;

        if($user->balance < 0) {
            throw new UserApiException('Insufficient funds.');
        }

        if(!$user->save()) {
            throw new UserApiException('Error of fill up the balance.');
        }

    }

    /**
     * @param $from
     * @param $to
     * @param $amount
     * @throws UserApiException
     */
    public static function transfer($from, $to, $amount): void
    {
        $fromUser = static::getUserById($from);
        $toUser = static::getUserById($to);
        $fAmount = static::chkAmount($amount);

        $fromUser->balance -= $fAmount;
        $toUser->balance += $fAmount;

        if($fromUser->balance < 0) {
            throw new UserApiException('Insufficient funds.');
        }

        DB::beginTransaction();
        $saveFailed = !($fromUser->save() && $toUser->save());

        try {
            $saveFailed = !($fromUser->save() && $toUser->save());
        } catch (\Throwable $exception) {
            $saveFailed = true;
        }

        if($saveFailed) {
            DB::rollback();
            throw new UserApiException('Translation failed.');
        } else {
            DB::commit();
        }
    }

}