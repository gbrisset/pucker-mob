<html>
<head>
	


</head>
<body>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/modernizr.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<!-- Load widget code -->
<script type="text/javascript" src="http://feather.aviary.com/imaging/v3/editor.js"></script>


<!-- Instantiate the widget -->
<script type="text/javascript">

    var featherEditor = new Aviary.Feather({
        apiKey: '1234567',
        tools: ['draw', 'stickers', 'crop', 'resize'],
        onSave: function(imageID, newURL) {
            var img = document.getElementById(imageID);
            img.src = newURL;

               $.ajax({
                type: 'POST',
                dataType: 'json',
                data: { task: 'get_edited_image', articleId: 3, url:newURL, dirDest:'temp' },
                url: "http://www.puckermob.com/getImage.php",
                success: function(msg) {
                    var status = 'success';
                    if(msg['hasError']) status = 'error';

                    $('#msg').html(msg['message']).addClass(status);
                },
                error: function(){
                    var status = 'error';
                    var msg = 'Ouch! something happend!';

                    $('#msg').show();
                }
            });

            featherEditor.close();
        }
    });

    function launchEditor(id, src) {
        console.log('launchEditor', id, src);
        featherEditor.launch({
            image: id,
            url: src
        });
        return false;
    }

    //launchEditor('editableimage1',  'http://images.puckermob.com/articlesites/puckermob/large/19552_tall.jpg');

</script>                         

<!-- Add an edit button, passing the HTML id of the image
    and the public URL to the image -->

<br>
<!-- original line of HTML here: -->
<img id="editableimage1" src="http://images.puckermob.com/articlesites/puckermob/large/19552_tall.jpg"/>
<br>
<a href="#" onclick="return launchEditor('editableimage1', 
    'http://images.puckermob.com/articlesites/puckermob/large/19552_tall.jpg');" style="width: 100%;
    background: black;
    padding: 1rem;
    color: white;
    clear: both;
    text-transform: uppercase;">Edit!</a>
<a id="msg" href="http://www.puckermob.com/3_tall.jpg" target="_blank" style=" display:none;
">View New Image</a>
</body>
</html>