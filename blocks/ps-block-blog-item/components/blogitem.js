/**
 * blogItem Block Wrapper
 */

// Setup the block
const { Component } = wp.element;

// Import block dependencies and components
import classnames from 'classnames';
import * as fontSize from './../../../utils/helper';

/**
 * Create a blogItem wrapper Component
 */
export default class BlogItem extends Component {

	constructor( props ) {
		super( ...arguments );
	}

	render() {

		// Setup the attributes
		const { attributes: { blogItemAlignment, blogItemImgURL, blogItemBackgroundColor, blogItemTextColor, blogItemFontSize, blogItemCiteAlign }  } = this.props;

		return (
			<div 
				style={ {
					backgroundColor: blogItemBackgroundColor,
					color: blogItemTextColor,
				} }
				className={ classnames(
					this.props.className,
					blogItemCiteAlign,
					{ 'ps-has-avatar': blogItemImgURL },
					'ps-font-size-' + blogItemFontSize,
					'ps-block-blogItem'
				) }
			>
				{ this.props.children }
			</div>
		);
	}
}
