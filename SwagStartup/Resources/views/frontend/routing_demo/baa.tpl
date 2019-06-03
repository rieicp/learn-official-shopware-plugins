{extends file="parent:frontend/routing_demo/index.tpl"}


{block name="frontend_index_sidebar"}
{/block}

{block name="frontend_index_content"}
    {$smarty.block.parent}

    <h3>product list</h3>
    <ul>
        {foreach $productNames as $productName}
            {*<li>{$productName['name']}</li>*}
            <li>{$productName}</li>
        {/foreach}
    </ul>
{/block}
