<?php
declare(strict_types=1);


namespace DisasterBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DisasterController
 * @package DisasterBundle
 */
class DisasterController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return new JsonResponse([
            'info' => 'Welcome to Watchdog WEB application. To use it please send request to route /detect/disasters',
            'request' => $this->get('serializer')->serialize(
                [
                    'coordinates' => [
                        'latitude' => 12,
                        'longitude' => 12
                    ]
                ], 'json'),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function detectDisasterAction(Request $request)
    {
        $json = $request->getContent();
        $coordinates = json_decode($json, true);
        $detector = $this->get('dangerous.level.detector');
        $disasters = $detector->detect($coordinates['coordinates']['latitude'], $coordinates['coordinates']['longitude']);
        return new JsonResponse($disasters);
    }
}