var React = require('react');
var Dropzone = require('react-dropzone');

module.exports = React.createClass({
	
  getDefaultProps: function () {
    return {
      disableClick: false,
      multiple: false
    };
  },

  getInitialState: function () {
    return {
      files: [],
      file: ''
    };
  },

  onDrop: function (files) {
    this.setState({
      files: files,
      file: files[0],
      image_width: 1,
      image_height: 1
    });

    var fr = new FileReader;
    fr.readAsDataURL(files[0]);
console.log(fr);
    fr.onload = function() {
        var img = new Image;
        
        img.onload = function() {
          this.setState({image_width: img.width, image_height: img.height });
        };
        
        img.src = fr.result;
    };
    
    
    console.log(files[0], this.state.image_width, this.state.image_height);

    if(this.state.files.length == 1){
      $('#image-article').hide();
      $('input[type=file]').attr('name', 'article_image');
    }
  },

  onOpenClick: function (e) {
    e.preventDefault();
    this.refs.dropzone.open();
  },

  onOpenLibrary:function(e){
    e.preventDefault();
    e.stopPropagation();
    $('.step-2').hide();
    console.log("Open Library");

  },

  showError: function(){
    return(
      <div className="warning center">
        <p>You are trying to upload more than one image</p>
      </div>
    );
    console.log("ERROR");
  },

  render: function () {
    var style = {
        borderWidth: 0,
        borderColor: 'transparent',
        borderStyle: 'none',
        borderRadius: 0,
        margin: 0,
        padding: 0,
        width: 'auto'
      };

    return (
     <div>
       <Dropzone style={style} ref="dropzone" onDrop={this.onDrop}>
        	<div className="dz-message center" data-dz-message>
                <span className="glyphicon glyphicon-picture"></span>
                <div id="img-container">
                  <h2>Add an image to your article</h2>
                  <label className="padding-top">Drag image here or Click to Upload</label>

                  <div className="library">
                    <label>Dont have an image? Choose from our Free <a name="search-lib" id="search-lib" data-toggle="modal" data-target="#library" onClick={this.onOpenLibrary} >Photo Library!</a></label>
                  </div>
                </div>
         	</div>
       </Dropzone>
        { ( this.state.files.length > 0 && this.state.files.length < 2) ? <div>
          <h3>Current image</h3>
          <div><img src={ (this.state.file.preview )} /></div>
        </div> : null }
      </div>
    );
}
});

