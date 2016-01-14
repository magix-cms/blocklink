{$search_results|var_dump}
{*{if isset($search_results) && is_array($search_results)}
	{if isset($search_results.results) && is_array($search_results.results) && !empty($search_results.results)}
        {foreach $search_results.results as $place}
            <tr id="place-{$place.id}">
                <td>
                    <a href="/{getlang}/catalogue/{$place.idcat}-{$place.curi}/{$place.id}-{$place.suri}/">{$place.name} <small>- {$place.root}</small></a>
                </td>
            </tr>
        {/foreach}
	{/if}
{/if}*}
