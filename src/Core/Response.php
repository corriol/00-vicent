<?php
declare(strict_types=1);


namespace App\Core;


class Response
{
    /**
     * @param string $view
     * @param string $layout
     * @param array $data
     * @return string
     */
    public function renderView(string $view, string $layout = 'default', array $data = []): string {

        extract($data);

<<<<<<< HEAD
=======

>>>>>>> 146d23b85006288681382f395542c8798ef76e87
        // Change: Integrate the FlashMessage management
        $flashMessage = App::get("flash");
        $router = App::get(Router::class);
        $user = App::get('user');
<<<<<<< HEAD
        $config = App::get("config");
=======
>>>>>>> 146d23b85006288681382f395542c8798ef76e87

        ob_start();
        require __DIR__ . "/../../views/$view.view.php";
        $content = ob_get_clean();

        ob_start();
        require __DIR__ . "/../../views/_layouts/$layout.layout.php";

        return ob_get_clean();
    }

    /**
     * @param mixed $element
     * @param int $httpStatus
     * @return string
     */
    public function jsonResponse(array $element, int $httpStatus = 200): string
    {
        header($_SERVER["SERVER_PROTOCOL"] . ' ' . $httpStatus);
        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($element);
    }
}