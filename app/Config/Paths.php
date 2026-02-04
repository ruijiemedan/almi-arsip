<?php

namespace Config;

/**
 * Holds the paths that are used by the system to
 * locate the main directories, app, system, etc.
 * Modifying these allows you to restructure your application,
 * share a system folder between multiple applications, and more.
 *
 * All paths are relative to the project's root folder.
 */
class Paths
{
    /**
     * The directory that contains the application directory.
     * This is typically the root of your project folder.
     */
    public string $rootDirectory = FCPATH . '../';

    /**
     * The path to the application directory.
     */
    public string $appDirectory = FCPATH . '../app';

    /**
     * The path to the project's writable directory.
     */
    public string $writableDirectory = FCPATH . '../writable';

    /**
     * The path to the project's tests directory.
     */
    public string $testsDirectory = FCPATH . '../tests';

    /**
     * The path to the vendor directory.
     */
    public string $vendorDirectory = FCPATH . '../vendor';

    /**
     * The path to the framework directory.
     * This is the directory that contains the CodeIgniter.php file.
     */
    public string $systemDirectory = FCPATH . '../vendor/codeigniter4/framework/system';

    /**
     * The path to the view directory.
     * This is the directory that contains your view files.
     */
    public string $viewDirectory = FCPATH . '../app/Views';
}