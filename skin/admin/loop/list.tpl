{foreach $links as $link}
    <tr id="order_{$link.id}">
        <td><a class="toggleModal" data-toggle="modal" data-target="#edit-link" href="#{$link.id}">{$link.title}</a></td>
        <td>{if $link.url}<span class="fa fa-check"></span>{else}<span class="fa fa-warning"></span>{/if}</td>
        <td>{if $link.content}<span class="fa fa-check"></span>{else}<span class="fa fa-warning"></span>{/if}</td>
        <td>{if $link.blank}{#blank_y#|ucfirst}{else}{#blank_n#|ucfirst}{/if}</td>
        <td>{$link.ltype}</td>
        <td><a class="toggleModal" data-toggle="modal" data-target="#edit-link" href="#{$link.id}"><span class="fa fa-edit"></span></a></td>
        <td><a class="toggleModal" data-toggle="modal" data-target="#deleteModal" href="#{$link.id}"><span class="fa fa-trash-o"></span></a></td>
    </tr>
{/foreach}