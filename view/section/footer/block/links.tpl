{widget_blocklink_data}
{if isset($links) && is_array($links) && !empty($links)}
    <div id="block-links" class="block{if isset($classCol)}{$classCol}{/if}">
        <h4>{#block_cms#|ucfirst}</h4>
        <ul class="list-unstyled">
            {foreach $links as $link}
                <li>
                    <a{if $link.blank} class="targetblank" {/if} href="{$link.url}" title="{if $link.content}{$link.content}{else}{$link.title|ucfirst}{/if}">{$link.title|ucfirst}</a>
                </li>
            {/foreach}
        </ul>
    </div>
{/if}