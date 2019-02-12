<?php

namespace Modera\SecurityBundle;

use Modera\SecurityBundle\DependencyInjection\MailServiceAliasCompilerPass;
use Sli\ExpanderBundle\Ext\ExtensionPoint;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author    Sergei Vizel <sergei.vizel@modera.org>
 * @copyright 2014 Modera Foundation
 */
class ModeraSecurityBundle extends Bundle
{
    const ROLE_ROOT_USER = 'ROLE_ROOT_USER';

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $permissionsProviders = new ExtensionPoint('modera_security.permissions');
        $permissionsProviders->setDescription(
            'Allows to contribute new permissions that later can be installed by modera:security:install-permissions command.'
        );
        $container->addCompilerPass($permissionsProviders->createCompilerPass());

        $permissionCategoriesProviders = new ExtensionPoint('modera_security.permission_categories');
        $permissionCategoriesProviders->setDescription('Allows to contribute new permission categories.');
        $container->addCompilerPass($permissionCategoriesProviders->createCompilerPass());

        $container->addCompilerPass(new MailServiceAliasCompilerPass());
    }
}
