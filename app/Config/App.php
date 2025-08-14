<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * Base site URL.
     * Generated dynamically for compatibility with CI3 config.
     */
    public string $baseURL = '';

    /**
     * Index file.
     */
    public string $indexPage = 'index.php';

    /**
     * Default locale used by the application.
     */
    public string $defaultLocale = 'english';

    /**
     * Default character set.
     */
    public string $charset = 'UTF-8';

    /**
     * --------------------------------------------------------------------------
     * Session Settings
     * --------------------------------------------------------------------------
     */
    public string $sessionDriver = 'CodeIgniter\\Session\\Handlers\\FileHandler';
    public string $sessionCookieName = 'ci_session';
    public int $sessionExpiration = 0;
    public string $sessionSavePath;
    public bool $sessionMatchIP = false;
    public int $sessionTimeToUpdate = 300;
    public bool $sessionRegenerateDestroy = false;

    public function __construct()
    {
        // replicate dynamic baseURL from CI3 config
        $root = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://');
        $root .= $_SERVER['HTTP_HOST'] ?? 'localhost';
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME'] ?? ''), '', $_SERVER['SCRIPT_NAME'] ?? '');
        $this->baseURL = $root;

        $this->sessionSavePath = sys_get_temp_dir();
    }
}
