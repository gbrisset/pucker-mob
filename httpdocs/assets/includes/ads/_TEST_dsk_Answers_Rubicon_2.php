<!-- _TEST_dsk_Answers_Rubicon_2 -->
<script type="text/javascript">
(function()
{
  var lkqdSettings = {
    pid: 130,
    sid: 483777,
    playerContainerId: 'ad' + Math.round(Math.random()*1000000000).toString(),
    playerId: '',
    playerWidth: 300,
    playerHeight: 250,
    execution: 'inbanner',
    placement: '',
    passbackFirst: false,
    playInitiation: 'auto',
    volume: 0,
    pageUrl: '',
    trackImp: '',
    trackClick: '',
    custom1: '',
    custom2: '',
    custom3: '',
    pubMacros: '',
    dfp: false,
    lkqdId: new Date().getTime().toString() + Math.round(Math.random()*1000000000).toString(),
    supplyContentVideo: {
      url: '', clickurl: '', play: 'pre'
    }
  };

  var lkqdVPAID;
  var creativeData = '';
  if (!document.getElementById(lkqdSettings.playerContainerId)) { try { if (document.readyState && document.readyState != 'complete' && document.readyState != 'interactive'){ document.write('<div id=' + lkqdSettings.playerContainerId + '></div>'); }} catch (e) {}}
  var environmentVars = { slot: document.getElementById(lkqdSettings.playerContainerId), videoSlot: document.getElementById(lkqdSettings.playerId), videoSlotCanAutoPlay: true, lkqdSettings: lkqdSettings };

  function onVPAIDLoad()
  {
    lkqdVPAID.subscribe(function() { lkqdVPAID.startAd(); }, 'AdLoaded');
  }

  var vpaidFrame = document.createElement('iframe');
  vpaidFrame.id = lkqdSettings.lkqdId;
  vpaidFrame.name = lkqdSettings.lkqdId;
  vpaidFrame.style.display = 'none';
  var vpaidFrameLoaded = function() {
    vpaidLoader = vpaidFrame.contentWindow.document.createElement('script');
    vpaidLoader.src = 'https://ad.lkqd.net/vpaid/formats.js?pid=130&sid=483777';
    vpaidLoader.onload = function() {
      lkqdVPAID = vpaidFrame.contentWindow.getVPAIDAd();
      onVPAIDLoad();
      lkqdVPAID.handshakeVersion('2.0');
      lkqdVPAID.initAd(lkqdSettings.playerWidth, lkqdSettings.playerHeight, 'normal', 600, creativeData, environmentVars);
    };
    vpaidFrame.contentWindow.document.body.appendChild(vpaidLoader);
  };
  vpaidFrame.onload = vpaidFrameLoaded;
  vpaidFrame.onerror = vpaidFrameLoaded;
  document.documentElement.appendChild(vpaidFrame);
})();
</script>