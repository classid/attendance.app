<?php

namespace CID\Finger\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ControllerTrait;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        auth()->setDefaultDriver('web');

        $this->middleware(function ($request, $next) {
            if (auth()->check()) {
                $this->setData('authUser', auth()->user());
            } else {
                $this->setData('authUser', (object)[]);
            }

            return $next($request);
        });
    }

    /**
     * Serve blade template.
     *
     * @param string $view
     *
     * @return \Illuminate\View\View
     */
    public function view($view)
    {
        if (false === array_key_exists('pageTitle', $this->data)) {
            $this->setPageTitle('Untitled');
        }

        $this->setPageMeta('csrf_token', csrf_token());
        $this->data['breadCrumbs'] = $this->breadCrumbs;
        $this->data['activeMenu'] = $this->activeMenu;
        $this->data['pageMeta'] = $this->pageMeta;
        $this->data['crudType'] = $this->crudType;
        $this->data['viewPath'] = ($this->viewPath ?: $this->prefixView) . '.';
        $this->data['route'] = $this->route;

        if ($this->prefixView)
            $view = $this->prefixView . '.' . $view;

        return view($view, $this->data);
    }

    /**
     * Set controller data.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return \CID\FInger\Http\Controllers
     *
     * @throws \Exception
     */
    public function setData($name, $value)
    {
        if (in_array($name, $this->reservedVariables)) {
            throw new \Exception("Variable [$name] is reserved by this controller");
        }
        $this->data[$name] = $value;

        return $this;
    }

    /**
     * Append to an existing controller data.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return \CID\FInger\Http\Controllers
     *
     * @throws \Exception
     */
    public function pushData($name, $value)
    {
        if (in_array($name, $this->reservedVariables)) {
            throw new \Exception("Variable [$name] is reserved by this controller");
        }
        $this->data[$name] .= $value;

        return $this;
    }

    /**
     * Set page meta.
     *
     * @param string $metaKey
     * @param mixed  $metaValue
     *
     * @return $this
     */
    public function setPageMeta($metaKey, $metaValue)
    {
        $this->pageMeta[$metaKey] = $metaValue;

        return $this;
    }

    /**
     * Set Page title.
     *
     * @param string $title
     *
     * @return $this
     */
    public function setPageTitle($title)
    {
        $this->data['pageTitle'] = $title;

        return $this;
    }

    public function setActiveMenu($menu)
    {
        if (! $menu) {
            throw new \Exception("Can not add null menu");
        }
        array_push($this->activeMenu, $menu);
        return $this;
    }

    public function setBreadCrumbs($crumbs)
    {
        if (! $crumbs) {
            throw new \Exception("Can not add null bread crumbs");
        }
        array_push($this->breadCrumbs, $crumbs);
        return $this;
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @return void
     */
    public function validate(Request $request, array $rules, array $messages = array(), array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()
            ->make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            flash('Mohon cek kembali data yang anda inputkan', 'warning');
        }
        $validator->validate();

        return $this->extractInputFromRules($request, $rules);
    }
}
