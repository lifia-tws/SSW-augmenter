<?php

namespace dv\SSW2014Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use dv\SSW2014Bundle\Entity\EntityCategory;
use dv\SSW2014Bundle\Form\EntityCategoryType;

/**
 * EntityCategory controller.
 *
 */
class EntityCategoryController extends Controller
{

    /**
     * Lists all EntityCategory entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('dvSSW2014Bundle:EntityCategory')->findAll();

        return $this->render('dvSSW2014Bundle:EntityCategory:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new EntityCategory entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new EntityCategory();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('entity_category_show', array('id' => $entity->getId())));
        }

        return $this->render('dvSSW2014Bundle:EntityCategory:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a EntityCategory entity.
    *
    * @param EntityCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(EntityCategory $entity)
    {
        $form = $this->createForm(new EntityCategoryType(), $entity, array(
            'action' => $this->generateUrl('entity_category_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new EntityCategory entity.
     *
     */
    public function newAction()
    {
        $entity = new EntityCategory();
        $form   = $this->createCreateForm($entity);

        return $this->render('dvSSW2014Bundle:EntityCategory:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EntityCategory entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('dvSSW2014Bundle:EntityCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntityCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('dvSSW2014Bundle:EntityCategory:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing EntityCategory entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('dvSSW2014Bundle:EntityCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntityCategory entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('dvSSW2014Bundle:EntityCategory:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a EntityCategory entity.
    *
    * @param EntityCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EntityCategory $entity)
    {
        $form = $this->createForm(new EntityCategoryType(), $entity, array(
            'action' => $this->generateUrl('entity_category_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing EntityCategory entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('dvSSW2014Bundle:EntityCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntityCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('entity_category_edit', array('id' => $id)));
        }

        return $this->render('dvSSW2014Bundle:EntityCategory:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a EntityCategory entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('dvSSW2014Bundle:EntityCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EntityCategory entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('entity_category'));
    }

    /**
     * Creates a form to delete a EntityCategory entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entity_category_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
