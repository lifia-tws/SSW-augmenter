<?php

/* dvSSW2014Bundle::layout.html.twig */
class __TwigTemplate_2f992cdf4c6ea50c28f861788a7c21eb8f491f7c3ce02dd00e700ca63f21d0df extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
  <head>
    <title>
      SSW2014 - Query API
    </title>
    <link rel=\"stylesheet\" href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/dvssw2014/css/bootstrap.min.css"), "html", null, true);
        echo "\" type=\"text/css\" media=\"all\" />
  </head>
  <body>
    <div>       
      ";
        // line 10
        $this->displayBlock('body', $context, $blocks);
        // line 12
        echo "    </div>
  </body>
</html>
";
    }

    // line 10
    public function block_body($context, array $blocks = array())
    {
        // line 11
        echo "      ";
    }

    public function getTemplateName()
    {
        return "dvSSW2014Bundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 11,  43 => 10,  36 => 12,  34 => 10,  27 => 6,  20 => 1,  90 => 37,  82 => 31,  70 => 25,  64 => 22,  57 => 18,  51 => 17,  48 => 16,  44 => 15,  31 => 4,  28 => 3,);
    }
}
