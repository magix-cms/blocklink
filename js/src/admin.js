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
 * Date: 05-11-15
 * Time: 13:51
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_plugins_advantage = (function ($, undefined) {
    /**
     * Save
     * @param id
     * @param collection
     * @param type
     */
    function save(getlang,id){
		// *** Set required fields for validation
		$(id).validate({
			onsubmit: true,
			event: 'submit',
			rules: {
				title: {
					required: true,
					minlength: 3
				},
				url: {
					required: true
				},
				type: {
					required: true
				},
				content: {
					maxlength: 200
				}
			},
			submitHandler: function(form) {
				$.nicenotify({
					ntype: "submit",
					uri: '/'+baseadmin+'/plugins.php?name=blocklink&getlang='+getlang+'&action=edit',
					typesend: 'post',
					idforms: $(form),
					resetform: true,
					successParams:function(data){
						$('#edit-link').modal('hide');
						window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
						$.nicenotify.initbox(data,{
							display:true
						});
						var id = $('#idlink').val();
						if (id != '') {
							$('#order_'+$('#idlink').val()).remove();
						}
						getLink(baseadmin,getlang);
					}
				});
				return false;
			}
		});
    }

	/**
	 * Delete
	 * @param getlang
	 * @param id
	 * @param modal
	 */
    function del(getlang,id,modal){
		// *** Set required fields for validation
		$(id).validate({
			onsubmit: true,
			event: 'submit',
			rules: {
				delete: {
					required: true,
					number: true,
					minlength: 1
				}
			},
			submitHandler: function(form) {
				$.nicenotify({
					ntype: "submit",
					uri: '/'+baseadmin+'/plugins.php?name=blocklink&getlang='+getlang+'&action=delete',
					typesend: 'post',
					idforms: $(form),
					resetform: true,
					successParams:function(data){
						$(modal).modal('hide');
						window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
						$.nicenotify.initbox(data,{
							display:true
						});
						$('#order_'+$('#delete').val()).remove();
						updateList();
					}
				});
				return false;
			}
		});
    }

	/**
	 * Edit
	 * @param getlang
	 * @param id
	 */
	function edit(getlang,id){
		$.nicenotify({
			ntype: "ajax",
			uri: '/'+baseadmin+'/plugins.php?name=blocklink&getlang='+getlang+'&action=edit&edit='+id,
			typesend: 'get',
			beforeParams:function(){
				var loader = $(document.createElement("p")).attr('id','loader').addClass('text-center').append(
					$(document.createElement("span")).addClass("loader offset5").append(
						$(document.createElement("img"))
							.attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
							.attr('width','20px')
							.attr('height','20px')
					)
				);
				$('#edit-link .modal-content').before(loader);
			},
			successParams:function(data){
				$('#loader').remove();
				$.nicenotify.initbox(data,{
					display:false
				});
				if(data === undefined){
					console.log(data);
				}
				if(data !== null){
					$('#edit-link .modal-content').html(data);
					$('#idlink').val(id);
					$('#blank').bootstrapToggle();
					save(getlang,'#edit_link');
				}
			}
		});
	}

    /**
     * Liste des points forts
     * @param getlang
     */
    function getLink(baseadmin,getlang){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/plugins.php?name=blocklink&getlang='+getlang+'&action=getlist',
            typesend: 'get',
            beforeParams:function(){
                var loader = $(document.createElement("tr")).attr('id','loader').append(
                    $(document.createElement("td")).addClass('text-center').append(
                        $(document.createElement("span")).addClass("loader offset5").append(
                            $(document.createElement("img"))
                                .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                                .attr('width','20px')
                                .attr('height','20px')
                        )
                    )
                );
                $('#no-entry').before(loader);
            },
            successParams:function(data){
                $('#loader').remove();
                $.nicenotify.initbox(data,{
                    display:false
                });
                if(data === undefined){
                    console.log(data);
                }
                if(data !== null){
                    $('#no-entry').before(data);
                }
                updateList();
            }
        });
    }

	/**
	 *
	 */
	function modal() {
		$('a.toggleModal').off('click');
		$('a.toggleModal').click(function(){
			var target = $(this).data('target');
			var id = $(this).attr('href');
			if(id != '#') {
				id = id.slice(1);
			}
			if (target == '#edit-link') {
				if(id != '#') {
					edit(getlang,id);
				}
			}
			if (target == '#deleteModal') {
				if(id != '#') {
					$('#delete').val(id);
				}
			}
			$(target).on('hidden.bs.modal', function(){
				if (typeof search_Mod != "undefined") {
					search_Mod.clear('all');
				}
				$('.tab-pane.active').removeClass('active');
				$('#custom-link').addClass('active');
				$('#type option[value="custom"]').prop('selected', true);
				$('#url').val('');
				$('#title').val('');
			});
		});
	}

	/**
	 *
	 */
    function updateList() {
        var rows = $('#list_link tr');
        if (rows.length > 1) {
            $('#no-entry').addClass('hide');

            $( 'a.toggleModal').off();
            $( 'a.toggleModal' ).click(function(){
                if($(this).attr('href') != '#'){
                    var id = $(this).attr('href').slice(1);

                    $('#delete').val(id);
                }
            });
        } else {
            $('#no-entry').removeClass('hide');
        }
		modal();
    }
    return {
        // Fonction Public
        run: function (baseadmin,getlang) {
            // Init function
            save(getlang,'#edit_link');
            del(getlang,'#del_link','#deleteModal');
            updateList();
			modal();

            $(function(){
				$('[data-toggle="popover"]').popover();
				$('[data-toggle="popover"]').click(function(e){
					e.preventDefault(); return false;
				});

				$( ".ui-sortable" ).sortable({
					items: "> tr",
					placeholder: "ui-state-highlight",
					cursor: "move",
					axis: "y",
					update: function(){
						var serial = $( ".ui-sortable" ).sortable('serialize');
						$.nicenotify({
							ntype: "ajax",
							uri: '/'+baseadmin+'/plugins.php?name=blocklink&getlang='+getlang+'&action=order',
							typesend: 'post',
							noticedata : serial,
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false
								});
							}
						});
					}
				});
				$( ".ui-sortable" ).disableSelection();
            });
        }
    };
})(jQuery);