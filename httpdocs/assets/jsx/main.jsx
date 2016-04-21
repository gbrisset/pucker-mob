var $ = require('jquery');
var React = require('react');
var ReactDOM = require('react-dom');
var FormattingTips = require('./components/admin/formatting_tips.jsx');
var Header = require('./components/admin/header.jsx');
var DropImage = require('./components/admin/dropimage.jsx');



ReactDOM.render(<Header />, document.getElementById('nav-bar'));
ReactDOM.render(<FormattingTips />, document.getElementById('formatting-tips-box'));