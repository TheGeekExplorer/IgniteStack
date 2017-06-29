<?php namespace igniteStack\System\Flow\Router;

use igniteStack\System\Flow\Requests;
use igniteStack\System\Flow\Redirect;
use igniteStack\System\ErrorHandling\Exception;

// TODO:    1, Clean up the SEO forward trailing forward slash
//          implementation - maybe implement an SEO-Friendly URL
//          method into the this class?
//          2, Think we need more tests around the route calling.
//          3, Add a layer of memcaching for view loading - this
//          should increase the performance of the app.
//          4, Are we going to implement a template syntax System?

class PathFinder
{
    private static $RequestedPath;
    private static $ControllerName;
    private static $ActionName;
    private static $ViewName;
    private static $Method;
    private static $ResourceName;

    /**
     * Runs the cascade: controller, action, view, plugins, output
     * @return string
     */
    final public static function init ()
    {
        // Get the requested path
        self::$RequestedPath = (string)Requests::getRequestedPath();

        // Load the routes array
        include_once('../config/Routes/config.php');

        // TODO: This is for SEO reasons but it's a crude implementation
        // TODO: Create a special function to do this formatting of the url.
        //if ((strlen(self::$RequestedPath) - 2) == strpos(ltrim(self::$RequestedPath, '/'), '/'))
        //    Redirect::to(rtrim(self::$RequestedPath, '/'), 301);

        /**
         * Check whether resource or controller
         */
        if (strpos(self::$RequestedPath, '/public/') > -1) {
            self::$ResourceName = self::$RequestedPath;
            return "RESOURCE";
        }
        /** */


        // Check that route exists
        if (!isset($route[self::$RequestedPath]))
            Exception::cast('RouteNotSet', 404);

        // Find the route...
        self::$ControllerName = $route[self::$RequestedPath]['controller'];
        self::$ActionName = $route[self::$RequestedPath]['action'];
        self::$ViewName = self::determineView($route[self::$RequestedPath]);  # Determine if view or theme
        self::$Method = $_SERVER['REQUEST_METHOD'];

        # Check if method (GET, POST) matches allowed in ROUTE
        if ($route[self::$RequestedPath]['method'] != self::$Method)
            Exception::cast('Method invalid for this route', 405);

        // Tell Runtime that it's a route
        return "ROUTE";
    }

    /**
     * Retrieves the "controller"
     * @return mixed
     */
    final public static function controller ()
    {
        return self::$ControllerName;
    }

    /**
     * Retrieves the "action"
     * @return mixed
     */
    final public static function action ()
    {
        return self::$ActionName;
    }

    /**
     * Retrieves the "view"
     * @return mixed
     */
    final public static function view ()
    {
        return self::$ViewName;
    }

    /**
     * Retrieves the "resource"
     * @return mixed
     */
    final public static function resource ()
    {
        return self::$ResourceName;
    }

    /**
     * Determines whether the requested route has a view or theme view set
     * @param $requested_route
     * @return mixed
     */
    final public static function determineView ($requested_route)
    {
        # If a view is set
        if (isset($requested_route['view'])) {
            $view = '../app/Views/' . $requested_route['view'] . '.php';

        # If a theme view is set
        } elseif (isset($requested_route['theme'])) {
            $view = '../app/Themes/' . $requested_route['theme'] . '.tpl.php';

        # Error, no view set
        } else {
            Exception::cast('ViewNotSet', 404);
        }

        # Return view path to open
        return $view;
    }
}
