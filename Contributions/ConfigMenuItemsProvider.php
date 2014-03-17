<?php

namespace Modera\JSRuntimeIntegrationBundle\Contributions;

use Modera\JSRuntimeIntegrationBundle\Menu\MenuItem;
use Modera\JSRuntimeIntegrationBundle\Menu\MenuItemInterface;
use Sli\ExpanderBundle\Ext\ContributorInterface;
use Sli\ExpanderBundle\Ext\OrderedContributorInterface;

/**
 * Contributes js-runtime menu items based on a config defined in "modera_js_runtime_integration" namespace.
 *
 * @see \Modera\JSRuntimeIntegrationBundle\DependencyInjection\Configuration
 *
 * @author    Sergei Lissovski <sergei.lissovski@modera.org>
 * @copyright 2014 Modera Foundation
 */
class ConfigMenuItemsProvider implements ContributorInterface
{
    private $items = array();

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (!isset($config['menu_items']) || !is_array($config['menu_items'])) {
            throw new \InvalidArgumentException('Given "$config" doesn\'t have key "menu_items" or it is not array!.');
        }

        foreach ($config['menu_items'] as $menuItem) {
            $controller = str_replace('$ns', $menuItem['namespace'], $menuItem['controller']);

            $this->items[] = new MenuItem($menuItem['name'], $controller, $menuItem['id'], array(
                MenuItemInterface::META_NAMESPACE => $menuItem['namespace'],
                MenuItemInterface::META_NAMESPACE_PATH => $menuItem['path']
            ));
        }
    }

    /**
     * @inheritDoc
     */
    public function getItems()
    {
        return $this->items;
    }

    static public function clazz()
    {
        return get_called_class();
    }
}