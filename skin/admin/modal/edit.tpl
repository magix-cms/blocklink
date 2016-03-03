            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">{if isset($link)}{#edit_link#|ucfirst}{else}{#add_link#|ucfirst}{/if}</h4>
            </div>
            <form id="edit_link" method="post" action="">
                <div class="modal-body row">
                    <div class="form-group col-xs-12">
                        <label for="type">{#type_link#|ucfirst}&nbsp;*</label>
                        <select name="type" id="type" class="form-control">
                            <option value="custom"{if (isset($link.ltype) && $link.ltype eq 'custom') || !isset($link.ltype)} selected{/if} href="#custom-link" aria-controls="custom" role="tab" data-toggle="tab">{#custom_type_link#|ucfirst}</option>
                            {if $config_cms eq 1}
                            <option value="cms"{if isset($link.ltype) && $link.ltype eq 'cms'} selected{/if} href="#cms-link" aria-controls="cms" role="tab" data-toggle="tab">{#cms_type_link#|ucfirst}</option>
                            {/if}
                            {if $config_catalog eq 1}
                            <option value="cat"{if isset($link.ltype) && $link.ltype eq 'cat'} selected{/if} href="#cat-link" aria-controls="catalog" role="tab" data-toggle="tab">{#cat_type_link#|ucfirst}</option>
                            {/if}
                        </select>
                    </div>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade{if (isset($link.ltype) && $link.ltype eq 'custom') || !isset($link.ltype)} in active{/if}" id="custom-link"></div>
                        {if $config_cms eq 1}
                        <div role="tabpanel" class="tab-pane fade{if isset($link.ltype) && $link.ltype eq 'cms'} in active{/if}" id="cms-link">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="search_cms">Rechercher une page&nbsp;:</label>
                                    <div class="search-box">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="cms-search">
                                                <span class="fa fa-search"></span>
                                                <a href="#" class="fa fa-times hide clear"><span class="sr-only">Effacer filtre</span></a>
                                            </span>
                                            <input type="search" class="form-control" name="cms"
                                                   placeholder="Titre de la page ou page enfant"
                                                   aria-describedby="cms-search"
                                                   id="search_cms"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="search-results hide">
                                    <table class="table table-bordered table-responsive table-hover">
                                        <tbody id="list_cms">
                                        <tr id="no-cms" class="hide">
                                            <td colspan="3">
                                                <p class="alert alert-warning" role="alert">
                                                    <span class="fa fa-info"></span> Aucune page ne correspond à votre recherche.
                                                </p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {/if}
                        {if $config_catalog eq 1}
                        <div role="tabpanel" class="tab-pane fade{if isset($link.ltype) && $link.ltype eq 'cat'} in active{/if}" id="cat-link">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="search_cat">Rechercher une catégorie&nbsp;:</label>
                                    <div class="search-box">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="cat-search">
                                                <span class="fa fa-search"></span>
                                                <a href="#" class="fa fa-times hide clear"><span class="sr-only">Effacer filtre</span></a>
                                            </span>
                                            <input type="search" class="form-control" name="cat"
                                                   placeholder="Titre de la catégorie ou sous-catégorie"
                                                   aria-describedby="cat-search"
                                                   id="search_cat"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="search-results hide">
                                    <table class="table table-bordered table-responsive table-hover">
                                        <tbody id="list_cat">
                                        <tr id="no-cat" class="hide">
                                            <td colspan="3">
                                                <p class="alert alert-warning" role="alert">
                                                    <span class="fa fa-info"></span> Aucune catégorie ne correspond à votre recherche.
                                                </p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {/if}
                    </div>

                    <div class="form-group col-xs-12">
                        <label for="url">{#link_link#|ucfirst}&nbsp;*</label>
                        <input id="url" class="form-control" type="text" size="150" value="{$link.url}" name="url" />
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="title">{#title_link#|ucfirst}&nbsp;*</label>
                        <input id="title" class="form-control" type="text" size="150" value="{$link.title}" name="title" placeholder="{#title_link_ph#|ucfirst}" />
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="content">{#content_link#|ucfirst}</label>
                        <input id="content" class="form-control" type="text" size="150" value="{$link.content}" name="content" placeholder="{#content_link_ph#|ucfirst}" />
                    </div>

                    <div class="form-group">
                        <label for="blank" class="col-sm-3 control-label toggle-label">
                            {#blank_link#|ucfirst}
                        </label>
                        <div class="col-sm-2">
                            <div class="checkbox">
                                <label>
                                    <input{if isset($link.blank)}{if $link.blank} checked{/if}{/if} id="blank" name="blank" data-toggle="toggle" type="checkbox" data-on="{#blank_y#|ucfirst}" data-off="{#blank_n#|ucfirst}" data-onstyle="primary" data-offstyle="default" >
                                </label>
                            </div>
                        </div>
                        <p class="col-xs-7 help-block">{#blank_link_ph#|ucfirst}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{#cancel#|ucfirst}</button>
                    <input type="submit" class="btn btn-primary" value="{#save#|ucfirst}" />
                    <input type="hidden" name="idlink" id="idlink" value="" />
                </div>
            </form>