jQuery(function () {

    function caljApiObtainListener (msg) {
        if(undefined !== msg.data.caljApiKey) {
            jQuery("#calj_api_key").val(msg.data.caljApiKey);
            // Save data
            jQuery.ajax({
                url: document.location.href,
                type: "POST",
                data: {
                    "calj-op": "save-obtained-key",
                    "calj-key": msg.data.caljApiKey
                }
            });
        }
        if (undefined !== msg.data.caljClose) {
            jQuery("#TB_closeWindowButton").click();
        }
    }

    if (window.addEventListener) { addEventListener("message", caljApiObtainListener, false); }
    else { attachEvent("onmessage", caljApiObtainListener); }


    jQuery(".button-calj-obtain-key").click(function () {
        setTimeout(function () {
            // Transaction inside the iframe is serious. Do not close the iframe inadvertently by clicking outside.
            jQuery("#TB_overlay").off();
        }, 500);
    });

    jQuery(".button-calj-clear-chache-now").click(function () {
        var $link = jQuery(this);
        jQuery.ajax({
            "type": "POST",
            "data": {
                "calj-clear-cache": 1
            },
            "success": function () {
                jQuery(".calj-ok-cache-cleared").css("visibility", "visible");
                setTimeout(function () {
                    jQuery(".calj-ok-cache-cleared").css("visibility", "hidden");
                }, 5000);
            }
        });
        return false;
    });
});
