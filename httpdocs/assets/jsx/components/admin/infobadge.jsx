var React = require('react');
var ReactDOM = require('react-dom');

module.exports = React.createClass({

	render: function(){
		return <div id="info-badge" className="header-position hide-for-print">
				<div className="row">
			      <ul className="columns">
			        <li className="columns"><i className="fa fa-envelope-o"></i><span className="badge highlight round">4</span></li>
			        <li className="columns"><i className="fa fa-bar-chart"></i><span className="badge highlight round">17</span></li>
			        <li className="columns left"><i className="fa fa-file-text-o"></i><span className="badge highlight round">17</span></li>
			      </ul>
			    </div>
		        </div>
	}
	
});
