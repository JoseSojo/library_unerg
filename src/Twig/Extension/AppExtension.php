<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;
use Twig\Environment;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\FormFactoryInterface;
use App\AppGlobal;
use App\Services\Util\CurrencyUtil;

/**
 * Extension app
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class AppExtension extends AbstractExtension 
{
    private $twig;

    private $requestStack;
    
    private $formFactory;

    public function __construct(Environment $twig, RequestStack $requestStack, FormFactoryInterface $formFactory)
    {
        $this->twig = $twig;
        $this->requestStack = $requestStack;
        $this->formFactory = $formFactory;
    }

    public function getName() 
    {
        return 'app_twig_extension';
    }

    public function getFilters()
    {
        return array(
            new TwigFilter('my_number_format_money', array($this, 'myNumberFormatMoney'))
        );
    }

	public function getFunctions() 
    {
        return [            
            new TwigFunction('print_title', array($this, 'printTitle'),array('is_safe' => ['html'])),
            new TwigFunction('print_info', array($this, 'printInfo'),array('is_safe' => ['html'])),
            new TwigFunction('render_search', array($this, 'renderSearch'),array('is_safe' => ['html'])),
            new TwigFunction('get_form_search', array($this, 'getFormSearch'),array('is_safe' => ['html'])),
            new TwigFunction('render_breadcrumb', array($this, 'renderBreadcrumb'),array('is_safe' => ['html'])),
        ];
    }

    /**
     * Formatea un monto
     * @param type $number
     * @param \App\Entity\M\Master\Term $currency
     * @param type $decimals
     * @return string
     */
    function myNumberFormatMoney($number,\App\Entity\M\Master\Term $currency,$decimals = null)
    {
        return CurrencyUtil::money($currency, $number, $decimals);
    }

    public function printTitle($parameters)
    {
        $baseParameters = [
            "icon" => null,
        ];
        
        $parameters = array_merge($baseParameters,$parameters);
        $template = "layouts/components/functions/title.html.twig";        
        return $this->render($template, 
            [
                'parameters' => $parameters,
            ]
        );
    }

    public function printInfo($parameters)
    {
        $baseParameters = [
            "icon" => null,
        ];
        
        $parameters = array_merge($baseParameters,$parameters);
        $template = "layouts/components/functions/info.html.twig";        
        return $this->render($template, 
            [
                'parameters' => $parameters,
            ]
        );
    }

    /**
     * Renderiza formulario de busqueda
     *
     * @param   $key
     *
     * @return  View | Template
     */
    public function renderSearch($key)
    {
        $parameters = [];
        $template = "layouts/components/features/search.html.twig";        
        return $this->render($template, 
            [
                'parameters' => $parameters,
                "key" => $key
            ]
        );
    }

    /**
     * Retorna formulario de busqueda
     *
     * @param   $key
     * @return  Form
     */
    public function getFormSearch($key)
    {
        $request = $this->requestStack->getCurrentRequest();

        $form = $this->createForm(AppGlobal::getSearchForm()[$key]);
        $form->handleRequest($request);

        return $form->createView();
    }

    /**
     * Renderiza las acciones
     *
     * @param   $key
     *
     * @return  View | Template
     */
    public function renderBreadcrumb(array $parameters = array())
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            "items" => [],
            "buttons" => [],
            "search" => [
                "enabled" => false,
                "chain" =>  null
            ],
            "export" => [
                "chain" =>  null,
                "pdf" => [
                    "enabled" => false
                ],
                "xls" => [
                    "enabled" => false
                ]
            ]
        ]);
        $parameters = $resolver->resolve($parameters);

        return $this->render("layouts/components/features/breadcrumb.html.twig",$parameters);
    }

    /**
     * Renderiza vista
     *
     * @param   $template
     * @param   $parameters
     *
     * @return  View
     */
    private function render($template,$parameters)
    {
        return $this->twig->render($template,$parameters);
    }

    /**
     * Creates and returns a Form instance from the type of the form.
     */
    protected function createForm(string $type, $data = null, array $options = []): FormInterface
    {
        return $this->formFactory->create($type, $data, $options);
    }
}