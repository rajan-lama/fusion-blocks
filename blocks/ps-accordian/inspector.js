/**
 * Internal block libraries
 */
const { __ } = wp.i18n;
const { Component } = wp.element;
const { InspectorControls, PanelColorSettings } = wp.editor;
const {
  CheckboxControl,
  PanelBody,
  PanelRow,
  RadioControl,
  RangeControl,
  TextControl,
  TextareaControl,
  ToggleControl,
  SelectControl
} = wp.components;

/**
 * Create an Inspector Controls wrapper Component
 */
export default class Inspector extends Component {
  constructor() {
    //super(...arguments);
    super(props);
}

  render() {
    const {
      attributes: {
        checkboxControl,
        colorPaletteControl,
        radioControl,
        rangeControl,
        textControl,
        textareaControl,
        toggleControl,
        selectControl
      },
      setAttributes
    } = this.props;

    return (
      <InspectorControls>
            <PanelBody title={ __( 'Accordion Settings' ) }>
                <RangeControl
                    label={ __( 'Bottom spacing' ) }
                    value={ marginBottom }
                    help={ __( 'Define space to next block. This will override Block spacing option (Frontend view only)' ) }
                    min={ 0 }
                    max={ 50 }
                    onChange={ ( value ) => setAttributes( { marginBottom: value } ) }
                />
            </PanelBody>

            <PanelBody title={ __( 'Header Settings' ) }>
                <BaseControl label={ __( 'Header Icon Style' ) }>
                    <div className="ppb-icon-items-wrapper">
                        {Object.keys( HEADER_ICONS ).map( ( key, index ) => (
                            <div className="ppb-icon-item" key={ index }>
                                    <span className={ key === headerIcon ? 'active' : '' }
                                          onClick={ () => setAttributes( { headerIcon: key } ) }>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            { HEADER_ICONS[key] }
                                        </svg>
                                    </span>
                            </div>
                        ) ) }
                    </div>
                </BaseControl>
                <PanelColorSettings
                    title={ __( 'Color Settings' ) }
                    initialOpen={ false }
                    colorSettings={ [
                        {
                            label: __( 'Background Color' ),
                            value: headerBgColor,
                            onChange: ( value ) => setAttributes( { headerBgColor: value === undefined ? '#000' : value } ),
                        },
                        {
                            label: __( 'Text Color' ),
                            value: headerTextColor,
                            onChange: ( value ) => setAttributes( { headerTextColor: value === undefined ? '#eee' : value } ),
                        },
                        {
                            label: __( 'Icon Color' ),
                            value: headerIconColor,
                            onChange: ( value ) => setAttributes( { headerIconColor: value === undefined ? '#fff' : value } ),
                        },
                    ] }
                />
            </PanelBody>
            <PanelColorSettings
                title={ __( 'Body Color Settings' ) }
                initialOpen={ false }
                colorSettings={ [
                    {
                        label: __( 'Background Color' ),
                        value: bodyBgColor,
                        onChange: ( value ) => setAttributes( { bodyBgColor: value } ),
                    },
                    {
                        label: __( 'Text Color' ),
                        value: bodyTextColor,
                        onChange: ( value ) => setAttributes( { bodyTextColor: value } ),
                    },
                ] }
            />
            <PanelBody title={ __( 'Border Settings' ) } initialOpen={ false }>
                <SelectControl
                    label={ __( 'Border Style' ) }
                    value={ borderStyle }
                    options={ [
                        { label: __( 'Solid' ), value: 'solid' },
                        { label: __( 'Dashed' ), value: 'dashed' },
                        { label: __( 'Dotted' ), value: 'dotted' },
                    ] }
                    onChange={ ( value ) => setAttributes( { borderStyle: value } ) }
                />
                <PanelColorSettings
                    title={ __( 'Color Settings' ) }
                    initialOpen={ false }
                    colorSettings={ [
                        {
                            label: __( 'Border Color' ),
                            value: borderColor,
                            onChange: ( value ) => setAttributes( { borderColor: value } ),
                        },
                    ] }
                />
                <RangeControl
                    label={ __( 'Border width' ) }
                    value={ borderWidth }
                    min={ 0 }
                    max={ 10 }
                    onChange={ ( value ) => setAttributes( { borderWidth: value } ) }
                />
                <RangeControl
                    label={ __( 'Border radius' ) }
                    value={ borderRadius }
                    min={ 0 }
                    max={ 100 }
                    onChange={ ( value ) => setAttributes( { borderRadius: value } ) }
                />
            </PanelBody>
            <PanelBody title={ __( 'Accordions State' ) } initialOpen={  false }>
                <ToggleControl
                    label={ __( 'Initial Collapsed' ) }
                    help={ __( 'Make all accordions collapsed by default, enable this setting to apply to all accordions.' ) }
                    checked={ collapsedAll }
                    onChange={ () => setAttributes( { collapsedAll: !collapsedAll } ) }
                />
            </PanelBody>
        </InspectorControls>
    );
  }
}
