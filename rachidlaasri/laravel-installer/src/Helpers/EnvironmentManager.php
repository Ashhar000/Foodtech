<?php

namespace RachidLaasri\LaravelInstaller\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent()
    {
        if (! file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    /**
     * Get the the .env file path.
     *
     * @return string
     */
    public function getEnvPath()
    {
        return $this->envPath;
    }

    /**
     * Get the the .env.example file path.
     *
     * @return string
     */
    public function getEnvExamplePath()
    {
        return $this->envExamplePath;
    }

    /**
     * Save the edited content to the .env file.
     *
     * @param Request $input
     * @return string
     */
    public function saveFileClassic(Request $input)
    {
        $message = trans('installer_messages.environment.success');

        try {
            file_put_contents($this->envPath, $input->get('envConfig'));
        } catch (Exception $e) {
            $message = trans('installer_messages.environment.errors');
        }

        return $message;
    }

    /**
     * Save the form content to the .env file.
     *
     * @param Request $request
     * @return string
     */
    public function saveFileWizard(Request $request)
    {
        $results = trans('installer_messages.environment.success'); 

        $envFileData =
        'APP_NAME=\''.$request->app_name."'\n".
        'APP_ENV='.$request->environment."\n".
        'APP_KEY='.'base64:'.base64_encode(Str::random(32))."\n".
        'APP_DEBUG='.$request->app_debug."\n".
        'APP_LOG_LEVEL='.$request->app_log_level."\n". 
        'APP_URL='.$request->app_url."\n\n".
        'DB_CONNECTION='.$request->database_connection."\n".
        'DB_HOST='.$request->database_hostname."\n".
        'DB_PORT='.$request->database_port."\n".
        'DB_DATABASE='.$request->database_name."\n".
        'DB_USERNAME='.$request->database_username."\n".
        'DB_PASSWORD='.$request->database_password."\n\n".
        'BROADCAST_DRIVER=log'."\n".
        'CACHE_DRIVER=file'."\n".
        'FILESYSTEM_DRIVER=local'."\n".
        'QUEUE_CONNECTION=sync'."\n\n".
        'SESSION_DRIVER=file'."\n".
        'SESSION_LIFETIME=120'."\n\n".
        'MEMCACHED_HOST=127.0.0.1'."\n\n".
        'REDIS_HOST=127.0.0.1'."\n".
        'REDIS_PASSWORD=null'."\n".
        'REDIS_PORT=6379'."\n\n".
        'MAIL_MAILER=smtp'."\n".
        'MAIL_HOST=mailhog'."\n".
        'MAIL_PORT=1025'."\n".
        'MAIL_USERNAME=null'."\n".
        'MAIL_PASSWORD=null'."\n".
        'MAIL_ENCRYPTION=null'."\n".
        'MAIL_FROM_ADDRESS="${MAIL_USERNAME}"'."\n".
        'MAIL_FROM_NAME="${APP_NAME}"'."\n\n".
        'PUSHER_APP_ID='."\n".
        'PUSHER_APP_KEY='."\n".
        'PUSHER_APP_SECRET='."\n".
        'PUSHER_APP_CLUSTER=mt1'."\n\n".
        'AWS_ACCESS_KEY_ID='."\n".
        'AWS_SECRET_ACCESS_KEY='."\n".
        'AWS_DEFAULT_REGION=us-eat-1'."\n".
        'AWS_BUCKET='."\n".
        'AWS_USE_PATH_STYLE_ENDPOINT=false'."\n\n".
        'MIX_PUSHPER_APP_KEY="${PUSHER_APP_KEY}"'."\n".
        'MIX_PUSHPER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"'."\n\n".
        'RAZOR_KEY=rzp_test_D8WV5QiBJGQLgg'."\n".
        'RAZOR_SECRET=eHpFBhJJvKNOjWsd87Ek3dhl'."\n".
        'PAYPAL_CLIENT_ID=AUbBWlDhAMCLP7ksqDZBUDANqyseHFT3CDL1-VLWis-rIDF1b1qyQCsJJaTCe6vx9qkEoUifsv8vVu9C'."\n".
        'PAYPAL_SECRET=EB8kam9OXARC8NT-zVVkPLKXepKvbyaYrUcbz0WqlTiyv99Y4i55bVQoU6Sk4B9ysQXhJ8SEj0WP6KQ1'."\n".
        'PAYPAL_MODE=sandbox';

        try {
            file_put_contents($this->envPath, $envFileData);
        } catch (Exception $e) {
            $results = trans('installer_messages.environment.errors');
        }

        return $results;
    }
}
