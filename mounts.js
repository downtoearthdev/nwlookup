$(document).ready(function(){

    $('.insigdesc').tooltipster({
      functionBefore: function(instance, helper) {
        var $origin = $(helper.origin);
        var text = $.trim($origin.text());    
        if ($origin.data('loaded') !== true) {
            $.ajax({
                dataType: "json",
                url:'mounts.php',
                type:'get',
                data:{bonus:text},
                success: function(response){
                    // Setting content option
                instance.content(response.message);
                }
            });
            $origin.data('loaded', true);
      }
    }
    });

    $('.mountpreview').tooltipster({
      contentAsHTML: true,
      trackTooltip: true,
      functionBefore: function(instance, helper) {
        var $origin = $(helper.origin);
        var text = $.trim($origin.text());    
        if ($origin.data('loaded') !== true) {
            $.ajax({
                dataType: "json",
                url:'mounts.php',
                type:'get',
                data:{name:text},
                success: function(response){
                    // Setting content option
                instance.content("<img src=\""+response.message.picture+"\">"+response.message.name);
                }
            });
            $origin.data('loaded', true);
      }
    }
    });

    $("select#Insignias").change(function() {
        if($(this).val() != "") {
            $("select#Names").prop("disabled", true);
            $("select#Types").prop("disabled", true);
        }
        else {
            $("select#Names").prop("disabled", false);
            $("select#Types").prop("disabled", false);
        }

    });

     $("select#Names").change(function() {
        if($(this).val() != "") {
            $("select#Insignias").prop("disabled", true);
            $("select#Types").prop("disabled", true);
        }
        else {
            $("select#Insignias").prop("disabled", false);
            $("select#Types").prop("disabled", false);
        }

    });

    $("select#Types").change(function() {
        if($(this).val() != "") {
            $("select#Names").prop("disabled", true);
            $("select#Insignias").prop("disabled", true);
        }
        else {
            $("select#Names").prop("disabled", false);
            $("select#Insignias").prop("disabled", false);
        }

    });
});