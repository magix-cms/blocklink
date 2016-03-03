{if isset($search_results) && is_array($search_results)}
    {$section = ($type == 'cat') ? 'catalog' : 'pages'}
    {foreach $search_results as $rslt}
        <tr class="link" data-name="{$rslt.name}" data-url="/{$iso}/{$section}/{if isset($rslt.parent) && $rslt.parent}{$rslt.parent}-{$rslt.uriparent}/{/if}{$rslt.id}-{$rslt.uri}/">
            <td>{$rslt.id}</td>
            <td>{$rslt.name}{if isset($rslt.parent) && $rslt.parent} <small>&mdash;&nbsp;{$rslt.parent}.&nbsp;{$rslt.nameparent}</small>{/if}</td>
        </tr>
    {/foreach}
{/if}
