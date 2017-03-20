<!-- answer_AB_tout_rocket -->

<script>
(function(){
    var lucky_number = Math.floor((Math.random() * 100) + 1);
    if ((lucky_number % 2) == 0) {
        appendRocketYieldAd();
    } else {
        appendToutAd();
    }
    
    //weighted logic
    /*
  var n=Math.floor(Math.random()*100)
  switch(n){
    case n<=50:
      appendRocketYieldAd();
      break;
    case n>50:
      appendToutAd();
      break;
  }
  */
})();    

    function appendRocketYieldAd(){
        try {
            var article_div = document.getElementById("article-body");
            if (article_div) {
                console.log("Appending RocketYield script");                
                window['_rocketyield'] = [];
                !function (e, f, u) {
                    var c = document.getElementById('article-body');
                    var d = c.getElementsByTagName('P');
                    if (d.length >10) {
                        var my_div = document.createElement('DIV');    
                        my_div.id = 'temp_div';
                        c.insertBefore(my_div, c.childNodes[10]); 
                    }
                    e.async = 1;
                    e.src = u;
                    f.parentNode.insertBefore(e, f);
                }(document.createElement('script'), document.getElementsByTagName('script')[0], '//d1gqcw1vqdwn9k.cloudfront.net/ry.min.js');
                
                window['_rocketyield'].push({
                    pid: 'puckermob',
                    placementId: '44ee',
                    slot: '#temp_div',
                    width: 320,height: 240
                });            
            }
        } catch (err){
            console.log(err + " -VM");
        }
    };
       
    function appendToutAd() {
        try {
            var article_div = document.getElementById("article-body");
            if (article_div) {
                console.log("Appending tout-sdk div and script");                        
                var vm_div = document.createElement('DIV');
                vm_div.className = 'tout-sdk tout-top-article';
                article_div.parentNode.insertBefore(vm_div, article_div.nextSibling);
                
            var taut_script = document.createElement("script");
            taut_script.className = "tout-sdk tout-sdk-script-tag";
            taut_script.async = "async";
                    taut_script.innerHTML = '!function(){var TOUT=window.TOUT=window.TOUT||{},utils={getCanonicalLinkHref:function(){for(var links=document.getElementsByTagName("link"),i=0;i<links.length;i++)if("canonical"===links[i].getAttribute("rel"))return links[i].getAttribute("href");return""},getMetaTagContentByProperty:function(metaTagProperty){for(var metaTags=document.getElementsByTagName("meta"),i=0;i<metaTags.length;i++)if(metaTags[i].getAttribute("property")===metaTagProperty)return metaTags[i].getAttribute("content");return""},getWindowLocationOrigin:function(){return window.location.protocol+"//"+window.location.host},getCanonicalUrl:function(){var canonicalUrl=utils.getCanonicalLinkHref()||utils.getMetaTagContentByProperty("og:url");return canonicalUrl&&"/"===canonicalUrl[0]&&(canonicalUrl=utils.getWindowLocationOrigin()+canonicalUrl),canonicalUrl},getOgUrl:function(){var ogUrl=utils.getMetaTagContentByProperty("og:url");return ogUrl&&"/"===ogUrl[0]&&(ogUrl=utils.getWindowLocationOrigin()+ogUrl),ogUrl},getRelCanonical:function(){var relCanonical=utils.getCanonicalLinkHref();return relCanonical&&"/"===relCanonical[0]&&(relCanonical=utils.getWindowLocationOrigin()+relCanonical),relCanonical},getExternalArticleId:function(){return utils.getMetaTagContentByProperty("tout:article:id")},getCurrentProtocol:function(){return"https:"===document.location.protocol?"https:":"http:"},getPlatformHost:function(){return TOUT.SDK_HOST||"platform.tout.com"}};TOUT.mapAsyncFetchApp={init:function(brandUid,options){this.brandUid=brandUid,this.active=!0,this.productFetched=!1,this.dataLoaded=!1,this.startedSuccessfully=!1,this.options=options||{},this.options.paramsWhitelist||(this.options.paramsWhitelist=["brand_uid","external_article_id","og_url","window_location","rel_canonical","async_fetch"])},fetch:function(){var script=document.createElement("script"),src=utils.getCurrentProtocol()+"//"+utils.getPlatformHost()+"/mid_article_player.js",params=TOUT.mapAsyncFetchApp.getMidArticleQueryParams(),joinCharacter="?";for(var param in params)params.hasOwnProperty(param)&&""!==params[param]&&(src+=joinCharacter+param+"="+encodeURIComponent(params[param]),joinCharacter="&");script.src=src;var firstScript=document.getElementsByTagName("script")[0];firstScript.parentNode.insertBefore(script,firstScript)},start:function(){this.productFetched&&this.dataLoaded&&!this.startedSuccessfully&&(this.startedSuccessfully=!0,TOUT.midArticleProductLoader.start(TOUT.data.mid_article_player_experiment))},getMidArticleQueryParams:function(){var params={};return this._whitelistContains("brand_uid")&&(params.brand_uid=this.brandUid),this._whitelistContains("content_referrer")&&(params.content_referrer=document.referrer),this._whitelistContains("external_article_id")&&(params.external_article_id=utils.getExternalArticleId()),this._whitelistContains("og_url")&&(params.og_url=utils.getOgUrl()),this._whitelistContains("window_location")&&(params.window_location=document.location.href),this._whitelistContains("rel_canonical")&&(params.rel_canonical=utils.getRelCanonical()),this._whitelistContains("async_fetch")&&(params.async_fetch=!0),params},_whitelistContains:function(value){return this.options.paramsWhitelist&&this.options.paramsWhitelist.indexOf(value)>-1}}}();' +
                            '!function(){var TOUT=window.TOUT=window.TOUT||{};if(console&&console.log&&console.log("Tout SDK: "+ +new Date),!TOUT._sdkScriptTagParsedAt){TOUT._sdkScriptTagParsedAt=new Date,TOUT.EMBED_CODE_VERSION="1.2.0";var sdkHost=TOUT.SDK_HOST||"platform.tout.com",sdkProtocol=TOUT.SDK_PROTOCOL||("https:"==window.location.protocol?"https:":"http:"),analyticsHost=TOUT.SDK_ANALYTICS_HOST||"analytics.tout.com",analyticsProtocol=TOUT.SDK_ANALYTICS_PROTOCOL||sdkProtocol;TOUT.onReady=TOUT.onReady||function(func){return TOUT._onReadyQueue=TOUT._onReadyQueue||[],TOUT._onReadyQueue.push(func),TOUT},TOUT.fireSimpleAnalyticsPixel=function(trigger_name,attrs){var img=new Image,url=analyticsProtocol+"//"+analyticsHost+"/events?trigger="+trigger_name;for(var attr in attrs)attrs.hasOwnProperty(attr)&&(url+="&"+attr+"="+encodeURIComponent(attrs[attr]));return img.src=url,img},TOUT.init=function(brandUid,options){options=options||{};var sdkScriptId="tout-js-sdk";if(document.getElementById(sdkScriptId)&&!options.forceInit)return TOUT;if(brandUid=TOUT.SDK_BRAND_UID||brandUid,"undefined"==typeof brandUid||"string"!=typeof brandUid||0===brandUid.length||brandUid.length>7)return TOUT.fireSimpleAnalyticsPixel("sdk_log",{log_level:"error",log_message:"BRAND_UID_NOT_DEFINED",content_page_url:window.location.href}),console&&console.error&&console.error("TOUT - Invalid Brand UID: "+brandUid),TOUT;TOUT._initOptions=options;var script=document.createElement("script");script.type="text/javascript",script.src=sdkProtocol+"//"+sdkHost+"/sdk/v1/"+brandUid+".js",script.id=sdkScriptId,script.className="tout-sdk";var firstScript=document.getElementsByTagName("script")[0];return firstScript.parentNode.insertBefore(script,firstScript),TOUT.fireSimpleAnalyticsPixel("sdk_initialized",{content_brand_uid:brandUid,sdk_embed_code_version:TOUT.EMBED_CODE_VERSION,content_page_url:window.location.href}),TOUT}}}();' +
                            '(function(){' +
                            ' var brandUid = \'a8ae75\';' +
                            ' TOUT.mapAsyncFetchApp.init(brandUid);' +
                            ' TOUT.init(brandUid);' +
                            ' TOUT.mapAsyncFetchApp.fetch();' +
                            '})();';
                    document.body.appendChild(taut_script);
                }        
            } catch (err) {
                        console.log(err + " -VM");
            }
    };
</script>