/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
 # This program is free software: you can redistribute it and/or modify
 # it under the terms of the GNU General Public License as published by
 # the Free Software Foundation, either version 3 of the License, or
 # (at your option) any later version.
 #
 # This program is distributed in the hope that it will be useful,
 # but WITHOUT ANY WARRANTY; without even the implied warranty of
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 # GNU General Public License for more details.

 # You should have received a copy of the GNU General Public License
 # along with this program.  If not, see <http://www.gnu.org/licenses/>.
 #
 # -- END LICENSE BLOCK -----------------------------------

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * Author: Salvatore Di Salvo
 * Copyright: MAGIX CMS
 * Date: 09-09-15
 * Time: 09:20
 * License: Dual licensed under the MIT or GPL Version
 */
var search_Mod = (function ($, undefined) {
    /**
     * Save
     * @param id
     * @param collection
     * @param type
     */
    function search(type,id) {
        var timeout = null
        if (type === 'cms') {
            $('#search_cms').on('keyup',function(){
                var val = $(this).val().toLowerCase();
                if(val != '') {
                    $('.fa-search',$(this).prev()).addClass('hide');
                    $('.clear',$(this).prev()).removeClass('hide');
                } else {
                    $('.fa-search',$(this).prev()).removeClass('hide');
                    $('.clear',$(this).prev()).addClass('hide');
                }
                if(val.length > 1) {
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        $.nicenotify({
                            ntype: "ajax",
                            uri: '/'+baseadmin+'/plugins.php?name=blocklink&getlang='+getlang+'&action=search',
                            typesend: 'get',
                            noticedata: {q: val, search_type: type},
                            beforeParams: function () {
                                var loader = $(document.createElement("tr")).attr('id', 'loader').append(
                                    $(document.createElement("td")).addClass('text-center').append(
                                        $(document.createElement("span")).addClass("fa fa-spinner fa-pulse")
                                    )
                                );
                                $('#no-cms').prevAll('tr').remove();
                                $('#no-cms').before(loader);
                            },
                            successParams: function (data) {
                                $('#loader').remove();
                                $.nicenotify.initbox(data, {
                                    display: false
                                });
                                if (data === undefined) {
                                    console.log(data);
                                }
                                if (data !== null) {
                                    $(id+' .search-results').removeClass('hide');
                                    $('#no-cms').before(data);
                                }
                                updateList('cms');
                            }
                        });
                    }, 100);
                } else {
                    $('#no-cms').prevAll('tr').remove();
                    $(id+' .search-results').addClass('hide');
                    updateList('cms');
                }
            });
            $('#cms_link .clear').click(function(e){
                e.preventDefault();
                $(this).parent().next().val('');
                $(this).addClass('hide');
                $(this).prev().removeClass('hide');
                $('#no-cms').prevAll('tr').remove();
                $(id+' .search-results').addClass('hide');
                updateList('cms');
                return false;
            });
        } else if (type === 'cat') {
            $('#search_cat').on('keyup',function(){
                var val = $(this).val().toLowerCase();
                if(val != '') {
                    $('.fa-search',$(this).prev()).addClass('hide');
                    $('.clear',$(this).prev()).removeClass('hide');
                } else {
                    $('.fa-search',$(this).prev()).removeClass('hide');
                    $('.clear',$(this).prev()).addClass('hide');
                }
                if(val.length > 1) {
                    $.nicenotify({
                        ntype: "ajax",
                        uri: '/'+baseadmin+'/plugins.php?name=blocklink&getlang='+getlang+'&action=search',
                        typesend: 'get',
                        noticedata: {q: val, search_type: type},
                        beforeParams: function () {
                            var loader = $(document.createElement("tr")).attr('id', 'loader').append(
                                $(document.createElement("td")).addClass('text-center').append(
                                    $(document.createElement("span")).addClass("fa fa-spinner fa-pulse")
                                )
                            );
                            $('#no-cat').prevAll('tr').remove();
                            $('#no-cat').before(loader);
                        },
                        successParams: function (data) {
                            $('#loader').remove();
                            $.nicenotify.initbox(data, {
                                display: false
                            });
                            if (data === undefined) {
                                console.log(data);
                            }
                            if (data !== null) {
                                $(id+' .search-results').removeClass('hide');
                                $('#no-cat').before(data);
                            }
                            updateList('cat');
                        }
                    });
                } else {
                    $('#no-cat').prevAll('tr').remove();
                    $(id+' .search-results').addClass('hide');
                    updateList('cat');
                }
            });
            $('#cat-link .clear').click(function(e){
                e.preventDefault();
                $(this).parent().next().val('');
                $(this).addClass('hide');
                $(this).prev().removeClass('hide');
                $('#no-cat').prevAll('tr').remove();
                $(id+' .search-results').addClass('hide');
                updateList('cat');
                return false;
            });
        }
    }

	/**
     *
     */
    function updateList(type) {
        if (type == 'cms') {
            var rows = $('#list_cms tr');
            if (rows.length > 1) {
                $('#no-cms').addClass('hide');
            } else {
                if ($('#search_cms').val() != '' && $('#search_cms').val().toLowerCase().length > 1) {
                    $('#no-cms').removeClass('hide');
                } else {
                    $('#no-cms').addClass('hide');
                }
            }
        } else if (type == 'cat') {
            var rows = $('#list_cat tr');
            if (rows.length > 1) {
                $('#no-cat').addClass('hide');
            } else {
                if ($('#search_cat').val() != '' && $('#search_cat').val().toLowerCase().length > 1) {
                    $('#no-cat').removeClass('hide');
                } else {
                    $('#no-cat').addClass('hide');
                }
            }
        }
    }

    return {
        // Fonction Public        
        run: function (iso) {
            search('cms','#cms-link');
            search('cat','#cat-link');

            $(function (){
                $('#search-module input').each(function(){
                    var id = '#'+$(this).attr('id')+'-link',
                        val = $(this).val(),
                        $this = $(this);

                    if(val != '') {
                        $('.fa-search',$(this).prev()).addClass('hide');
                        $('.clear',$(this).prev()).removeClass('hide');
                    } else {
                        $('.fa-search',$(this).prev()).removeClass('hide');
                        $('.clear',$(this).prev()).addClass('hide');
                    }

                    $(this).on('focusin',function(){
                        var rows = $('.search-results tbody tr', $(id));
                        if (rows.length > 1 || ($(this).val() != '' && $(this).val().toLowerCase().length > 1)) {
                            $('.search-results', $(id)).removeClass('hide');
                        }
                    });
                    $(this).on('focusout',function(ev){
                        //alert(e.target);
                        $(document).mouseup(function(e) {
                            if (ev.target !== e.target && $('.search-results', $(id)).has(e.target).length === 0 && !$('.search-results', $(id)).hasClass('hide')) {
                                $('.search-results', $(id)).addClass('hide');
                            }
                        });
                    });
                });
            });
        }
    };
})(jQuery);