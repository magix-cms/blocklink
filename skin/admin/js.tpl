{script src="/{baseadmin}/min/?f=plugins/{$pluginName}/js/bootstrap-toggle.min.js,plugins/{$pluginName}/js/search.min.js,plugins/{$pluginName}/js/src/admin.js" concat={$concat} type="javascript"}
<script type="text/javascript">
    $(function(){
        // --- Initialize live search input
        if (typeof search_Mod == "undefined")
        {
            console.log("search_Mod is not defined");
        }else{
            search_Mod.run(baseadmin,getlang);
        }

        // --- Initialize main js
        if (typeof MC_plugins_advantage == "undefined")
        {
            console.log("MC_plugins_advantage is not defined");
        }else{
            MC_plugins_advantage.run(baseadmin,getlang);
        }
    });
</script>