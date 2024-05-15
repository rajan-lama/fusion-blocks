/**
 * Inspector Controls
 */

// Setup the block
const { __ } = wp.i18n;
const { Component } = wp.element;

// Import block components
const {
	InspectorControls,
	BlockDescription,
	ColorPalette,
	PanelColorSettings,
} = wp.editor;

// Import Inspector components
const {
	Toolbar,
	Button,
	PanelBody,
	PanelRow,
	FormToggle,
	RangeControl,
	SelectControl,
} = wp.components;

/**
 * Create an Inspector Controls wrapper Component
 */
export default class Inspector extends Component {

	constructor( props ) {
		super( ...arguments );
	}

	render() {

		// Cite Alignment Options
		const citeAlignOptions = [
			{ value: 'left-aligned', label: __( 'Left Aligned' ) },
			{ value: 'right-aligned', label: __( 'Right Aligned' ) },
		];

		const backgroundColors = [
			{ color: '#00d1b2', name: 'teal' },
			{ color: '#3373dc', name: 'royal blue' },
			{ color: '#209cef', name: 'sky blue' },
			{ color: '#22d25f', name: 'green' },
			{ color: '#ffdd57', name: 'yellow' },
			{ color: '#ff3860', name: 'pink' },
			{ color: '#7941b6', name: 'purple' },
			{ color: '#392F43', name: 'black' },
		];

		// Setup the attributes
		const { attributes: { blogItemName, blogItemTitle, blogItemContent, blogItemAlignment, blogItemImgURL, blogItemImgID, blogItemBackgroundColor, blogItemTextColor, blogItemFontSize, blogItemCiteAlign }, isSelected, className, setAttributes } = this.props;

		// Update color values
		const onChangeBackgroundColor = value => setAttributes( { blogItemBackgroundColor: value } );
		const onChangeTextColor = value => setAttributes( { blogItemTextColor: value } );

		return (
		<InspectorControls key="inspector">
			<PanelBody>
				<RangeControl
					label={ __( 'Font Size' ) }
					value={ blogItemFontSize }
					onChange={ ( value ) => this.props.setAttributes( { blogItemFontSize: value } ) }
					min={ 14 }
					max={ 24 }
					step={ 1 }
				/>

				<SelectControl
					label={ __( 'Cite Alignment' ) }
					description={ __( 'Left or right align the cite name and title.' ) }
					options={ citeAlignOptions }
					value={ blogItemCiteAlign }
					onChange={ ( value ) => this.props.setAttributes( { blogItemCiteAlign: value } ) }
				/>

				<PanelColorSettings
					title={ __( 'Background Color' ) }
					initialOpen={ false }
					colorSettings={ [ {
						value: blogItemBackgroundColor,
						colors: backgroundColors,
						onChange: onChangeBackgroundColor,
						label: __( 'Background Color' ),

					} ] }
				>
				</PanelColorSettings>

				<PanelColorSettings
					title={ __( 'Text Color' ) }
					initialOpen={ false }
					colorSettings={ [ {
						value: blogItemTextColor,
						onChange: onChangeTextColor,
						label: __( 'Text Color' ),
					} ] }
				>
				</PanelColorSettings>
			</PanelBody>
		</InspectorControls>
		);
	}
}
