<script id="spout-tag-31ca72ea-3bd8-4f6e-83a1-0c985c3deaf8">
  (function() {
    var r = encodeURIComponent(top.document.referrer.substring(0,250)),
        p = encodeURIComponent(top.document.location.href.substring(0,250)),
        t = Date.now(),
        u = '31ca72ea-3bd8-4f6e-83a1-0c985c3deaf8',
        o = encodeURIComponent(JSON.stringify({
          dfpViewUrl: '%%VIEW_URL_UNESC%%',
          dfpClickUrl: '%%CLICK_URL_UNESC%%'
        })),
        e = document.createElement('script'),
        s = sessionStorage.getItem('spoutable-' + u);
    if (!s) {
      var m = Math.random.bind(Math);
      s = JSON.stringify({ sessionId: [ t, m(), m(), m(), m(), m(), m(), m(), m(), m(), m(), m(), m() ]});
      sessionStorage.setItem('spoutable-' + u, s);
    }
    e.async = true;
    e.src='//s.spoutable.com/s?u='+u+'&s='+encodeURIComponent(s)+'&t='+t+'&o='+o+'&r='+r+'&p='+p;
 document.head.appendChild(e); 

  })();
</script>