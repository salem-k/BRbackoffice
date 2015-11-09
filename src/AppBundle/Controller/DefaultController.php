<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Entity\Event;
use AppBundle\Form\EventType;

use AppBundle\Entity\Sequence;
use AppBundle\Form\SequenceType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Sequence')->findAll();

        $eventForm = $this->createForm(new EventType(), new Event() , array(
            'action' => $this->generateUrl('event_create'),
            'method' => 'POST',
        ));

        return array(
            'entities' => $entities,
            'eventForm' => $eventForm->createView()
        );
    }
}
