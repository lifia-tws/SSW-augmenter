<?php

namespace dv\SSW2014Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use dv\SSW2014Bundle\Entity\Entity;
use dv\SSW2014Bundle\Entity\Category;
use dv\SSW2014Bundle\Entity\EntityCategory;

use dv\SSW2014Bundle\Form\EntityType;

use Doctrine\Common\Util\Inflector;

/**
 * Entity controller.
 *
 */
class EntityController extends Controller
{
  public function queriesAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $entityArticle = $request->get('entityArticle');

    if (!$entityArticle)
    {
      return new JsonResponse(array(
        'status' => 'fail',
        'data' => array('message' => 'Not enough arguments.')
      ));    
    }

    $queries = array();

    foreach ($em->getRepository('dvSSW2014Bundle:Query')->findAll() as $query)
    {
      $queries[] = $query->toJSON();
    }

    return new JsonResponse(array(
      'status' => 'success',
      'data' => array('queries' => $queries)
    ));
  }

  public function suggestCategoryAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $entityArticle = $request->get('entityArticle');
    $categoryName = $request->get('categoryName');

    if (!$entityArticle || !$categoryName)
    {
      return new JsonResponse(array(
        'status' => 'fail',
        'data' => array('message' => 'Not enough arguments.')
      ));    
    }

    $entity = $em->getRepository('dvSSW2014Bundle:Entity')->findOneBy(array('article' => $entityArticle));

    if (!$entity)
    {
      $entity = new Entity();
      $entity->setResource(Inflector::camelize($entityArticle));
      $entity->setArticle($entityArticle);  

      $em->persist($entity); 
    }
  
    $category = $em->getRepository('dvSSW2014Bundle:Category')->findOneBy(array('name' => $categoryName));

    if (!$category)
    {
      $category = new Category();
      $category->setName($categoryName);   

      $em->persist($category);   
    }

    $em->flush();     

    if ($entity_category = $em->getRepository('dvSSW2014Bundle:EntityCategory')->findOneBy(array('entity' => $entity, 'category' => $category)))
    {
      return new JsonResponse(array(
        'status' => 'fail',
        'data' => array('message' => 'Category already exists.')
      ));    
    }
    else
    {
      $entity_category = new EntityCategory();
      $entity_category->setEntity($entity);
      $entity_category->setCategory($category);
      $entity_category->setRating(1);
    }

    $em->persist($entity_category);

    $em->flush();     

    return new JsonResponse(array(
      'status' => 'success',
      'data' => array('category' => $category->toJSON())
    ));    
  }

  public function categoriesAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $entityArticle = $request->get('entityArticle');

    if (!$entityArticle)
    {
      return new JsonResponse(array(
        'status' => 'fail',
        'data' => array('message' => 'Not enough arguments.')
      ));    
    }

    $entity = $em->getRepository('dvSSW2014Bundle:Entity')->findOneBy(array('article' => $entityArticle));

    if (!$entity)
    {
      $entity = new Entity();
      $entity->setResource('test');
      $entity->setArticle($entityArticle);  

      $em->persist($entity);
    }

    $categories = array();

    foreach ($entity->getEntityCategories() as $entity_category)
    {
      $categories[] = $entity_category->getCategory()->toJSON();
    }

    if (count($categories) == 0)
    {
      return new JsonResponse(array(
        'status' => 'fail',
        'data' => array('message' => 'No categories available.')
      ));    
    }

    return new JsonResponse(array(
      'status' => 'success',
      'data' => array('categories' => $categories)
    ));
  }

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
