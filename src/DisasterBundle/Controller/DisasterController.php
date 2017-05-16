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
            'requests' => [
                'Post request to detect disasters' => $this->get('serializer')->serialize(
                    [
                        'coordinates' => [
                            'latitude' => 12,
                            'longitude' => 12
                        ]
                    ], 'json'),
                'Limit parameter for detecting disasters' => 'url/some/some?limit=5'
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function detectDisasterAction(Request $request)
    {
        $limit = $request->query->getInt('limit');
        $json = $request->getContent();
        $coordinates = json_decode($json, true);
        $detector = $this->get('dangerous.level.detector');
        if ($limit) {
            $disasters = $detector->detect((float)$coordinates['coordinates']['latitude'], (float)$coordinates['coordinates']['longitude'], $limit);
        } else {
            $disasters = $detector->detect((float)$coordinates['coordinates']['latitude'], (float)$coordinates['coordinates']['longitude']);
        }
        return new JsonResponse($disasters);
    }
}