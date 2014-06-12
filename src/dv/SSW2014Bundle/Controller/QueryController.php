<?php

namespace dv\SSW2014Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use dv\SSW2014Bundle\Entity\Query;
use dv\SSW2014Bundle\Form\QueryType;

/**
 * Query controller.
 *
 */
class QueryController extends Controller
{
    public function loadQueriesAction()
    {        
        $em = $this->getDoctrine()->getManager();
        $r = $this->getDoctrine()->getRepository('dvSSW2014Bundle:Query');

        if ($r->findOneBy(array('name' => 'peopleSameAgeSameCountry')) == null)
        {
            $peopleSameAgeSameCountry = new Query();
            $peopleSameAgeSameCountry->setName('peopleSameAgeSameCountry');
            $peopleSameAgeSameCountry->setTemplate('select distinct ?name, ?isPrimaryTopicOf { ?subject foaf:isPrimaryTopicOf <%%isPrimaryTopicOf%%> . ?subject dbpedia-owl:birthYear ?birthYear . ?subject dbpedia-owl:birthPlace ?birthPlace . ?birthPlace a dbpedia-owl:Country . ?relatedSubject a dbpedia-owl:Person . ?relatedSubject dbpedia-owl:birthYear ?birthYear . ?relatedSubject dbpedia-owl:birthPlace ?birthPlace . ?relatedSubject foaf:name ?name . ?relatedSubject foaf:isPrimaryTopicOf ?isPrimaryTopicOf } order by ?name limit 10 offset %%offset%%');
            $peopleSameAgeSameCountry->setCreatedAt(new \DateTime('today'));

            $em->persist($peopleSameAgeSameCountry);
        }


        if ($r->findOneBy(array('name' => 'citiesInThisCountry')) == null)
        {
            $citiesInThisCountry = new Query();
            $citiesInThisCountry->setName('citiesInThisCountry');
            $citiesInThisCountry->setTemplate('select distinct ?name, ?isPrimaryTopicOf { ?subject foaf:isPrimaryTopicOf <%%isPrimaryTopicOf%%> . ?relatedSubject dbpedia-owl:country ?subject . ?relatedSubject a dbpedia-owl:City . ?relatedSubject foaf:name ?name . ?relatedSubject foaf:isPrimaryTopicOf ?isPrimaryTopicOf } order by ?name limit 10 offset %%offset%%');
            $citiesInThisCountry->setCreatedAt(new \DateTime('today'));

            $em->persist($citiesInThisCountry);
        }


        if ($r->findOneBy(array('name' => 'semanticPropertiesAsSubject')) == null)
        {
            $semanticPropertiesAsSubject = new Query();
            $semanticPropertiesAsSubject->setName('semanticPropertiesAsSubject');
            $semanticPropertiesAsSubject->setTemplate('select distinct ?property { ?subject foaf:isPrimaryTopicOf <%%isPrimaryTopicOf%%> . ?resource a ?subject . ?resource ?property ?object } order by ?property limit 10 offset %%offset%%');
            $semanticPropertiesAsSubject->setCreatedAt(new \DateTime('today'));

            $em->persist($semanticPropertiesAsSubject);
        }


        if ($r->findOneBy(array('name' => 'semanticPropertiesAsObject')) == null)
        {
            $semanticPropertiesAsObject = new Query();
            $semanticPropertiesAsObject->setName('semanticPropertiesAsObject');
            $semanticPropertiesAsObject->setTemplate('select distinct ?property { ?subject foaf:isPrimaryTopicOf <%%isPrimaryTopicOf%%> . ?resource a ?subject . ?resource ?property ?object } order by ?property limit 10 offset %%offset%%');
            $semanticPropertiesAsObject->setCreatedAt(new \DateTime('today'));

            $em->persist($semanticPropertiesAsObject);
        }

        $em->flush();

        echo "Queries added succesfully!";

        die();
    }

    /**
     * Lists all Query entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('dvSSW2014Bundle:Query')->findAll();

        return $this->render('dvSSW2014Bundle:Query:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function putAction(Request $request)
    {
      $entity = new Query();

      $response = new Response(json_encode($json));

      $response->headers->set('Content-Type', 'application/json');

      return $response;
      

    }

    /**
     * Creates a new Query entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Query();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('query_show', array('id' => $entity->getId())));
        }

        return $this->render('dvSSW2014Bundle:Query:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Query entity.
    *
    * @param Query $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Query $entity)
    {
        $form = $this->createForm(new QueryType(), $entity, array(
            'action' => $this->generateUrl('query_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Query entity.
     *
     */
    public function newAction()
    {
        $entity = new Query();
        $form   = $this->createCreateForm($entity);

        return $this->render('dvSSW2014Bundle:Query:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('dvSSW2014Bundle:Query')->findAll();

        $queries = array();

        foreach ($entities as $entity)
        {
          $queries[] = $entity->toJSON();
        }

        $json = array(
          'status' => 'success',
          'data' => array(
            'queries' => $queries
          )
        );

        $response = new Response(json_encode($json));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function oneAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('dvSSW2014Bundle:Query')->find($id);

        $json = array(
          'status' => 'success',
          'data' => array(
            'query' => $entity->toJSON()
          )
        );

        $response = new Response(json_encode($json));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Finds and displays a Query entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('dvSSW2014Bundle:Query')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Query entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('dvSSW2014Bundle:Query:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Query entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('dvSSW2014Bundle:Query')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Query entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('dvSSW2014Bundle:Query:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Query entity.
    *
    * @param Query $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Query $entity)
    {
        $form = $this->createForm(new QueryType(), $entity, array(
            'action' => $this->generateUrl('query_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Query entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('dvSSW2014Bundle:Query')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Query entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('query_edit', array('id' => $id)));
        }

        return $this->render('dvSSW2014Bundle:Query:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Query entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('dvSSW2014Bundle:Query')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Query entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('query'));
    }

    /**
     * Creates a form to delete a Query entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('query_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
