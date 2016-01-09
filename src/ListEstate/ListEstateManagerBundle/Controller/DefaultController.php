<?php

namespace ListEstate\ListEstateManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('ListEstateListEstateManagerBundle:Default:index.html.twig');

    }

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $estatesFromDoctrine = $em->getRepository('ListEstateListEstateManagerBundle:Estate')->findAll();

        $estates = array();

        foreach ($estatesFromDoctrine as $estate) {
            $location = json_decode($estate->getLocation());
            //print_r($location);
            $estates[$estate->getId()] = array(
                "id" => $estate->getId(),
                "name" => $estate->getName(),
                "image" => $estate->getImage(),
                "builder" => $estate->getBuilder(),
                "areaLatLong" =>[$location->location->latitude,$location->location->longitude],
                "price" => $estate->getPrice(),
                "amenities" => (array) json_decode($estate->getAmenities()),
                "color" => $estate->getColor(),
                "type" => $estate->getType()
            );
        }

        return new JsonResponse($estates);
    }
}
