/**
 * BLOCK: prosys Blocks BlogItem
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';
import BlogItem from './components/blogitem';
import icons from './components/icons';

// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

// Internationalization
const { __ } = wp.i18n;

// Extend component
const { Component } = wp.element;

// Register block
const { registerBlockType } = wp.blocks;

// Register editor components
const {
	RichText,
	AlignmentToolbar,
	BlockControls,
	BlockAlignmentToolbar,
	MediaUpload,
} = wp.editor;

// Register components
const {
	Button,
	SelectControl,
} = wp.components;

const ALLOWED_MEDIA_TYPES = [ 'image' ];

class PSBlogItemBlock extends Component {

	render() {

		// Setup the attributes
		const {
			attributes: {
				blogItemName,
				blogItemTitle,
				blogItemContent,
				blogItemAlignment,
				blogItemImgURL,
				blogItemImgID,
				blogItemBackgroundColor,
				blogItemTextColor,
				blogItemFontSize,
				blogItemCiteAlign
			},
			attributes,
			isSelected,
			editable,
			className,
			setAttributes
		} = this.props;

		const onSelectImage = img => {
			setAttributes( {
				blogItemImgID: img.id,
				blogItemImgURL: img.url,
			} );
		};

		return [
			// Show the alignment toolbar on focus
			<BlockControls key="controls">
				<AlignmentToolbar
					value={ blogItemAlignment }
					onChange={ ( value ) => setAttributes( { blogItemAlignment: value } ) }
				/>
			</BlockControls>,
			// Show the block controls on focus
			<Inspector
				{ ...{ setAttributes, ...this.props } }
			/>,
			// Show the block markup in the editor
			<BlogItem { ...this.props }>
				<RichText
					tagName="div"
					multiline="p"
					placeholder={ __( 'Add blog Item text...', 'prosys-blocks' ) }
					keepPlaceholderOnFocus
					value={ blogItemContent }
					formattingControls={ [ 'bold', 'italic', 'strikethrough', 'link' ] }
					className={ classnames(
						'ps-blogItem-text'
					) }
					style={ {
						textAlign: blogItemAlignment,
					} }
					onChange={ ( value ) => setAttributes( { blogItemContent: value } ) }
				/>

				<div class="ps-blogItem-info">
					<div class="ps-blogItem-avatar-wrap">
						<div class="ps-blogItem-image-wrap">
							<MediaUpload
								buttonProps={ {
									className: 'change-image'
								} }
								onSelect={ ( img ) => setAttributes(
									{
										blogItemImgID: img.id,
										blogItemImgURL: img.url,
									}
								) }
								allowed={ ALLOWED_MEDIA_TYPES }
								type="image"
								value={ blogItemImgID }
								render={ ( { open } ) => (
									<Button onClick={ open }>
										{ ! blogItemImgID ? icons.upload : <img
											class="ps-blogItem-avatar"
											src={ blogItemImgURL }
											alt="avatar"
										/>  }
									</Button>
								) }
							>
							</MediaUpload>
						</div>
					</div>

					<RichText
						tagName="h2"
						placeholder={ __( 'Add name', 'prosys-blocks' ) }
						keepPlaceholderOnFocus
						value={ blogItemName }
						className='ps-blogItem-name'
						style={ {
							color: blogItemTextColor
						} }
						onChange={ ( value ) => this.props.setAttributes( { blogItemName: value } ) }
					/>

					<RichText
						tagName="small"
						placeholder={ __( 'Add title', 'prosys-blocks' ) }
						keepPlaceholderOnFocus
						value={ blogItemTitle }
						className='ps-blogItem-title'
						style={ {
							color: blogItemTextColor
						} }
						onChange={ ( value ) => this.props.setAttributes( { blogItemTitle: value } ) }
					/>
				</div>
			</BlogItem>
		];
	}
}

// Register the block
registerBlockType( 'prosys-blocks/ps-blogItem', {
	title: __( 'PS blogItem', 'prosys-blocks' ),
	description: __( 'Add a user blogItem with a name and title.', 'prosys-blocks' ),
	icon: 'format-quote',
	category: 'prosys-blocks',
	keywords: [
		__( 'Blog Item', 'prosys-blocks' ),
		__( 'quote', 'prosys-blocks' ),
		__( 'prosys', 'prosys-blocks' ),
	],
	attributes: {
		blogItemName: {
			type: 'array',
			selector: '.ps-blogItem-name',
			source: 'children',
		},
		blogItemTitle: {
			type: 'array',
			selector: '.ps-blogItem-title',
			source: 'children',
		},
		blogItemContent: {
			type: 'array',
			selector: '.ps-blogItem-text',
			source: 'children',
		},
		blogItemAlignment: {
			type: 'string',
		},
		blogItemImgURL: {
			type: 'string',
			source: 'attribute',
			attribute: 'src',
			selector: 'img',
		},
		blogItemImgID: {
			type: 'number',
		},
		blogItemBackgroundColor: {
			type: 'string',
			default: '#f2f2f2'
		},
		blogItemTextColor: {
			type: 'string',
			default: '#32373c'
		},
		blogItemFontSize: {
			type: 'number',
			default: 18,
		},
		blogItemCiteAlign: {
            type: 'string',
            default: 'left-aligned',
        },
	},

	// Render the block components
	edit: PSBlogItemBlock,

	// Save the attributes and markup
	save: function( props ) {

		// Setup the attributes
		const {
			blogItemName,
			blogItemTitle,
			blogItemContent,
			blogItemAlignment,
			blogItemImgURL,
			blogItemImgID,
			blogItemBackgroundColor,
			blogItemTextColor,
			blogItemFontSize,
			blogItemCiteAlign
		} = props.attributes;

		// Save the block markup for the front end
		return (
			<BlogItem { ...props }>
				<RichText.Content
					tagName="div"
					className="ps-blogItem-text"
					style={ {
						textAlign: blogItemAlignment,
					} }
					value={ blogItemContent }
				/>

				<div class="ps-blogItem-info">
					{ blogItemImgURL && (
						<div class="ps-blogItem-avatar-wrap">
							<div class="ps-blogItem-image-wrap">
								<img
									class="ps-blogItem-avatar"
									src={ blogItemImgURL }
									alt="avatar"
								/>
							</div>
						</div>
					) }

					{ blogItemName && (
						<RichText.Content
							tagName="h2"
							className="ps-blogItem-name"
							style={ {
								color: blogItemTextColor
							} }
							value={ blogItemName }
						/>
					) }

					{ blogItemTitle && (
						<RichText.Content
							tagName="small"
							className="ps-blogItem-title"
							style={ {
								color: blogItemTextColor
							} }
							value={ blogItemTitle }
						/>
					) }
				</div>
			</BlogItem>
		);
	},
} );
