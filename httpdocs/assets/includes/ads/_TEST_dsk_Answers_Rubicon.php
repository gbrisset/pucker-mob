<!-- _TEST_dsk_Answers_Rubicon -->
<script type="text/javascript">
 (function() {
   function loadIt() {
     console.log("DOM fully loaded and parsed");

     // Enter OutStream configuration options HERE //
     var configParams = {
       "width": 640,
       "height": 360,
       "k_pos": "after",
       "k_placement": "a/top",
       "k_align": "center"
     };

     // End OutStream configuration options //

     var doc = top.window.document;

     var as = doc.createElement('script'),
       aT = '//video-ads-apex.rubiconproject.com/apex/16904/151438/719394/203/apex.js?r=' + Math.random() * 10000000000000000;

     as.type = 'text/javascript';
     as.src = aT;
     as.async = true;

     if (as.textContent) {
       as.textContent = JSON.stringify(configParams);
     } else {
       as.innerText = JSON.stringify(configParams);
     }
     doc.body.appendChild(as);

   }


   if (document.readyState === "complete" || (document.readyState !== "loading" && !document.documentElement.doScroll)) {
     loadIt();
   } else {
     document.addEventListener("DOMContentLoaded", loadIt);
   }

 }());
</script>
