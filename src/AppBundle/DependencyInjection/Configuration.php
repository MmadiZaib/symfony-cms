<?php


namespace AppBundle\DependencyInjection;


use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('app');


        //Here you should define the parameters that are allowed
        //to configure your bundle
        //more information on that topic. See the documentation
        return $treeBuilder;

    }
}