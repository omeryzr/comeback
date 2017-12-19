/*!
 * Bootstrap v3.3.7 (http://getbootstrap.com)
 * Copyright 2011-2016 Twitter, Inc.
 * Licensed under the MIT license
 */
 $(function(){

     $('.input-group .btn:first-of-type').on('click', function() {
       var btn = $(this);
       var input = btn.closest('.input-group').find('input');
       if (input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max'))) {
         input.val(parseInt(input.val(), 10) + 1);
       } else {
         btn.next("disabled", true);
       }
     });
     $('.input-group .btn:last-of-type').on('click', function() {
       var btn = $(this);
       var input = btn.closest('.input-group').find('input');
       if (input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min'))) {
         input.val(parseInt(input.val(), 10) - 1);
       } else {
         btn.prev("disabled", true);
       }
     });

 })
