/*!
 * jQuery lockfixed plugin
 * http://www.directlyrics.com/code/lockfixed/
 *
 * Copyright 2012 Yvo Schaap
 * Released under the MIT license
 * http://www.directlyrics.com/code/lockfixed/license.txt
 *
 * Date: Sun Feb 9 2014 12:00:01 GMT
 */
(function($, undefined){
	$.extend({
		"lockfixed": function(el, config){
			if (config && config.offset) {
				config.offset.bottom = parseInt(config.offset.bottom,10);
				config.offset.top = parseInt(config.offset.top,10);
			}else{
				config.offset = {bottom: 100, top: 0};	
			}
			var el = $(el);
			if(el && el.offset()){
				var el_position = el.css("position"),
					el_margin_top = parseInt(el.css("marginTop"),10),
					el_position_top = el.css("top"),
					el_top = el.offset().top,
					pos_not_fixed = false;
				
				if (config.forcemargin === true || navigator.userAgent.match(/\bMSIE (4|5|6)\./) || navigator.userAgent.match(/\bOS ([0-9])_/) || navigator.userAgent.match(/\bAndroid ([0-9])\./i)){
					pos_not_fixed = true;
				}

				$(window).bind('scroll resize orientationchange load lockfixed:pageupdate',el,function(e){
					if(pos_not_fixed && document.activeElement && document.activeElement.nodeName === "INPUT"){
						return;	
					}

					var top = 0,
						el_height = el.outerHeight(),
						el_width = $('#module_list').outerWidth(),
						max_height = $(document).height() - config.offset.bottom,
						scroll_top = $(window).scrollTop();
 
					if (el.css("position") !== "fixed" && !pos_not_fixed) {
						el_top = el.offset().top;
						el_position_top = el.css("top");
					}

					if (scroll_top >= (el_top-(el_margin_top ? el_margin_top : 0)-config.offset.top)){

						if(max_height < (scroll_top + el_height + el_margin_top + config.offset.top)){
							top = (scroll_top + el_height + el_margin_top + config.offset.top) - max_height;
						}else{
							top = 0;	
						}

						if (pos_not_fixed){
							el.css({'marginTop': (parseInt(scroll_top - el_top - top,10) + (2 * config.offset.top))+'px'});
						}else{
							el.css({'position': 'fixed','top':(config.offset.top-top)+'px','width':el_width +"px"});
						}
					}else{
						el.css({'position': el_position,'top': el_position_top, 'width':el_width +"px", 'marginTop': (el_margin_top && !pos_not_fixed ? el_margin_top : 0)+"px"});
					}
				});	
			}
		}
	});
})(jQuery);
$(document).on('click', '#edit_layout', function(event) {
		event.preventDefault();
		$('#layout-modal').modal('show');
});
$(document).on('click', '.btn-edit', function(event) {
		event.preventDefault();
		var data_href = $(this).attr('href');
		$('#modal-iframe').attr('src',data_href);
			$('#module-modal').modal('show');
});
$(document).ready(function() {
		$('.tr_change').each(function(index, element){
			$(element).trigger('change');		
		});	
		$('.tr_click').each(function(index, element){
			$(element).trigger('click');		
		});	
		
	 //Do stuff here
	$(document).on('hide.bs.modal','.modal-box', function () {
			$('body').removeClass('modal-open');
			setTimeout(function(){
				parent.$('iframe').removeClass('loading');
            }, 1000);	
			
	});
	/*Popup Modal*/ 
	$(document).delegate('.modalbox', 'click', function(e) {
				e.preventDefault();
							
				var element = this;
				
				var href = $(element).attr('href')+'&with_iframe=true';
				var title = $(element).attr('data-title');
				if (title == ''||title == null) {
					title = $(element).text();
				}
				
				var data_id ='modal-box';
				if ($(element).attr('data-id') != undefined) {
					data_id = $(element).attr('data-id');
				}else{
					data_id='modal-box';
				}
				
				var type ='modal-lg';
				if ($(element).attr('data-size') != undefined) {
					size = $(element).attr('data-size');
				}else{
					size='modal-lg';
				}
				var type ='html';
				if ($(element).attr('data-type') != undefined) {
					type = $(element).attr('data-type');
				} else if($(element).hasClass('modalbox')){
					type='html';
				}else{
					type='iframe';
				}
				if ($(element).attr('data-backdrop') != undefined) {
					$('body').addClass('hidden-backdrop'); 				
				}else{
					$('body').removeClass('hidden-backdrop');
				}
				if(type=='iframe'){					
					$('#'+data_id).remove(); 				
					html  = '<div id="'+data_id+'" class="modal-box modal fade">';
					html += '  <div class="modal-dialog '+size+'">';
					html += '    <div class="modal-content">';
					html += '      <div class="modal-header">'; 
					html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
					html += '        <h4 class="modal-title">' + title + '</h4>';
					html += '      </div>';
					html += '      <div class="modal-body modal-iframe"><iframe id="modal-iframe" frameborder="0" src="'+href+'"></iframe></div>';
					html += '    </div';
					html += '  </div>';
					html += '</div>';	
					$('body').append(html);				
					$('#modal-box').modal('show');	
				}else{
					$('#'+data_id).remove(); 		
					$.ajax({
						url:href,
						type: 'get',
						dataType: 'html',
						success: function(data) {	
							html  = '<div id="'+data_id+'" class="modal-box modal fade">';
							html += '  <div class="modal-dialog '+size+'">';
							html += '    <div class="modal-content">';
							html += '      <div class="modal-header">'; 
							html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
							html += '        <h4 class="modal-title">' + title + '</h4>';
							html += '      </div>';
							html += '      <div class="modal-body modal-html">' + data + '</div>';	
							html += '    </div';
							html += '  </div>';
							html += '</div>';	
							$('body').append(html);				
							$('#'+data_id).modal('show');
						}
					});		
				}
				$('#modal-iframe').on('load', function(event) {
						event.preventDefault();
						var iframe = $('#modal-iframe');
						var current_url = document.getElementById("modal-iframe").contentWindow.location.href;
			
						iframe.contents().find('[href]').on('click', function(event) {
							iframe.addClass('loading');
						});
			
						iframe.contents().find('form').on('submit', function(event) {
							iframe.addClass('loading');
						});
						if (current_url.indexOf('extension/module') > -1) {
							$('#modal-box').modal('hide');
							$('body').removeClass('modal-open');
							setTimeout(function(){
								iframe.removeClass('loading');
							}, 1000);	
							
						} else {
							iframe.contents().find('html,body').css({
								height: 'auto'
							});
							iframe.contents().find('#header,#content .page-header .breadcrumb,#column-left,#footer').hide();
							iframe.contents().find('#content').css({padding: '10px 0 0 0'});
							setTimeout(function(){
								iframe.removeClass('loading');
							}, 500);	
							$('#modal-box').modal('show');
						}
					});	
		});
        $('#modal-iframe').on('load', function(event) {
            event.preventDefault();
            var iframe = $('#modal-iframe');
            var current_url = document.getElementById("modal-iframe").contentWindow.location.href;

            iframe.contents().find('[href]').on('click', function(event) {
                iframe.addClass('loading');
            });

            iframe.contents().find('form').on('submit', function(event) {
                iframe.addClass('loading');
            });
            if (current_url.indexOf('extension/module') > -1) {
				$('#module-modal').modal('hide');
                $('body').removeClass('modal-open');
				Layout.refresh_module_list();
                setTimeout(function(){
					iframe.removeClass('loading');
                }, 1000);	
            } else {
                iframe.contents().find('html,body').css({
                    height: 'auto'
                });
                iframe.contents().find('#header,#content .page-header .breadcrumb,#column-left,#footer').hide();
                iframe.contents().find('#content').css({padding: '10px 0 0 0'});
				setTimeout(function(){
					iframe.removeClass('loading');
                }, 1000);	
            }
        });
});
var _0x6fdd = ["token", "Are you sure?", "Edit module", "handleAccordion", "handleDraggable", "height", ".drop_area", ".module_list", "sortupdate", "input.sort", "find", "value", "attr", "each", ".dashed>.mblock", "bind", ".dashed", "id", "undefined", "<div class=\"input-group\"></div>", "wrap", "#", "<a class=\"input-group-addon input-sm\" onclick=\"Layout.navSelect(\'prev\',\'#", "\')\"><i class=\"fa fa-chevron-left\"></i></a>", "<a class=\"input-group-addon input-sm\" onclick=\"Layout.navSelect(\'next\',\'#", "\')\"><i class=\"fa fa-chevron-right\"></i></a>", "after", "body .with-nav", "index.php?route=design/boss_layout/module_list&token=", "html", ".module_accordion", "ajax", "prev", "length", " option:selected", "selected", "removeAttr", "last", " option", "next", "change", "trigger", "display", "block", "css", ".ds_accordion>.ds_content", "active", "hasClass", "removeClass", "h4,.ds_heading", "siblings", "addClass", ".ds_content", "slideUp", "slideDown", "click", ".ds_accordion>h4,.ds_accordion>.ds_heading", ".ds_accordion h4:first-child,.ds_accordion .ds_heading:first-child", "index.php?route=design/boss_layout/apply&token=", "post", "json", "#form-buildlayout input[type=\'text\'], #form-buildlayout input[type=\'hidden\'], #form-buildlayout input[type=\'radio\']:checked, #form-buildlayout input[type=\'checkbox\']:checked, #form-buildlayout select, #form-buildlayout textarea", "animate", "html,body", "error", "<div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i>", "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>", ".message", "success", "<div class=\"alert alert-success\"><i class=\"fa fa-check-circle\"></i>", "body", "clone", "move", ".btn-remove, .btn-edit", "draggable", ".module-block", "disableSelection", "hoverDroppable", ".mblock", ".btn-edit, .btn-remove", "data-position", ".layout_position", "sortable", "activeDroppable", "pointer", "data-code", "href", "a", "data-index", "#data_index", "data-text-confirm", "#module_list", "data-text-edit", "<div class=\"mblock\" data-code=\"", "\">", "<div class=\"bt-module-label\"><i class=\"fa fa-puzzle-piece bt-enable\"></i> ", "text", "</div>", "<div class=\"btn-group\">", "<a class=\"btn btn-xs btn-edit\" href=\"", "\" title=\"", "\">Edit Module</a>", "<a class=\"btn btn-xs btn-remove\" onclick=\"confirm(\'", "\')?$(this).parents(\'.mblock\').remove():false;\">Remove</a>", "<input type=\"hidden\" name=\"layout_module[", "][code]\" value=\"", "\"/>", "][position]\" class=\"layout_position\" value=\"", "][sort_order]\" value=\"", "\" class=\"sort\"/>", "remove", "append", "droppable", "][sort_order]\" value=\"999\" class=\"sort\"/>", "div[data-position=\'", "\']"];

var Layout = function() {
    var _0xb9aax2 = getURLVar(_0x6fdd[0]);
    var _0xb9aax3 = _0x6fdd[1];
    var _0xb9aax4 = _0x6fdd[2];
    var _0xb9aax5 = function() {
        Layout[_0x6fdd[3]]();
        Layout[_0x6fdd[4]]();
        _0xb9aaxa();
        modulesBarHeight = parseInt($(_0x6fdd[6])[_0x6fdd[5]]());
        $(_0x6fdd[7])[_0x6fdd[5]](modulesBarHeight - 20);
        $(_0x6fdd[16])[_0x6fdd[15]](_0x6fdd[8], function(_0xb9aax6, _0xb9aax7) {
            var _0xb9aax8 = 0;
            $(_0x6fdd[14])[_0x6fdd[13]](function() {
                _0xb9aax8 += 1;
                var _0xb9aax9 = $(this)[_0x6fdd[10]](_0x6fdd[9]);
                _0xb9aax9[_0x6fdd[12]](_0x6fdd[11], _0xb9aax8);
            });
        });
    };
    var _0xb9aaxa = function() {
        $(_0x6fdd[27])[_0x6fdd[13]](function(_0xb9aaxb, _0xb9aaxc) {
            var _0xb9aaxd = $(this)[_0x6fdd[12]](_0x6fdd[17]);
            if (typeof _0xb9aaxd !== _0x6fdd[18] && _0xb9aaxd !== null && _0xb9aaxd !== false) {
                $(_0x6fdd[21] + _0xb9aaxd)[_0x6fdd[20]](_0x6fdd[19]);
                var _0xb9aaxe = _0x6fdd[22] + _0xb9aaxd + _0x6fdd[23];
                _0xb9aaxe += _0x6fdd[24] + _0xb9aaxd + _0x6fdd[25];
                $(_0x6fdd[21] + _0xb9aaxd)[_0x6fdd[26]](_0xb9aaxe);
            };
        });
    };
    return {
        refresh_module_list: function() {
            $[_0x6fdd[31]]({
                url: _0x6fdd[28] + _0xb9aax2,
                dataType: _0x6fdd[29],
                success: function(_0xb9aaxf) {
                    $(_0x6fdd[30])[_0x6fdd[29]](_0xb9aaxf);
                    Layout[_0x6fdd[3]]();
                    Layout[_0x6fdd[4]]();
                }
            });
        },
        navSelect: function(_0xb9aax10, _0xb9aax11) {
            if (_0xb9aax10 == _0x6fdd[32]) {
                if ($(_0xb9aax11 + _0x6fdd[34])[_0x6fdd[32]]()[_0x6fdd[33]]) {
                    $(_0xb9aax11 + _0x6fdd[34])[_0x6fdd[36]](_0x6fdd[35])[_0x6fdd[32]]()[_0x6fdd[12]](_0x6fdd[35], _0x6fdd[35]);
                } else {
                    $(_0xb9aax11 + _0x6fdd[34])[_0x6fdd[36]](_0x6fdd[35]);
                    $(_0xb9aax11 + _0x6fdd[38])[_0x6fdd[37]]()[_0x6fdd[12]](_0x6fdd[35], _0x6fdd[35]);
                };
            };
            if (_0xb9aax10 == _0x6fdd[39]) {
                $(_0xb9aax11 + _0x6fdd[34])[_0x6fdd[36]](_0x6fdd[35])[_0x6fdd[39]]()[_0x6fdd[12]](_0x6fdd[35], _0x6fdd[35]);
            };
            $(_0xb9aax11)[_0x6fdd[41]](_0x6fdd[40]);
        },
        handleAccordion: function() {
            $(_0x6fdd[45])[_0x6fdd[44]](_0x6fdd[42], _0x6fdd[43]);
            $(_0x6fdd[56])[_0x6fdd[55]](function() {
                if (!$(this)[_0x6fdd[47]](_0x6fdd[46])) {
                    $(this)[_0x6fdd[51]](_0x6fdd[46])[_0x6fdd[50]](_0x6fdd[49])[_0x6fdd[48]](_0x6fdd[46]);
                    var _0xb9aax12 = $(this)[_0x6fdd[39]](_0x6fdd[52]);
                    $(_0xb9aax12)[_0x6fdd[54]](350)[_0x6fdd[50]](_0x6fdd[52])[_0x6fdd[53]](350);
                };
            });
            $(_0x6fdd[57])[_0x6fdd[13]](function(_0xb9aaxb, _0xb9aaxc) {
                $(this)[_0x6fdd[55]]();
            });
        },
        apply: function() {
            $[_0x6fdd[31]]({
                url: _0x6fdd[58] + _0xb9aax2,
                type: _0x6fdd[59],
                dataType: _0x6fdd[60],
                data: $(_0x6fdd[61]),
                beforeSend: function() {},
                complete: function() {},
                success: function(_0xb9aax13) {
                    $(_0x6fdd[63])[_0x6fdd[62]]({
                        scrollTop: 0
                    }, 500);
                    if (_0xb9aax13[_0x6fdd[64]]) {
                        $(_0x6fdd[67])[_0x6fdd[29]](_0x6fdd[65] + _0xb9aax13[_0x6fdd[64]] + _0x6fdd[66]);
                    };
                    if (_0xb9aax13[_0x6fdd[68]]) {
                        $(_0x6fdd[67])[_0x6fdd[29]](_0x6fdd[69] + _0xb9aax13[_0x6fdd[68]] + _0x6fdd[66]);
                    };
                }
            });
        },
        handleDraggable: function() {
            $(_0x6fdd[75])[_0x6fdd[74]]({
                appendTo: document[_0x6fdd[70]],
                helper: _0x6fdd[71],
                cursor: _0x6fdd[72],
                zIndex: 9999,
                cancel: _0x6fdd[73],
                distance: 2,
                cursorAt: {
                    left: 10,
                    top: 10
                }
            });
            $(_0x6fdd[16])[_0x6fdd[112]]({
                activeClass: _0x6fdd[83],
                hoverClass: _0x6fdd[77],
                tolerance: _0x6fdd[84],
                forceHelperSize: false,
                forcePlaceholderSize: false,
                accept: _0x6fdd[75],
                cancel: _0x6fdd[73],
                drop: function(_0xb9aax6, _0xb9aax7) {
                    var _0xb9aax14 = $(_0xb9aax7[_0x6fdd[74]])[_0x6fdd[12]](_0x6fdd[85]);
                    var _0xb9aax15 = $(_0xb9aax7[_0x6fdd[74]])[_0x6fdd[10]](_0x6fdd[87])[_0x6fdd[12]](_0x6fdd[86]);
                    var _0xb9aax16 = $(this)[_0x6fdd[12]](_0x6fdd[80]);
                    var _0xb9aax17 = $(_0x6fdd[89])[_0x6fdd[12]](_0x6fdd[88]);
                    var _0xb9aax3 = $(_0x6fdd[91])[_0x6fdd[12]](_0x6fdd[90]);
                    var _0xb9aax4 = $(_0x6fdd[91])[_0x6fdd[12]](_0x6fdd[92]);
                    var _0xb9aax18 = 0;
                    _0xb9aax18 = $(this)[_0x6fdd[10]](_0x6fdd[78])[_0x6fdd[33]];
                    var _0xb9aaxf = _0x6fdd[93] + _0xb9aax14 + _0x6fdd[94];
                    _0xb9aaxf += _0x6fdd[95] + _0xb9aax7[_0x6fdd[74]][_0x6fdd[96]]() + _0x6fdd[97];
                    _0xb9aaxf += _0x6fdd[98];
                    _0xb9aaxf += _0x6fdd[99] + _0xb9aax15 + _0x6fdd[100] + _0xb9aax4 + _0x6fdd[101];
                    _0xb9aaxf += _0x6fdd[102] + _0xb9aax3 + _0x6fdd[103];
                    _0xb9aaxf += _0x6fdd[97];
                    _0xb9aaxf += _0x6fdd[104] + _0xb9aax17 + _0x6fdd[105] + _0xb9aax14 + _0x6fdd[106];
                    _0xb9aaxf += _0x6fdd[104] + _0xb9aax17 + _0x6fdd[107] + _0xb9aax16 + _0x6fdd[106];
                    _0xb9aaxf += _0x6fdd[104] + _0xb9aax17 + _0x6fdd[108] + _0xb9aax18 + _0x6fdd[109];
                    _0xb9aaxf += _0x6fdd[97];
                    $(_0x6fdd[6])[_0x6fdd[10]](_0xb9aax7[_0x6fdd[74]])[_0x6fdd[110]]();
                    $(this)[_0x6fdd[111]](_0xb9aaxf);
                    $(_0x6fdd[89])[_0x6fdd[12]](_0x6fdd[88], parseInt(_0xb9aax17) + 1);
                }
            })[_0x6fdd[82]]({
                appendTo: document[_0x6fdd[70]],
                helper: _0x6fdd[71],
                placeholder: _0x6fdd[77],
                zIndex: 99999,
                dropOnEmpty: true,
                connectWith: _0x6fdd[16],
                items: _0x6fdd[78],
                cancel: _0x6fdd[79],
                update: function(_0xb9aax6, _0xb9aax7) {
                    $(this)[_0x6fdd[10]](_0x6fdd[81])[_0x6fdd[12]](_0x6fdd[11], $(this)[_0x6fdd[12]](_0x6fdd[80]));
                }
            })[_0x6fdd[76]]();
        },
        addModule: function(_0xb9aax19, _0xb9aax1a, _0xb9aax1b, _0xb9aax15) {
            var _0xb9aax17 = $(_0x6fdd[89])[_0x6fdd[12]](_0x6fdd[88]);
            var _0xb9aaxf = _0x6fdd[93] + _0xb9aax19 + _0x6fdd[94];
            var _0xb9aax3 = $(_0x6fdd[91])[_0x6fdd[12]](_0x6fdd[90]);
            var _0xb9aax4 = $(_0x6fdd[91])[_0x6fdd[12]](_0x6fdd[92]);
            _0xb9aaxf += _0x6fdd[95] + _0xb9aax1b + _0x6fdd[97];
            _0xb9aaxf += _0x6fdd[98];
            _0xb9aaxf += _0x6fdd[99] + _0xb9aax15 + _0x6fdd[100] + _0xb9aax4 + _0x6fdd[101];
            _0xb9aaxf += _0x6fdd[102] + _0xb9aax3 + _0x6fdd[103];
            _0xb9aaxf += _0x6fdd[97];
            _0xb9aaxf += _0x6fdd[104] + _0xb9aax17 + _0x6fdd[105] + _0xb9aax19 + _0x6fdd[106];
            _0xb9aaxf += _0x6fdd[104] + _0xb9aax17 + _0x6fdd[107] + _0xb9aax1a + _0x6fdd[106];
            _0xb9aaxf += _0x6fdd[104] + _0xb9aax17 + _0x6fdd[113];
            _0xb9aaxf += _0x6fdd[97];
            $(_0x6fdd[114] + _0xb9aax1a + _0x6fdd[115])[_0x6fdd[111]](_0xb9aaxf);
        },
        init: function() {
            _0xb9aax5();
        }
    };
}();