/*!
 Buttons for DataTables 1.1.1
 ©2015 SpryMedia Ltd - datatables.net/license
*/
(function(e){"function"===typeof define&&define.amd?define(["jquery","datatables.net"],function(o){return e(o,window,document)}):"object"===typeof exports?module.exports=function(o,n){o||(o=window);if(!n||!n.fn.dataTable)n=require("datatables.net")(o,n).$;return e(n,o,o.document)}:e(jQuery,window,document)})(function(e,o,n,m){var i=e.fn.dataTable,t=0,u=0,j=i.ext.buttons,l=function(a,b){!0===b&&(b={});e.isArray(b)&&(b={buttons:b});this.c=e.extend(!0,{},l.defaults,b);b.buttons&&(this.c.buttons=b.buttons);
this.s={dt:new i.Api(a),buttons:[],subButtons:[],listenKeys:"",namespace:"dtb"+t++};this.dom={container:e("<"+this.c.dom.container.tag+"/>").addClass(this.c.dom.container.className)};this._constructor()};e.extend(l.prototype,{action:function(a,b){var c=this._indexToButton(a).conf;if(b===m)return c.action;c.action=b;return this},active:function(a,b){var c=this._indexToButton(a),d=this.c.dom.button.active;if(b===m)return c.node.hasClass(d);c.node.toggleClass(d,b===m?!0:b);return this},add:function(a,
b){if("string"===typeof a&&-1!==a.indexOf("-")){var c=a.split("-");this.c.buttons[1*c[0]].buttons.splice(1*c[1],0,b)}else this.c.buttons.splice(1*a,0,b);this.dom.container.empty();this._buildButtons(this.c.buttons);return this},container:function(){return this.dom.container},disable:function(a){this._indexToButton(a).node.addClass(this.c.dom.button.disabled);return this},destroy:function(){e("body").off("keyup."+this.s.namespace);var a=this.s.buttons,b=this.s.subButtons,c,d,f;c=0;for(a=a.length;c<
a;c++){this.removePrep(c);d=0;for(f=b[c].length;d<f;d++)this.removePrep(c+"-"+d)}this.removeCommit();this.dom.container.remove();b=this.s.dt.settings()[0];c=0;for(a=b.length;c<a;c++)if(b.inst===this){b.splice(c,1);break}return this},enable:function(a,b){if(!1===b)return this.disable(a);this._indexToButton(a).node.removeClass(this.c.dom.button.disabled);return this},name:function(){return this.c.name},node:function(a){return this._indexToButton(a).node},removeCommit:function(){var a=this.s.buttons,
b=this.s.subButtons,c,d;for(c=a.length-1;0<=c;c--)null===a[c]&&(a.splice(c,1),b.splice(c,1),this.c.buttons.splice(c,1));c=0;for(a=b.length;c<a;c++)for(d=b[c].length-1;0<=d;d--)null===b[c][d]&&(b[c].splice(d,1),this.c.buttons[c].buttons.splice(d,1));return this},removePrep:function(a){var b,c=this.s.dt;if("number"===typeof a||-1===a.indexOf("-"))b=this.s.buttons[1*a],b.conf.destroy&&b.conf.destroy.call(c.button(a),c,b,b.conf),b.node.remove(),this._removeKey(b.conf),this.s.buttons[1*a]=null;else{var d=
a.split("-");b=this.s.subButtons[1*d[0]][1*d[1]];b.conf.destroy&&b.conf.destroy.call(c.button(a),c,b,b.conf);b.node.remove();this._removeKey(b.conf);this.s.subButtons[1*d[0]][1*d[1]]=null}return this},text:function(a,b){var c=this._indexToButton(a),d=this.c.dom.collection.buttonLiner,d="string"===typeof a&&-1!==a.indexOf("-")&&d&&d.tag?d.tag:this.c.dom.buttonLiner.tag,e=this.s.dt,g=function(a){return"function"===typeof a?a(e,c.node,c.conf):a};if(b===m)return g(c.conf.text);c.conf.text=b;d?c.node.children(d).html(g(b)):
c.node.html(g(b));return this},toIndex:function(a){var b,c,d,e;d=this.s.buttons;var g=this.s.subButtons;b=0;for(c=d.length;b<c;b++)if(d[b].node[0]===a)return b+"";b=0;for(c=g.length;b<c;b++){d=0;for(e=g[b].length;d<e;d++)if(g[b][d].node[0]===a)return b+"-"+d}},_constructor:function(){var a=this,b=this.s.dt,c=b.settings()[0];c._buttons||(c._buttons=[]);c._buttons.push({inst:this,name:this.c.name});this._buildButtons(this.c.buttons);b.on("destroy",function(){a.destroy()});e("body").on("keyup."+this.s.namespace,
function(b){if(!n.activeElement||n.activeElement===n.body){var c=String.fromCharCode(b.keyCode).toLowerCase();a.s.listenKeys.toLowerCase().indexOf(c)!==-1&&a._keypress(c,b)}})},_addKey:function(a){a.key&&(this.s.listenKeys+=e.isPlainObject(a.key)?a.key.key:a.key)},_buildButtons:function(a,b,c){var d=this.s.dt,f=0;b||(b=this.dom.container,this.s.buttons=[],this.s.subButtons=[]);for(var g=0,k=a.length;g<k;g++){var h=this._resolveExtends(a[g]);if(h)if(e.isArray(h))this._buildButtons(h,b,c);else{var q=
this._buildButton(h,c!==m?!0:!1);if(q){var r=q.node;b.append(q.inserter);c===m?(this.s.buttons.push({node:r,conf:h,inserter:q.inserter}),this.s.subButtons.push([])):this.s.subButtons[c].push({node:r,conf:h,inserter:q.inserter});h.buttons&&(q=this.c.dom.collection,h._collection=e("<"+q.tag+"/>").addClass(q.className),this._buildButtons(h.buttons,h._collection,f));h.init&&h.init.call(d.button(r),d,r,h);f++}}}},_buildButton:function(a,b){var c=this.c.dom.button,d=this.c.dom.buttonLiner,f=this.c.dom.collection,
g=this.s.dt,k=function(b){return"function"===typeof b?b(g,h,a):b};b&&f.button&&(c=f.button);b&&f.buttonLiner&&(d=f.buttonLiner);if(a.available&&!a.available(g,a))return!1;var h=e("<"+c.tag+"/>").addClass(c.className).attr("tabindex",this.s.dt.settings()[0].iTabIndex).attr("aria-controls",this.s.dt.table().node().id).on("click.dtb",function(b){b.preventDefault();!h.hasClass(c.disabled)&&a.action&&a.action.call(g.button(h),b,g,h,a);h.blur()}).on("keyup.dtb",function(b){b.keyCode===13&&!h.hasClass(c.disabled)&&
a.action&&a.action.call(g.button(h),b,g,h,a)});d.tag?h.append(e("<"+d.tag+"/>").html(k(a.text)).addClass(d.className)):h.html(k(a.text));!1===a.enabled&&h.addClass(c.disabled);a.className&&h.addClass(a.className);a.titleAttr&&h.attr("title",a.titleAttr);a.namespace||(a.namespace=".dt-button-"+u++);d=(d=this.c.dom.buttonContainer)&&d.tag?e("<"+d.tag+"/>").addClass(d.className).append(h):h;this._addKey(a);return{node:h,inserter:d}},_indexToButton:function(a){if("number"===typeof a||-1===a.indexOf("-"))return this.s.buttons[1*
a];a=a.split("-");return this.s.subButtons[1*a[0]][1*a[1]]},_keypress:function(a,b){var c,d,f,g;f=this.s.buttons;var k=this.s.subButtons,h=function(c,d){if(c.key)if(c.key===a)d.click();else if(e.isPlainObject(c.key)&&c.key.key===a&&(!c.key.shiftKey||b.shiftKey))if(!c.key.altKey||b.altKey)if(!c.key.ctrlKey||b.ctrlKey)(!c.key.metaKey||b.metaKey)&&d.click()};c=0;for(d=f.length;c<d;c++)h(f[c].conf,f[c].node);c=0;for(d=k.length;c<d;c++){f=0;for(g=k[c].length;f<g;f++)h(k[c][f].conf,k[c][f].node)}},_removeKey:function(a){if(a.key){var b=
e.isPlainObject(a.key)?a.key.key:a.key,a=this.s.listenKeys.split(""),b=e.inArray(b,a);a.splice(b,1);this.s.listenKeys=a.join("")}},_resolveExtends:function(a){for(var b=this.s.dt,c,d,f=function(c){for(var d=0;!e.isPlainObject(c)&&!e.isArray(c);){if(c===m)return;if("function"===typeof c){if(c=c(b,a),!c)return!1}else if("string"===typeof c){if(!j[c])throw"Unknown button type: "+c;c=j[c]}d++;if(30<d)throw"Buttons: Too many iterations";}return e.isArray(c)?c:e.extend({},c)},a=f(a);a&&a.extend;){if(!j[a.extend])throw"Cannot extend unknown button type: "+
a.extend;var g=f(j[a.extend]);if(e.isArray(g))return g;if(!g)return!1;c=g.className;a=e.extend({},g,a);c&&a.className!==c&&(a.className=c+" "+a.className);var k=a.postfixButtons;if(k){a.buttons||(a.buttons=[]);c=0;for(d=k.length;c<d;c++)a.buttons.push(k[c]);a.postfixButtons=null}if(k=a.prefixButtons){a.buttons||(a.buttons=[]);c=0;for(d=k.length;c<d;c++)a.buttons.splice(c,0,k[c]);a.prefixButtons=null}a.extend=g.extend}return a}});l.background=function(a,b,c){c===m&&(c=400);a?e("<div/>").addClass(b).css("display",
"none").appendTo("body").fadeIn(c):e("body > div."+b).fadeOut(c,function(){e(this).remove()})};l.instanceSelector=function(a,b){if(!a)return e.map(b,function(a){return a.inst});var c=[],d=e.map(b,function(a){return a.name}),f=function(a){if(e.isArray(a))for(var k=0,h=a.length;k<h;k++)f(a[k]);else"string"===typeof a?-1!==a.indexOf(",")?f(a.split(",")):(a=e.inArray(e.trim(a),d),-1!==a&&c.push(b[a].inst)):"number"===typeof a&&c.push(b[a].inst)};f(a);return c};l.buttonSelector=function(a,b){for(var c=
[],d=function(a,b){var f,g,i=[];e.each(b.s.buttons,function(a,b){null!==b&&i.push({node:b.node[0],name:b.conf.name})});e.each(b.s.subButtons,function(a,b){e.each(b,function(a,b){null!==b&&i.push({node:b.node[0],name:b.conf.name})})});f=e.map(i,function(a){return a.node});if(e.isArray(a)||a instanceof e){f=0;for(g=a.length;f<g;f++)d(a[f],b)}else if(null===a||a===m||"*"===a){f=0;for(g=i.length;f<g;f++)c.push({inst:b,idx:b.toIndex(i[f].node)})}else if("number"===typeof a)c.push({inst:b,idx:a});else if("string"===
typeof a)if(-1!==a.indexOf(",")){var j=a.split(",");f=0;for(g=j.length;f<g;f++)d(e.trim(j[f]),b)}else if(a.match(/^\d+(\-\d+)?$/))c.push({inst:b,idx:a});else if(-1!==a.indexOf(":name")){j=a.replace(":name","");f=0;for(g=i.length;f<g;f++)i[f].name===j&&c.push({inst:b,idx:b.toIndex(i[f].node)})}else e(f).filter(a).each(function(){c.push({inst:b,idx:b.toIndex(this)})});else"object"===typeof a&&a.nodeName&&(g=e.inArray(a,f),-1!==g&&c.push({inst:b,idx:b.toIndex(f[g])}))},f=0,g=a.length;f<g;f++)d(b,a[f]);
return c};l.defaults={buttons:["copy","excel","csv","pdf","print"],name:"main",tabIndex:0,dom:{container:{tag:"div",className:"dt-buttons"},collection:{tag:"div",className:"dt-button-collection"},button:{tag:"a",className:"dt-button",active:"active",disabled:"disabled"},buttonLiner:{tag:"span",className:""}}};l.version="1.1.1";e.extend(j,{collection:{text:function(a){return a.i18n("buttons.collection","Collection")},className:"buttons-collection",action:function(a,b,c,d){var a=c.offset(),b=e(b.table().container()),
f=!1;e("div.dt-button-background").length&&(f=e("div.dt-button-collection").offset(),e(n).trigger("click.dtb-collection"));d._collection.addClass(d.collectionLayout).css("display","none").appendTo("body").fadeIn(d.fade);var g=d._collection.css("position");f&&"absolute"===g?d._collection.css({top:f.top+5,left:f.left+5}):"absolute"===g?(d._collection.css({top:a.top+c.outerHeight(),left:a.left}),c=a.left+d._collection.outerWidth(),b=b.offset().left+b.width(),c>b&&d._collection.css("left",a.left-(c-b))):
(a=d._collection.height()/2,a>e(o).height()/2&&(a=e(o).height()/2),d._collection.css("marginTop",-1*a));d.background&&l.background(!0,d.backgroundClassName,d.fade);setTimeout(function(){e("div.dt-button-background").on("click.dtb-collection",function(){});e("body").on("click.dtb-collection",function(a){if(!e(a.target).parents().andSelf().filter(d._collection).length){d._collection.fadeOut(d.fade,function(){d._collection.detach()});e("div.dt-button-background").off("click.dtb-collection");l.background(false,
d.backgroundClassName,d.fade);e("body").off("click.dtb-collection")}})},10)},background:!0,collectionLayout:"",backgroundClassName:"dt-button-background",fade:400},copy:function(a,b){if(j.copyHtml5)return"copyHtml5";if(j.copyFlash&&j.copyFlash.available(a,b))return"copyFlash"},csv:function(a,b){if(j.csvHtml5&&j.csvHtml5.available(a,b))return"csvHtml5";if(j.csvFlash&&j.csvFlash.available(a,b))return"csvFlash"},excel:function(a,b){if(j.excelHtml5&&j.excelHtml5.available(a,b))return"excelHtml5";if(j.excelFlash&&
j.excelFlash.available(a,b))return"excelFlash"},pdf:function(a,b){if(j.pdfHtml5&&j.pdfHtml5.available(a,b))return"pdfHtml5";if(j.pdfFlash&&j.pdfFlash.available(a,b))return"pdfFlash"},pageLength:function(a){var a=a.settings()[0].aLengthMenu,b=e.isArray(a[0])?a[0]:a,c=e.isArray(a[0])?a[1]:a,d=function(a){return a.i18n("buttons.pageLength",{"-1":"Show all rows",_:"Show %d rows"},a.page.len())};return{extend:"collection",text:d,className:"buttons-page-length",buttons:e.map(b,function(a,b){return{text:c[b],
action:function(b,c){c.page.len(a).draw();e("div.dt-button-background").click()},init:function(b,c,d){var e=this,c=function(){e.active(b.page.len()===a)};b.on("length.dt"+d.namespace,c);c()},destroy:function(a,b,c){a.off("length.dt"+c.namespace)}}}),init:function(a,b,c){var e=this;a.on("length.dt"+c.namespace,function(){e.text(d(a))})},destroy:function(a,b,c){a.off("length.dt"+c.namespace)}}}});i.Api.register("buttons()",function(a,b){b===m&&(b=a,a=m);return this.iterator(!0,"table",function(c){if(c._buttons)return l.buttonSelector(l.instanceSelector(a,
c._buttons),b)},!0)});i.Api.register("button()",function(a,b){var c=this.buttons(a,b);1<c.length&&c.splice(1,c.length);return c});i.Api.registerPlural("buttons().active()","button().active()",function(a){return a===m?this.map(function(a){return a.inst.active(a.idx)}):this.each(function(b){b.inst.active(b.idx,a)})});i.Api.registerPlural("buttons().action()","button().action()",function(a){return a===m?this.map(function(a){return a.inst.action(a.idx)}):this.each(function(b){b.inst.action(b.idx,a)})});
i.Api.register(["buttons().enable()","button().enable()"],function(a){return this.each(function(b){b.inst.enable(b.idx,a)})});i.Api.register(["buttons().disable()","button().disable()"],function(){return this.each(function(a){a.inst.disable(a.idx)})});i.Api.registerPlural("buttons().nodes()","button().node()",function(){var a=e();e(this.each(function(b){a=a.add(b.inst.node(b.idx))}));return a});i.Api.registerPlural("buttons().text()","button().text()",function(a){return a===m?this.map(function(a){return a.inst.text(a.idx)}):
this.each(function(b){b.inst.text(b.idx,a)})});i.Api.registerPlural("buttons().trigger()","button().trigger()",function(){return this.each(function(a){a.inst.node(a.idx).trigger("click")})});i.Api.registerPlural("buttons().containers()","buttons().container()",function(){var a=e();e(this.each(function(b){a=a.add(b.inst.container())}));return a});i.Api.register("button().add()",function(a,b){1===this.length&&this[0].inst.add(a,b);return this.button(a)});i.Api.register("buttons().destroy()",function(){this.pluck("inst").unique().each(function(a){a.destroy()});
return this});i.Api.registerPlural("buttons().remove()","buttons().remove()",function(){this.each(function(a){a.inst.removePrep(a.idx)});this.pluck("inst").unique().each(function(a){a.removeCommit()});return this});var p;i.Api.register("buttons.info()",function(a,b,c){var d=this;if(!1===a)return e("#datatables_buttons_info").fadeOut(function(){e(this).remove()}),clearTimeout(p),p=null,this;p&&clearTimeout(p);e("#datatables_buttons_info").length&&e("#datatables_buttons_info").remove();e('<div id="datatables_buttons_info" class="dt-button-info"/>').html(a?
"<h2>"+a+"</h2>":"").append(e("<div/>")["string"===typeof b?"html":"append"](b)).css("display","none").appendTo("body").fadeIn();c!==m&&0!==c&&(p=setTimeout(function(){d.buttons.info(!1)},c));return this});i.Api.register("buttons.exportData()",function(a){if(this.context.length){for(var b=new i.Api(this.context[0]),c=e.extend(!0,{},{rows:null,columns:"",modifier:{search:"applied",order:"applied"},orthogonal:"display",stripHtml:!0,stripNewlines:!0,decodeEntities:!0,trim:!0,format:{header:function(a){return d(a)},
footer:function(a){return d(a)},body:function(a){return d(a)}}},a),d=function(a){if("string"!==typeof a)return a;c.stripHtml&&(a=a.replace(/<.*?>/g,""));c.trim&&(a=a.replace(/^\s+|\s+$/g,""));c.stripNewlines&&(a=a.replace(/\n/g," "));c.decodeEntities&&(s.innerHTML=a,a=s.value);return a},a=b.columns(c.columns).indexes().map(function(a){return c.format.header(b.column(a).header().innerHTML,a)}).toArray(),f=b.table().footer()?b.columns(c.columns).indexes().map(function(a){var d=b.column(a).footer();
return c.format.footer(d?d.innerHTML:"",a)}).toArray():null,g=b.rows(c.rows,c.modifier).indexes().toArray(),g=b.cells(g,c.columns).render(c.orthogonal).toArray(),j=a.length,h=0<j?g.length/j:0,l=Array(h),m=0,n=0;n<h;n++){for(var o=Array(j),p=0;p<j;p++)o[p]=c.format.body(g[m],p,n),m++;l[n]=o}return{header:a,footer:f,body:l}}});var s=e("<textarea/>")[0];e.fn.dataTable.Buttons=l;e.fn.DataTable.Buttons=l;e(n).on("init.dt plugin-init.dt",function(a,b){if("dt"===a.namespace){var c=b.oInit.buttons||i.defaults.buttons;
c&&!b._buttons&&(new l(b,c)).container()}});i.ext.feature.push({fnInit:function(a){var a=new i.Api(a),b=a.init().buttons||i.defaults.buttons;return(new l(a,b)).container()},cFeature:"B"});return l});