<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Device;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use AppBundle\Entity\Sequence;
use AppBundle\Form\SequenceType;
use AppBundle\Entity\Notification;
//use AppBundle\Form\Notification;

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


        $events = $em->getRepository('AppBundle:Event')->findBySequence(null);

        return array(
            'entities' => $entities,
            'eventForm' => $eventForm->createView(),
            'events'  =>  $events
        );
    }

    /**
     * @Route("/sendEventsCurlPost", name="send_events_curl_post")
     * @Method("POST")
     */
    public function sendEventsCurlAction(Request $request)
    {
        //$events =  $request->request->get('event_check_list');

          $em = $this->getDoctrine()->getManager();
          $qb = $em->createQueryBuilder();
          $qb->select('m');
          $qb->from('AppBundle:Event', 'm');
          //$qb->where($qb->expr()->in('m.id', $events));
          //ArrayCollection
          $result = $qb->getQuery()->getResult();
          $events = array();
          //$serializer = $this->container->get('jms_serializer');
          //
          $Devices = $em->getRepository('AppBundle:Device')->findAll();
          $devicesTokens = "";
          foreach ($Devices as $key => $value) {
            $devicesTokens =$devicesTokens.','. $Devices[$key]->getDeviceToken() ;
          }
          $devicesTokens = substr($devicesTokens,1);
          foreach ($result as $key => $value) {
            //$events [$key] =json_encode(array_values((array) $value),JSON_FORCE_OBJECT);
            $events [$key] = $value;
            //$events [$key] =json_encode($serializer->serialize($value, 'json'),JSON_FORCE_OBJECT);
          }
          $devicesTokens = str_replace( ',' , '","' , $devicesTokens );


          $notification = New Notification();
          $notification->setTitle($request->request->get('title'));
          $notification->setMessage($request->request->get('message'));
          $notification->setDate();
          $em = $this->getDoctrine()->getManager();
          $em->persist($notification);
          $em->flush();

          $cmd = '  curl -u 485d490dd0720a823c518fb6d39d73623ddff1f0487764a4: -H "Content-Type: application/json" -H "X-Ionic-Application-Id: 9cea62b6" https://push.ionic.io/api/v1/push -d \'{"tokens": ["'.$devicesTokens.'"],"production": false, "notification":{  "alert":"'.$request->request->get('message').'", "title": "'.$request->request->get('title').'","android": {"payload":""}, "ios": {"payload": ""}}}\' ';
          exec($cmd);
//          echo $cmd;
//          die;

          $notifications = $em->getRepository('AppBundle:Notification')->find( $notification->getId() );

          $serializer = $this->container->get('serializer');
          $reports = $serializer->serialize($notifications, 'json');
          return new Response($reports);


    }


      /**
       * @Route("/send", name="send")
       * @Method("GET")
       * @Template()
       */
      public function sendAction(Request $request)
      {

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Notification')->findAll();

        return array(
            'entities' => $entities,
        );

      }

}
