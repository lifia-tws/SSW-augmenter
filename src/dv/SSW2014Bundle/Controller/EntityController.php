<?php

namespace dv\SSW2014Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use dv\SSW2014Bundle\Entity\Entity;
use dv\SSW2014Bundle\Form\EntityType;

/**
 * Entity controller.
 *
 */
class EntityController extends Controller
{

    /**
     * Lists all Entity entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('dvSSW2014Bundle:Entity')->findAll();

        return $this->render('dvSSW2014Bundle:Entity:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Entity entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Entity();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('entity_show', array('id' => $entity->getId())));
        }

        return $this->render('dvSSW2014Bundle:Entity:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Entity entity.
    *
    * @param Entity $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Entity $entity)
    {
        $form = $this->createForm(new EntityType(), $entity, array(
            'action' => $this->generateUrl('entity_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Entity entity.
     *
     */
    public function newAction()
    {
        $entity = new Entity();
        $form   = $this->createCreateForm($entity);

        return $this->render('dvSSW2014Bundle:Entity:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Entity entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('dvSSW2014Bundle:Entity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entity entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('dvSSW2014Bundle:Entity:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Entity entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('dvSSW2014Bundle:Entity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entity entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('dvSSW2014Bundle:Entity:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Entity entity.
    *
    * @param Entity $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Entity $entity)
    {
        $form = $this->createForm(new EntityType(), $entity, array(
            'action' => $this->generateUrl('entity_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Entity entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('dvSSW2014Bundle:Entity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entity entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('entity_edit', array('id' => $id)));
        }

        return $this->render('dvSSW2014Bundle:Entity:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Entity entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('dvSSW2014Bundle:Entity')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entity entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('entity'));
    }

    /**
     * Creates a form to delete a Entity entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entity_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
