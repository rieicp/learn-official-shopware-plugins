{extends file="parent:frontend/routing_demo/index.tpl"}

{block name="frontend_index_content"}
    {$smarty.block.parent}
    <p>extra text</p>

    {action module="widgets" controller="listing" action="topSeller"}
{/block}
