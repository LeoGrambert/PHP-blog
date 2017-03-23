<?php

/* home.php */
class __TwigTemplate_ab88b43793954cf81da1a0d5e5dd83eac4395c19b1f03650a1e961484f626bed extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<?php
/**
 * User: leo
 * Date: 23/03/17
 * Time: 15:15
 */

\$title = \"Accueil\";

ob_start();

echo \$posts;
?>
    Voir une page article : <a href=\"/web/index.php/show?id=1\">Cliquez ici</a> (message issu de la vue)
<?php

\$content = ob_get_clean();

include 'layout.php';
";
    }

    public function getTemplateName()
    {
        return "home.php";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "home.php", "/home/leo/Documents/Dev/formaCPMDev_Blog/blog/views/templates/home.php");
    }
}
