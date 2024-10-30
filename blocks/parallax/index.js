( function( blocks, editor, element, components ) {
    var el = element.createElement;
    const {__} = wp.i18n;
    const { RichText, InspectorControls, MediaUpload, MediaUploadCheck, InnerBlocks  } = editor;
	const { Fragment } = element;
	const {
		TextControl,
		CheckboxControl,
		RadioControl,
		SelectControl,
		TextareaControl,
		ToggleControl,
		RangeControl,
		Panel,
		PanelBody,
		PanelRow,
		FormFileUpload,
		Button,
		ColorPicker
	} = components;
 	
    blocks.registerBlockType( 'lifeline-donation/parallax', {
        title: __('Donation Parallax', 'lifeline-donation'),
        description: __( 'Parallax style donation block is a unique and beautiful layout that enhance the design of your website', 'lifeline-donation' ),
 		keywords: [__('Donation', 'lifeline-donation'), __('Lifeline', 'lifeline-donation'), __('Charity', 'lifeline-donation'), __('Non Profit', 'lifeline-donation')],
        icon: 'universal-access-alt',
        category: 'lifeline-donation',
 
        attributes: {
        	bg_img: {
        		type: 'object',
        		selector: '.wpcm-campaign-parallax'
        	},
        	bg_color: {
        		type: 'object',
        		selector: '.wpcm-campaign-parallax'
        	},
        	icon: {
        		type: 'object',
        		selector: '.wpcm-campaign-parallax'
        	},
            heading: {
                type: 'array',
                source: 'children',
                selector: 'h2',
            },
            content: {
                type: 'array',
                source: 'children',
                selector: 'p',
            },
            alignment: {
                type: 'string',
                default: 'none',
            },
            enable_popup: {
            	type: 'string',
            	default: 'true'
            },

        },
 
        edit: function( props ) {
            var content = props.attributes.content;
            var heading = props.attributes.heading;
            var alignment = props.attributes.alignment;
            var bgurl = (props.attributes.bg_img) ? props.attributes.bg_img.url : ''
            var bgcolor = (props.attributes.bg_color) ? props.attributes.bg_color : 'rgba(0, 32, 78, 0.9)'
        	var iconurl = (props.attributes.icon) ? props.attributes.icon.url : ''

        	const TEMPLATE = [ [ 'core/columns', {}, [
			    [ 'core/column', {}, [
			        [ 'core/image' ],
			    ] ],
			    [ 'core/column', {}, [
			        [ 'core/paragraph', { placeholder: 'Enter side content...' } ],
			    ] ],
			] ] ];

            function onChangeContent( newContent ) {
                props.setAttributes( { content: newContent } );
            }
 
            function onChangeAlignment( newAlignment ) {
                props.setAttributes( { alignment: newAlignment === undefined ? 'none' : newAlignment } );
            }

            return [
                el( Fragment, {},
					el( InspectorControls, {},
						el( PanelBody, { title: 'Form Settings', initialOpen: true },
		 
							/* Text Field */
							el( PanelRow, {},
								el( TextControl,
									{
										label: __('List ID'),
										onChange: ( value ) => {
											props.setAttributes( { list_id: value } );
										},
										value: props.attributes.list_id
									}
								)
							),
		 
							/* Toggle Field */
							el( PanelRow, {},
								el( ToggleControl,
									{
										label: __('Enable Donation Popup', 'lifeline-donation'),
										onChange: ( value ) => {
											props.setAttributes( { doubleoptin: value } );
										},
										checked: props.attributes.doubleoptin,
									}
								)
							),
							el(PanelRow, {},
								el('p', {},
									el('img', {
										src: (props.attributes.bg_img ) ? props.attributes.bg_img.url : '',
										width: 150,
										height: 150
									})
								)
							),
							el(PanelRow, {},
								el(MediaUploadCheck, {},
									el(MediaUpload,
										{
											allowedTypes: ['image'],
											onSelect: (media) => {
												props.setAttributes({bg_img: {id: media.id, url: media.url}})
											},
											value: '',
											render: ({open}) => {
												return el(Button,
													{
														onClick: open,
														className: 'button'
													},
													__('Upload Image', 'lifeline-donation')
												)
											}
										}
									)
								)
							),
							/* Text Field */
							el( PanelRow, {},
								el( 'label', {}, __('Background Color', 'lifeline-donation')	)
							),
							el( PanelRow, {},
								el( ColorPicker,
									{
										onChangeComplete: ( value ) => {
											props.setAttributes( { bg_color: value.hex } );
										},
										value: props.attributes.bg_color
									},
									'Background Color'
								)
							),
							el(PanelRow, {},
								el('p', {},
									el('img', {
										src: (props.attributes.icon ) ? props.attributes.icon.url : '',
										width: 150,
										height: 150
									})
								)
							),
							el(PanelRow, {},
								el(MediaUploadCheck, {},
									el(MediaUpload,
										{
											allowedTypes: ['image'],
											onSelect: (media) => {
												props.setAttributes({icon: {id: media.id, url: media.url}})
											},
											value: '',
											render: ({open}) => {
												return el(Button,
													{
														onClick: open,
														className: 'button'
													},
													__('Upload Icon', 'lifeline-donation')
												)
											}
										}
									)
								)
							)
		 
						)
		 
					)
		 
					/*  
					 * Here will be your block markup 
					 */
		 
				),
				el('section', {className: 'wpcm-warpper urgent-popup-list ' + (props.className) ? props.className : '', style: {background: bgcolor}},
					(bgurl) ? el('div', {className: 'wpcm-campaign-parallax', style: {background:'url('+bgurl+')'}}) : '',
					el('div', {className: 'wpcm-container'},
		            	el('div', {className: 'wpcm-col-lg-12'},
		            		el('div', {className: 'campaign-para-content text-center wpcm-p-150'},
		            			el('img', {src: iconurl, width: 150, height: 150}),
		            			el(
				                    RichText,
				                    {
				                        key: 'richtext',
				                        tagName: 'h2',
				                        style: { textAlign: alignment },
				                        onChange: (newcontent) => {
				                        	props.setAttributes( { heading: newcontent } );
				                        },
				                        value: heading,
				                    }
				                ),
				                el(
				                    RichText,
				                    {
				                        key: 'richtext',
				                        tagName: 'p',
				                        style: { textAlign: alignment },
				                        onChange: onChangeContent,
				                        value: content,
				                    }
				                ),
				                el( InnerBlocks,{})
		            		)
		            	)
		            )
				),
                
                
            ];
        },
 
        save: function( props ) {

        	var bgurl = (props.attributes.bg_img) ? props.attributes.bg_img.url : ''
        	var bgcolor = (props.attributes.bg_color) ? props.attributes.bg_color : 'rgba(0, 32, 78, 0.9)'
        	var iconurl = (props.attributes.icon) ? props.attributes.icon.url : ''
            return el(
            	'section', {className: 'wpcm-warpper urgent-popup-list ' + (props.className) ? props.className : '', style: {background: bgcolor}},
            	(bgurl) ? el('div', {className: 'wpcm-campaign-parallax', style: 'background:url('+bgurl+')'}) : '',
            	el('div', {className: 'urgent-popup-list'},
	            	el('div', {className: 'wpcm-col-lg-12'},
	            		el('div', {className: 'campaign-para-content text-center wpcm-p-150'},
	            			el('img', {src: iconurl, width: 150, height: 150}),
	            			el( RichText.Content, 
				            	{
					                tagName: 'h2',
					                className: 'gutenberg-donation-parallax-' + props.attributes.alignment,
					                value: props.attributes.heading,
					            }
					            
				            ),
				            el( RichText.Content, 
				            	{
					                tagName: 'p',
					                className: 'donation-parallax-desc-' + props.attributes.alignment,
					                value: props.attributes.content,
					            }
					            
				            ),
				            el(InnerBlocks.Content)
	            		)
	            	)
	            )
            );
        },
    } );
}(
    window.wp.blocks,
    window.wp.blockEditor,
    window.wp.element,
    window.wp.components
) );