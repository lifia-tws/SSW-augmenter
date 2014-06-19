<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/query')) {
            // query
            if (rtrim($pathinfo, '/') === '/query') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'query');
                }

                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\QueryController::indexAction',  '_route' => 'query',);
            }

            // query_all
            if ($pathinfo === '/query/all.json') {
                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\QueryController::allAction',  '_route' => 'query_all',);
            }

            // query_load_queries
            if ($pathinfo === '/query/loadQueries') {
                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\QueryController::loadQueriesAction',  '_route' => 'query_load_queries',);
            }

            // query_show
            if (preg_match('#^/query/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'query_show')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\QueryController::showAction',));
            }

            // query_new
            if ($pathinfo === '/query/new') {
                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\QueryController::newAction',  '_route' => 'query_new',);
            }

            // query_create
            if ($pathinfo === '/query/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_query_create;
                }

                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\QueryController::createAction',  '_route' => 'query_create',);
            }
            not_query_create:

            // query_edit
            if (preg_match('#^/query/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'query_edit')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\QueryController::editAction',));
            }

            // query_update
            if (preg_match('#^/query/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_query_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'query_update')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\QueryController::updateAction',));
            }
            not_query_update:

            // query_delete
            if (preg_match('#^/query/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_query_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'query_delete')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\QueryController::deleteAction',));
            }
            not_query_delete:

        }

        if (0 === strpos($pathinfo, '/topic')) {
            // topic
            if (rtrim($pathinfo, '/') === '/topic') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'topic');
                }

                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\TopicController::indexAction',  '_route' => 'topic',);
            }

            // topic_show
            if (preg_match('#^/topic/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'topic_show')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\TopicController::showAction',));
            }

            // topic_new
            if ($pathinfo === '/topic/new') {
                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\TopicController::newAction',  '_route' => 'topic_new',);
            }

            // topic_create
            if ($pathinfo === '/topic/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_topic_create;
                }

                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\TopicController::createAction',  '_route' => 'topic_create',);
            }
            not_topic_create:

            // topic_edit
            if (preg_match('#^/topic/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'topic_edit')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\TopicController::editAction',));
            }

            // topic_update
            if (preg_match('#^/topic/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_topic_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'topic_update')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\TopicController::updateAction',));
            }
            not_topic_update:

            // topic_delete
            if (preg_match('#^/topic/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_topic_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'topic_delete')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\TopicController::deleteAction',));
            }
            not_topic_delete:

        }

        // dv_ssw2014_homepage
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'dv_ssw2014_homepage')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\DefaultController::indexAction',));
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
