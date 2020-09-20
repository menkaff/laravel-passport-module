<?php

namespace Modules\Passport\Service;

class TokenService
{
    public function Index($params)
    {
        $user = $params['user'];
        $tokens = $user->tokens()->get();
        foreach ($tokens as $token) {
            $token->created_at = \Carbon\Carbon::parse($token->created_at)->timestamp;

            $token->updated_at = \Carbon\Carbon::parse($token->updated_at)->timestamp;

        }
        return serviceOk($tokens);

    }

    public function Current($params)
    {
        $user = $params['user'];
        return serviceOk($user->token());
    }

    public function Delete($params)
    {
        $user = $params['user'];

        $user->tokens()
            ->when(isset($params['ids']) && is_array($params['ids']), function ($query) use ($params) {
                $query->whereIn('id', $params['ids']);
            })
            ->when(isset($params['id']), function ($query) use ($params) {
                $query->where('id', '=', $params['id']);
            })
            ->when(isset($params['except_ids']) && is_array($params['ids']), function ($query) use ($params) {
                $query->whereIn('id', '!=', $params['except_ids']);
            })
            ->when(isset($params['except_id']), function ($query) use ($params) {
                $query->where('id', '!=', $params['except_id']);
            })
            ->delete();

        return serviceOk(trans('passport::messages.done'));

    }
}
