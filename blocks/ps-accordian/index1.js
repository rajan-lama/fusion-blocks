import classnames from "classnames";
//import Inspector from "./inspector";
import accordionBlockIcon from './icon';
//import HEADER_ICONS from './header-icon';
import accordionAttrs from './attribute';

(function ( wpI18n, wpBlocks, wpElement, wpBlockEditor, wpComponents ) {

    wpBlockEditor = wp.blockEditor || wp.editor;
    const { __ } = wpI18n;
    const { Component, Fragment } = wpElement;
    const { registerBlockType } = wpBlocks;
    const { InspectorControls, RichText, PanelColorSettings, InnerBlocks } = wpBlockEditor;
    const { RangeControl, PanelBody, BaseControl , SelectControl, ToggleControl } = wpComponents;

    const HEADER_ICONS = {
    plus: (
        <Fragment>
            <path fill="none" d="M0,0h24v24H0V0z"/>
            <path d="M19,13h-6v6h-2v-6H5v-2h6V5h2v6h6V13z"/>
        </Fragment>
    ),
    
    plusCircle: (
        <Fragment>
            <path fill="none" d="M0,0h24v24H0V0z"/>
            <path d="M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M17,13h-4v4h-2v-4H7v-2h4V7h2v4h4V13z"/>
        </Fragment>
    ),
    plusCircleOutline: (
        <Fragment>
            <path fill="none" d="M0,0h24v24H0V0z"/>
            <path d="M13,7h-2v4H7v2h4v4h2v-4h4v-2h-4V7z M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M12,20 c-4.41,0-8-3.59-8-8s3.59-8,8-8s8,3.59,8,8S16.41,20,12,20z"/>
        </Fragment>
    ),
    plusBox: (
        <Fragment>
            <path fill="none" d="M0,0h24v24H0V0z"/>
            <path d="M19,3H5C3.89,3,3,3.9,3,5v14c0,1.1,0.89,2,2,2h14c1.1,0,2-0.9,2-2V5C21,3.9,20.1,3,19,3z M19,19H5V5h14V19z"/>
            <polygon points="11,17 13,17 13,13 17,13 17,11 13,11 13,7 11,7 11,11 7,11 7,13 11,13"/>
        </Fragment>
    ),
    unfold: (
        <Fragment>
            <path fill="none" d="M0,0h24v24H0V0z"/>
            <path d="M12,5.83L15.17,9l1.41-1.41L12,3L7.41,7.59L8.83,9L12,5.83z M12,18.17L8.83,15l-1.41,1.41L12,21l4.59-4.59L15.17,15 L12,18.17z"/>
        </Fragment>
    ),
    threeDots: (
        <Fragment>
            <path fill="none" d="M0,0h24v24H0V0z"/>
            <path d="M6,10c-1.1,0-2,0.9-2,2s0.9,2,2,2s2-0.9,2-2S7.1,10,6,10z M18,10c-1.1,0-2,0.9-2,2s0.9,2,2,2s2-0.9,2-2S19.1,10,18,10z M12,10c-1.1,0-2,0.9-2,2s0.9,2,2,2s2-0.9,2-2S13.1,10,12,10z"/>
        </Fragment>
    ),
    arrowDown: (
        <Fragment>
            <path opacity="0.87" fill="none" d="M24,24H0L0,0l24,0V24z"/>
            <path d="M16.59,8.59L12,13.17L7.41,8.59L6,10l6,6l6-6L16.59,8.59z"/>
        </Fragment>
    )
};


    class AdvAccordion extends Component {
        constructor() {
            super( ...arguments );
            this.state = {
                currentAccordion: null,
            }
        }
        componentWillMount() {
            const { attributes, setAttributes } = this.props;
            const currentBlockConfig = advgbDefaultConfig['ppb-accordion'];

            // No override attributes of blocks inserted before
            if (attributes.changed !== true) {
                if (typeof currentBlockConfig === 'object' && currentBlockConfig !== null) {
                    Object.keys(currentBlockConfig).map((attribute) => {
                        if (typeof attributes[attribute] === 'boolean') {
                            attributes[attribute] = !!currentBlockConfig[attribute];
                        } else {
                            attributes[attribute] = currentBlockConfig[attribute];
                        }
                    });
                }

                // Finally set changed attribute to true, so we don't modify anything again
                setAttributes( { changed: true } );
            }
        }

        render() {
            const { isSelected, attributes, setAttributes } = props;
            const {
                header,
                headerBgColor,
                headerTextColor,
                headerIcon,
                headerIconColor,
                bodyBgColor,
                bodyTextColor,
                borderStyle,
                borderWidth,
                borderColor,
                borderRadius,
                marginBottom,
                collapsedAll,
            } = attributes;

            return (
                <Fragment>
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
                    <div className="ppb-accordion-block">
                        <div className="ppb-accordion-header"
                             style={ {
                                 backgroundColor: headerBgColor,
                                 color: headerTextColor,
                                 borderStyle: borderStyle,
                                 borderWidth: borderWidth + 'px',
                                 borderColor: borderColor,
                                 borderRadius: borderRadius + 'px',
                             } }
                        >
                            <span className="ppb-accordion-header-icon">
                                <svg fill={ headerIconColor } xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    { HEADER_ICONS[headerIcon] }
                                </svg>
                            </span>
                            <RichText
                                tagName="h4"
                                value={ header }
                                onChange={ ( value ) => setAttributes( { header: value } ) }
                                unstableOnSplit={ () => null }
                                className="ppb-accordion-header-title"
                                placeholder={ __( 'Enter header…' ) }
                            />
                        </div>
                        <div className="ppb-accordion-body"
                             style={ {
                                 backgroundColor: bodyBgColor,
                                 color: bodyTextColor,
                                 borderStyle: borderStyle,
                                 borderWidth: borderWidth + 'px',
                                 borderColor: borderColor,
                                 borderRadius: borderRadius + 'px',
                             } }
                        >
                            <InnerBlocks />
                        </div>
                    </div>
                </Fragment>
            )
        }
    }

    registerBlockType( 'prosys-power-block/accordion', {
        title: __( 'Accordion' ),
        description: __( 'Easy to create an accordion for your post/page.' ),
        icon: {
            src: accordionBlockIcon,
            foreground: typeof advgbBlocks !== 'undefined' ? advgbBlocks.color : undefined,
        },
        category: 'ppb-category',
        keywords: [ __( 'accordion' ), __( 'list' ), __( 'faq' ) ],
        attributes: accordionAttrs,
        edit: AdvAccordion,
        save: function ( { attributes } ) {
            const {
                header,
                headerBgColor,
                headerTextColor,
                headerIcon,
                headerIconColor,
                bodyBgColor,
                bodyTextColor,
                borderStyle,
                borderWidth,
                borderColor,
                borderRadius,
                marginBottom,
                collapsedAll,
            } = attributes;

            return (
                <div className="ppb-accordion-block" style={ { marginBottom } } data-collapsed={ collapsedAll ? collapsedAll : undefined }>
                    <div className="ppb-accordion-header"
                         style={ {
                             backgroundColor: headerBgColor,
                             color: headerTextColor,
                             borderStyle: borderStyle,
                             borderWidth: borderWidth + 'px',
                             borderColor: borderColor,
                             borderRadius: borderRadius + 'px',
                         } }
                    >
                        <span className="ppb-accordion-header-icon">
                            <svg fill={ headerIconColor } xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                { HEADER_ICONS[headerIcon] }
                            </svg>
                        </span>
                        <h4 className="ppb-accordion-header-title">{ header }</h4>
                    </div>
                    <div className="ppb-accordion-body"
                         style={ {
                             backgroundColor: bodyBgColor,
                             color: bodyTextColor,
                             borderStyle: borderStyle,
                             borderWidth: borderWidth + 'px',
                             borderColor: borderColor,
                             borderRadius: borderRadius + 'px',
                         } }
                    >
                        <InnerBlocks.Content />
                    </div>
                </div>
            );
        },
    } );
})( wp.i18n, wp.blocks, wp.element, wp.blockEditor, wp.components );