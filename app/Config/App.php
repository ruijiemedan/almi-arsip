<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * Base Site URL - Read from environment variable
     */
    public string $baseURL = 'http://localhost:8080/';

    public function __construct()
    {
        parent::__construct();
        
        // Override baseURL from environment if available
        if (!empty(env('app.baseURL'))) {
            $this->baseURL = rtrim(env('app.baseURL'), '/') . '/';
        }
    }

    public array $allowedHostnames = [];

    public string $indexPage = '';

    public string $uriProtocol = 'REQUEST_URI';

    public string $permittedURIChars = 'a-z 0-9~%.:_\-';

    public string $defaultLocale = 'en';

    public bool $negotiateLocale = false;

    public array $supportedLocales = ['en'];

    public string $appTimezone = 'Asia/Jakarta';

    public string $charset = 'UTF-8';

    public bool $forceGlobalSecureRequests = false;

    public bool $proxyIPs = false;

    public $CSRFTokenName = 'csrf_token_name';

    public $CSRFHeaderName = 'X-CSRF-TOKEN';

    public $CSRFCookieName = 'csrf_cookie_name';

    public $CSRFExpire = 7200;

    public $CSRFRegenerate = true;

    public $CSRFRedirect = true;

    public $CSRFSameSite = 'Lax';

    public $CSPEnabled = false;

    public $cookiePrefix = '';

    public $cookieDomain = '';

    public $cookiePath = '/';

    public $cookieSecure = false;

    public $cookieHTTPOnly = true;

    public $cookieSameSite = 'Lax';

    public $sessionDriver = 'CodeIgniter\Session\Handlers\FileHandler';

    public $sessionCookieName = 'ci_session';

    public $sessionExpiration = 7200;

    public $sessionSavePath = WRITEPATH . 'session';

    public $sessionMatchIP = false;

    public $sessionTimeToUpdate = 300;

    public $sessionRegenerateDestroy = false;

    public $cookieRaw = false;
}
