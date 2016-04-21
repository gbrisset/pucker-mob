var React = require('react');
var InfoBadge = require('./infobadge.jsx');

module.exports = React.createClass({

	render: function(){
		return <nav className="top-bar" data-topbar="" data-options="scrolltop: false;">
		      <ul className="title-area small-12 columns">
		        <li className="name small-12 large-3  columns">
		         <span className="small-2 large-1 columns align-left" id="sub-menu-button"><i className="fa fa-bars no-margin"></i></span>
		         <h1  className="small-10 large-11 columns no-padding">
		           <a href="<?php echo $config['this_url']; ?>">  PUCKERMOB  </a>
		         </h1> 
		        </li>
		        <li className="small-10 large-9 columns show-for-large-up left">
		          <InfoBadge />
		        </li>
		      </ul>
		    </nav>
	}
	
});