<?php namespace igniteStack\System\Flow;

use igniteStack\System\Flow\Router\PathFinder;
use igniteStack\System\ErrorHandling\Exception;
use igniteStack\System\Resources\Plugins;
use igniteStack\System\Resources\Resources;
use igniteStack\System\Storage\DiskStore\IO;
use igniteStack\System\Flow\Authentication\Session;
use igniteStack\System\Flow\Authentication\CSRF;
use igniteStack\System\Core\RuntimeStatistics;

class Runtime
{

    private $STATE = [];

    /**
     * Determine if resource or route, and act accordingly
     * @return void
     */
    final public function action ()
    {
        // Start Session
        Session::start();

        // Initiate the Routing Class
        $requested_type = PathFinder::init();

        // Determine what's been requested
        switch ($requested_type) {
            case "ROUTE":
                $this->loadRoute();
                break;
            case "RESOURCE":
                Resources::loadResource(PathFinder::resource());
                break;
        }
    }

    /**
     * Run the cascade on the requested route
     * (Is not a resource)
     */
    final private function loadRoute () {

        // Print Package Information Header
        $this->PrintHeader();

        // Get the route info
        $CONTROLLER = (string) PathFinder::controller ();
        $ACTION = (string) PathFinder::action ();
        $VIEW = (string) PathFinder::view ();

        // Add namespace to controller name for calling
        $CONTROLLER_CALL = '\\igniteStack\\app\\Controllers\\' . $CONTROLLER;

        // Runs the cascade...
        $this->testControllerExists ($CONTROLLER);            // TEST: Is the controller existent?
        $this->testActionExists ($CONTROLLER_CALL, $ACTION);  // TEST: Is the action existent?
        $this->testViewExists ($VIEW);                        // TEST: Is the view existent?

        /**
         * Run controller and action
         */
        $this->STATE = $this->runAction($CONTROLLER_CALL, $ACTION);    // Run the controller & action, and return the STATE

        /**
         * Run the cascade
         */
        $this->loadView(                                      // Runs the action and loads the view
            $VIEW,                                            // Pass the path of the view to load
            $this->STATE                                      // Pass the STATE to the view
        );
    }

    /**
     * Test to see if the controller exists
     * @param $c
     */
    final private function testControllerExists ($c)
    {
        if (!file_exists ("../app/Controllers/$c.php"))
            Exception::cast('ControllerExists');
        return;
    }

    /**
     * Test that the action exists
     * @param $c
     * @param $a
     */
    final private function testActionExists ($c, $a)
    {
        if (!method_exists ($c, $a))
            Exception::cast ('ActionExists');
        return;
    }

    /**
     * Test that the view exists
     * @param $v
     */
    final private function testViewExists ($v)
    {
        if (!IO::exists($v))
            Exception::cast ('ViewExists');
        return;
    }

    /**
     * Run the action
     * @param $c
     * @param $a
     * @return mixed
     */
    final private function runAction ($c, $a)
    {
        return (new $c)->$a();
    }

    /**
     * Prints Package Info Header before HTML
     */
    final private static function PrintHeader ()
    {
        # Include Versioning Information
        $c = '../config/Core/version.php';
        if(!IO::exists($c))
            Exception::cast('IncludeExists');
        include_once ($c);

        # Delimiters
        $d = '||';
        $s = '##';

        # Build header template
        $header  =  "<!--\r\n";
        $header .=  "$d$s Powered by "  . PACKAGE_NAME . "\r\n";
        //$header .=  "$d$s$s Version:  " . PACKAGE_VERSION . "\r\n";
        //$header .=  "$d$s$s Revision: " . PACKAGE_REVISION . "\r\n";
        //$header .=  "$d$s$s Released: " . PACKAGE_RELEASE_DATE . "\r\n";
        $header .=  "-->\r\n";
        #echo $header;
    }

    /**
     * Load a view with the Frontend Plugins
     * @param $v
     * @param $_STATE
     * @return void
     */
    final private function loadView ($v, $_STATE)
    {
        // Start the output buffer
        @ob_start([
            (new Plugins),
            'Frontend'
        ]);

        // Include the view
        include_once($v);

        // Flush Output Buffer, insert the CSS and JS dependencies, and send to the client
        @ob_end_flush();
    }
}
