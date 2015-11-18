<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Sequence;
use AppBundle\Form\SequenceType;

/**
 * Sequence controller.
 *
 * @Route("/sequence")
 */
class SequenceController extends Controller
{

    /**
     * Lists all Sequence entities.
     *
     * @Route("/", name="sequence")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Sequence')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Sequence entity.
     *
     * @Route("/", name="sequence_create")
     * @Method("POST")
     * @Template("AppBundle:Sequence:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Sequence();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            foreach ($entity->getEvents() as $review) {
               $review->setSequence($entity);
           }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sequence_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Sequence entity.
     *
     * @param Sequence $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Sequence $entity)
    {
        $form = $this->createForm(new SequenceType(), $entity, array(
            'action' => $this->generateUrl('sequence_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Sequence entity.
     *
     * @Route("/new", name="sequence_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Sequence();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Sequence entity.
     *
     * @Route("/{id}", name="sequence_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Sequence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sequence entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Sequence entity.
     *
     * @Route("/{id}/edit", name="sequence_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Sequence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sequence entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Sequence entity.
    *
    * @param Sequence $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Sequence $entity)
    {
        $form = $this->createForm(new SequenceType(), $entity, array(
            'action' => $this->generateUrl('sequence_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Sequence entity.
     *
     * @Route("/{id}", name="sequence_update")
     * @Method("PUT")
     * @Template("AppBundle:Sequence:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Sequence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sequence entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect( $this->generateUrl('sequence') );
            //return $this->redirect($this->generateUrl('sequence_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Sequence entity.
     *
     * @Route("/{id}", name="sequence_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Sequence')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Sequence entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sequence'));
    }

    /**
     * Creates a form to delete a Sequence entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sequence_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
