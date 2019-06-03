<?php

namespace SwagStartup;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Models\Media\Media;

class SwagStartup extends Plugin
{
    public function install(InstallContext $context)
    {
        $attrService = $this->container->get('shopware_attribute.crud_service');

        $attrService->update(//该方法不是修改表格列的取值类型，而是修改后台输入域的类型
            's_articles_attributes',
            'alt_image',
            'single_selection',//Backend的输入域的类型（类似TYPO3的PCA中的定义）
            [
                'displayInBackend' => true,
                'label' => 'Alternatives Bild',
                'entity' => Media::class //Shopware\Models\Media\Media类
            ]
        );
    }

    public function uninstall(UninstallContext $context)
    {
        if($context->keepUserData()) {//若用户卸载时想保留数据
            return;
        }

        $attrService = $this->container->get('shopware_attribute.crud_service');

        //首先查询表格是否存在该列
        if ($attrService->get('s_articles_attributes','alt_image')) {
            $attrService->delete(//在此只是示例delete方法，实际上，如果删除了表格的'alt_image'列，在产品列表中根本不会显示任何产品（Bug!）
                's_articles_attributes',
                'alt_image');
        }

        $context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);//清空与该plugin相关的模板等的缓存，CACHE_LIST_ALL常量的定义可以在InstallContext类源代码中查看
    }

}