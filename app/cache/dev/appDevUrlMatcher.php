<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
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

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                if (0 === strpos($pathinfo, '/_profiler/i')) {
                    // _profiler_info
                    if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                    }

                    // _profiler_import
                    if ($pathinfo === '/_profiler/import') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:importAction',  '_route' => '_profiler_import',);
                    }

                }

                // _profiler_export
                if (0 === strpos($pathinfo, '/_profiler/export') && preg_match('#^/_profiler/export/(?P<token>[^/\\.]++)\\.txt$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_export')), array (  '_controller' => 'web_profiler.controller.profiler:exportAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/category')) {
            // category_like
            if ($pathinfo === '/category/like') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_category_like;
                }

                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\CategoryController::likeAction',  '_route' => 'category_like',);
            }
            not_category_like:

            // category
            if (rtrim($pathinfo, '/') === '/category') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'category');
                }

                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\CategoryController::indexAction',  '_route' => 'category',);
            }

            // category_show
            if (preg_match('#^/category/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_show')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\CategoryController::showAction',));
            }

            // category_new
            if ($pathinfo === '/category/new') {
                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\CategoryController::newAction',  '_route' => 'category_new',);
            }

            // category_create
            if ($pathinfo === '/category/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_category_create;
                }

                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\CategoryController::createAction',  '_route' => 'category_create',);
            }
            not_category_create:

            // category_edit
            if (preg_match('#^/category/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_edit')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\CategoryController::editAction',));
            }

            // category_update
            if (preg_match('#^/category/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_category_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_update')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\CategoryController::updateAction',));
            }
            not_category_update:

            // category_delete
            if (preg_match('#^/category/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_category_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_delete')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\CategoryController::deleteAction',));
            }
            not_category_delete:

        }

        if (0 === strpos($pathinfo, '/entity')) {
            // entity_queries
            if ($pathinfo === '/entity/queries') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_entity_queries;
                }

                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityController::queriesAction',  '_route' => 'entity_queries',);
            }
            not_entity_queries:

            // entity_suggest_category
            if ($pathinfo === '/entity/suggestCategory') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_entity_suggest_category;
                }

                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityController::suggestCategoryAction',  '_route' => 'entity_suggest_category',);
            }
            not_entity_suggest_category:

            // entity_categories
            if ($pathinfo === '/entity/categories') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_entity_categories;
                }

                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityController::categoriesAction',  '_route' => 'entity_categories',);
            }
            not_entity_categories:

            // entity
            if (rtrim($pathinfo, '/') === '/entity') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'entity');
                }

                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityController::indexAction',  '_route' => 'entity',);
            }

            // entity_show
            if (preg_match('#^/entity/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'entity_show')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityController::showAction',));
            }

            // entity_new
            if ($pathinfo === '/entity/new') {
                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityController::newAction',  '_route' => 'entity_new',);
            }

            // entity_create
            if ($pathinfo === '/entity/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_entity_create;
                }

                return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityController::createAction',  '_route' => 'entity_create',);
            }
            not_entity_create:

            // entity_edit
            if (preg_match('#^/entity/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'entity_edit')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityController::editAction',));
            }

            // entity_update
            if (preg_match('#^/entity/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_entity_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'entity_update')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityController::updateAction',));
            }
            not_entity_update:

            // entity_delete
            if (preg_match('#^/entity/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_entity_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'entity_delete')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityController::deleteAction',));
            }
            not_entity_delete:

            if (0 === strpos($pathinfo, '/entity_category')) {
                // entity_category
                if (rtrim($pathinfo, '/') === '/entity_category') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'entity_category');
                    }

                    return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityCategoryController::indexAction',  '_route' => 'entity_category',);
                }

                // entity_category_show
                if (preg_match('#^/entity_category/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'entity_category_show')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityCategoryController::showAction',));
                }

                // entity_category_new
                if ($pathinfo === '/entity_category/new') {
                    return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityCategoryController::newAction',  '_route' => 'entity_category_new',);
                }

                // entity_category_create
                if ($pathinfo === '/entity_category/create') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_entity_category_create;
                    }

                    return array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityCategoryController::createAction',  '_route' => 'entity_category_create',);
                }
                not_entity_category_create:

                // entity_category_edit
                if (preg_match('#^/entity_category/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'entity_category_edit')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityCategoryController::editAction',));
                }

                // entity_category_update
                if (preg_match('#^/entity_category/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                        $allow = array_merge($allow, array('POST', 'PUT'));
                        goto not_entity_category_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'entity_category_update')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityCategoryController::updateAction',));
                }
                not_entity_category_update:

                // entity_category_delete
                if (preg_match('#^/entity_category/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                        $allow = array_merge($allow, array('POST', 'DELETE'));
                        goto not_entity_category_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'entity_category_delete')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\EntityCategoryController::deleteAction',));
                }
                not_entity_category_delete:

            }

        }

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

        // dv_ssw2014_homepage
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'dv_ssw2014_homepage')), array (  '_controller' => 'dv\\SSW2014Bundle\\Controller\\DefaultController::indexAction',));
        }

        // _welcome
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', '_welcome');
            }

            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\WelcomeController::indexAction',  '_route' => '_welcome',);
        }

        if (0 === strpos($pathinfo, '/demo')) {
            if (0 === strpos($pathinfo, '/demo/secured')) {
                if (0 === strpos($pathinfo, '/demo/secured/log')) {
                    if (0 === strpos($pathinfo, '/demo/secured/login')) {
                        // _demo_login
                        if ($pathinfo === '/demo/secured/login') {
                            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::loginAction',  '_route' => '_demo_login',);
                        }

                        // _security_check
                        if ($pathinfo === '/demo/secured/login_check') {
                            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::securityCheckAction',  '_route' => '_security_check',);
                        }

                    }

                    // _demo_logout
                    if ($pathinfo === '/demo/secured/logout') {
                        return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::logoutAction',  '_route' => '_demo_logout',);
                    }

                }

                if (0 === strpos($pathinfo, '/demo/secured/hello')) {
                    // acme_demo_secured_hello
                    if ($pathinfo === '/demo/secured/hello') {
                        return array (  'name' => 'World',  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloAction',  '_route' => 'acme_demo_secured_hello',);
                    }

                    // _demo_secured_hello
                    if (preg_match('#^/demo/secured/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_demo_secured_hello')), array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloAction',));
                    }

                    // _demo_secured_hello_admin
                    if (0 === strpos($pathinfo, '/demo/secured/hello/admin') && preg_match('#^/demo/secured/hello/admin/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_demo_secured_hello_admin')), array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloadminAction',));
                    }

                }

            }

            // _demo
            if (rtrim($pathinfo, '/') === '/demo') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', '_demo');
                }

                return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::indexAction',  '_route' => '_demo',);
            }

            // _demo_hello
            if (0 === strpos($pathinfo, '/demo/hello') && preg_match('#^/demo/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_demo_hello')), array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::helloAction',));
            }

            // _demo_contact
            if ($pathinfo === '/demo/contact') {
                return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::contactAction',  '_route' => '_demo_contact',);
            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
