<?php

namespace App\Http\Controllers;

use App\UserApiHelper;
use Illuminate\Http\Request;
use App\Exceptions\UserApiException;

/**
 * Class UserBalanceController
 * @package App\Http\Controllers
 */
class UserBalanceController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws UserApiException
     */
    public function actionGetBalance(Request $request)
    {
        $res = [
            //'user' => null,
            'balance' => null,
        ];

        $user = UserApiHelper::getUserById($request->get('user'));
        if ($user) {
            //$res['user'] = $user->id;
            $res['balance'] = $user->balance;
        } else {
            throw new UserApiException('Undefined error!');
        }
        return response()->json($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionDeposit(Request $request)
    {
        UserApiHelper::deposit($request->json('user'), $request->json('amount'));
        return response()->json();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionWithdraw(Request $request)
    {
        UserApiHelper::withdraw($request->json('user'), $request->json('amount'));
        return response()->json();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionTransfer(Request $request)
    {
        UserApiHelper::transfer($request->json('from'), $request->json('to'), $request->json('amount'));
        return response()->json();
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return $this|null|\Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        $response = null;
        $error = '';
        try {
            $response = parent::callAction($method, $parameters);
        } catch (UserApiException $exception) {
            $error = $exception->getMessage();
        } catch (\Throwable $exception) {
            if (config('app.debug')) {
                $error = $exception->getMessage()
                    . ' file:' . $exception->getFile()
                    . ' line:' . $exception->getLine();
            } else {
                $error = 'Undefined error!';
            }
        }

        if ($error) {
            $response = response()->json(compact('error'))->setStatusCode(422);
        }

        return $response;
    }

}
