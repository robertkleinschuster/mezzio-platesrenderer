<?php

/**
 * @see       https://github.com/mezzio/mezzio-platesrenderer for the canonical source repository
 * @copyright https://github.com/mezzio/mezzio-platesrenderer/blob/master/COPYRIGHT.md
 * @license   https://github.com/mezzio/mezzio-platesrenderer/blob/master/LICENSE.md New BSD License
 */

namespace Mezzio\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use Mezzio\Helper\ServerUrlHelper;
use Mezzio\Helper\UrlHelper;

class UrlExtension implements ExtensionInterface
{
    /**
     * @var ServerUrlHelper
     */
    private $serverUrlHelper;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * @param UrlHelper $urlHelper
     * @param ServerUrlHelper $serverUrlHelper
     */
    public function __construct(UrlHelper $urlHelper, ServerUrlHelper $serverUrlHelper)
    {
        $this->urlHelper = $urlHelper;
        $this->serverUrlHelper = $serverUrlHelper;
    }

    /**
     * Register functions with the Plates engine.
     *
     * Registers:
     *
     * - url($route = null, array $params = []) : string
     * - serverurl($path = null) : string
     *
     * @param Engine $engine
     * @return void
     */
    public function register(Engine $engine)
    {
        $engine->registerFunction('url', [$this, 'generateUrl']);
        $engine->registerFunction('serverurl', [$this, 'generateServerUrl']);
    }

    /**
     * Generate a URL from either the currently matched route or the specfied route.
     *
     * @param string $routeName
     * @param array  $routeParams
     * @param array  $queryParams
     * @param string $fragmentIdentifier
     * @param array  $options Can have the following keys:
     *     - router (array): contains options to be passed to the router
     *     - reuse_result_params (bool): indicates if the current RouteResult
     *       parameters will be used, defaults to true
     * @return string
     */
    public function generateUrl(
        $routeName = null,
        array $routeParams = [],
        array $queryParams = [],
        $fragmentIdentifier = '',
        array $options = []
    ) {
        return $this->urlHelper->generate($routeName, $routeParams, $queryParams, $fragmentIdentifier, $options);
    }

    /**
     * Generate a fully qualified URI, relative to $path.
     *
     * @param null|string $path
     * @return string
     */
    public function generateServerUrl($path = null)
    {
        return $this->serverUrlHelper->generate($path);
    }
}
