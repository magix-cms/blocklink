{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="styleSheet" append}
    {include file="css.tpl"}
{/block}
{block name="article:content"}
    {include file="nav.tpl"}
    <!-- Notifications Messages -->
    <div class="mc-message clearfix"></div>
    <p id="addbtn">
        <a class="toggleModal btn btn-primary" data-toggle="modal" data-target="#edit-link" href="#">
            <span class="fa fa-plus"></span>
            {#add_link_btn#|ucfirst}
        </a>
    </p>
    <!-- Maintenance Messages -->
    <p class="col-sm-12 alert alert-warning fade in">
        <span class="fa fa-warning"></span> Under development
    </p>
    <table class="table table-bordered table-condensed table-hover">
        <thead>
        <tr>
            <th>{#title_link#|ucfirst}</th>
            <th>{#link_link#|ucfirst}</th>
            <th>{#content_link#|ucfirst}</th>
            <th>{#blank_link#|ucfirst}</th>
            <th>{#ltype#|ucfirst}</th>
            <th><span class="fa fa-edit"></span></th>
            <th><span class="fa fa-trash-o"></span></th>
        </tr>
        </thead>
        <tbody id="list_link" class="ui-sortable">
        {if isset($links) && !empty($links)}
            {include file="loop/list.tpl" links=$links}
        {/if}
        {include file="no-entry.tpl" links=$links}
        </tbody>
    </table>
    <div class="modal fade" id="edit-link" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {include file="modal/edit.tpl"}
            </div>
        </div>
    </div>
    {include file="modal/delete.tpl"}
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}