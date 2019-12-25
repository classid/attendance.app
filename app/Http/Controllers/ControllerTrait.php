<?php

namespace CID\Finger\Http\Controllers;


trait ControllerTrait
{
    /**
     * Authenticated User
     *
     * @var mixed
     */
    protected $authUser;

    /**
     * Controller data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Active menu indicator.
     *
     * @var array
     */
    protected $activeMenu = [];
    protected $activeMenuPack = [];

    /**
     * Page title.
     *
     * @var string
     */
    protected $pageTitle;


    protected $breadCrumbs = [];

    /**
     * Page Meta.
     *
     * @var array
     */
    protected $pageMeta = [
        'description' => null,
        'keywords' => null,
    ];

    /**
     * Reserved variable for the controller.
     *
     * @var array
     */
    protected $reservedVariables = ['activeMenu', 'pageTitle', 'pageMeta', 'breadCrumbs'];

    /**
     * Prefix View Path
     *
     * @var string
     */
    protected $prefixView = '';
    protected $viewPath = '';

    /**
     * type of crud form
     *
     * @var string
     */
    protected $crudType = '';

    /**
     * page using token authentication
     *
     * @var bool
     */
    protected $isAuthToken = false;

    /**
     * main route name
     *
     * @var string
     */
    protected $route = '';
}
