var ReactDOM = require('react-dom');

var React = require('react');
var Dropzone = require('react-dropzone');

var DropzoneDemo = React.createClass({
    onDrop: function(files){
        var req = request.post('/upload');
        files.forEach((file)=> {
            req.attach(file.name, file);
        });
        req.end(callback);
    },

    onOpenClick: function () {
      this.refs.dropzone.open();
    },

    render: function () {
      return 
          <div>
            <Dropzone ref="dropzone" onDrop={this.onDrop} >
              <div>Try dropping some files here, or click to select files to upload.</div>
            </Dropzone>
            <button type="button" onClick={this.onOpenClick}>
                Open Dropzone
            </button>
            {this.state.files ? <div>
            <h2>Uploading {files.length} files...</h2>
            <div><img src={file.preview} /></div>
            </div> : null}
          </div>
     
    }
});

React.ReactDOM(<DropzoneDemo />, document.body);