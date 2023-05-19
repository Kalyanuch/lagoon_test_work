<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserService {
    /**
     * Check ability for new user registration.
     *
     * @param array $data
     *   User data.
     *
     * @return bool
     *   Status result.
     */
    public function register(array $data)
    {
        $this->clearData($data);

        $users_data = json_decode(Storage::disk('local')->get('data.json'), true) ?? [];

        foreach($users_data as $user_data)
        {
            if($user_data['email'] == $data['email'])
            {
                Log::channel('daily')->error('Trying to register with existing email', $data);

                return false;
            }
        }

        $users_data[] = $data;

        Storage::disk('local')->put('data.json', json_encode($users_data));

        Log::channel('daily')->info('New user registration', $data);

        return true;
    }

    /**
     * Clearify input data.
     *
     * @param array $data
     *   User data.
     *
     * @return array
     *   Cleared user data.
     */
    protected function clearData(array $data)
    {
        if(array_key_exists('password_confirmation', $data))
        {
            unset($data['password_confirmation']);
        }

        return $data;
    }
}
