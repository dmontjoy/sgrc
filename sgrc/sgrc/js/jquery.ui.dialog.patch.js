/**
 * This is part of a patch to address a jQueryUI bug.  The bug is responsible
 * for the inability to scroll a page when a modal dialog is active. If the content
 * of the dialog extends beyond the bottom of the viewport, the user is only able
 * to scroll with a mousewheel or up/down keyboard keys.
 *
 * @see http://bugs.jqueryui.com/ticket/4671
 * @see https://bugs.webkit.org/show_bug.cgi?id=19033
 * @see /views_ui.module
 * @see /js/jquery.ui.dialog.min.js
 *
 * This javascript patch overwrites the $.ui.dialog.overlay.events object to remove
 * the mousedown, mouseup and click events from the list of events that are bound
 * in $.ui.dialog.overlay.create
 *
 * The original code for this object:
 * $.ui.dialog.overlay.events: $.map('focus,mousedown,mouseup,keydown,keypress,click'.split(','),
 *  function(event) { return event + '.dialog-overlay'; }).join(' '),
 *
 */
/*

(function( $, undefined ) {
  if ($.ui && $.ui.dialog) {
    $.ui.dialog.overlay.events = $.map('focus,keydown,keypress'.split(','), function(event) { return event + '.dialog-overlay'; }).join(' ');
  }
}(jQuery));

*/

    $.fn.center = function () {
        
        var top =0;
        var left=0;
  
        //top  =  ( ( $(window).height() - this.outerHeight()  ) / 2 ) + $(document).scrollTop();
        top  =   document.body.scrollTop;
        //top  =  ( ( $("#cuerpo").height() - this.parent().height()  ) / 2 ) ;
        //top = $('body').scrollTop();
        //alert(' clientHeight ' + $("#cuerpo").height() + ' parent.height ' + this.parent().height()  + ' scroll ' + document.body.scrollTop);
        left =  ( document.body.clientWidth - this.parent().width()  ) / 2 +$(window).scrollLeft() ; 
        
        if(top<0){
            top = 10;          
        }
        this.parent().css("z-index","4005");    
        this.parent().css("position","absolute");
        this.parent().css("top", top + "px");
        this.parent().css("left", left + "px");
        
        $('html, body').scrollTop(top);
        
        
        return this;
    }

    $.fn.centerLogin = function () {
        var top =0;
        var left=0;
                    
        top =   (( document.body.clientHeight - 340  ) / 2 +$(window).scrollTop()) -20 ;
        left =  (( document.body.clientWidth - 340  ) / 2 +$(window).scrollLeft())-320 ;
                                   
        this.css("position","absolute");
        this.css("top", top + "px");
        this.css("left", left + "px");
        return this;
    }