<?php
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Device;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Event controller.
 *
 * @Route("/register")
 */
class RegistrationController extends Controller
{
    /**
      * create or update a device (the ID is email field)
     * @Route("/create")
     */
     public function createAction(Request $request)
     {
         //$lastName =  $request->request->get('lastName');
         //$firstName = $request->request->get('firstName');
         //$email = $request->request->get('email');
         $deviceToken = $request->request->get('deviceToken');
         $deviceId = $request->request->get('deviceId');
           $em = $this->getDoctrine()->getManager();
           $entity = $em->getRepository('AppBundle:Device')->findOneBy(array('deviceId' => $deviceId));
         if(!$entity){
                 $device = New Device();
//                 $device->setLastName($lastName);
  //               $device->setFirstName($firstName);
    //             $device->setEmail($email);
                 $device->setDeviceToken($deviceToken);
                 $device->setDeviceId($deviceId);
                 $em = $this->getDoctrine()->getManager();
                 $em->persist($device);
                 $em->flush();
                 return new JsonResponse(array('registerResponse' =>$deviceId));
         }else{
             $entity->setDeviceToken($deviceToken);
             $em->merge($entity);
             $em->flush();
             return new JsonResponse(array('registerResponse' => "ok-update"));
         }
     }
}
