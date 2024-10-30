( function( blocks, editor, element, components, data ) {
    var el = element.createElement;
    const {__} = wp.i18n;
    const { RichText, InspectorControls, MediaUpload, MediaUploadCheck, MediaPlaceholder, InnerBlocks, FontSizePicker  } = editor;
	const { Fragment } = element;
	const withSelect = data.withSelect;
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
		PanelHeader,
		FormFileUpload,
		Button,
		ColorPicker,
		DropdownMenu
	} = components;


    blocks.registerBlockType( 'lifeline-donation/parallax-donation-campaign', {
        title: __('Donation Campaign Parallax', 'lifeline-donation'),
        description: __( 'Parallax style 2 donation block is a unique and beautiful layout that enhance the design of your website', 'lifeline-donation' ),
 		keywords: [__('Donation', 'lifeline-donation'), __('Lifeline', 'lifeline-donation'), __('Charity', 'lifeline-donation'), __('Non Profit', 'lifeline-donation')],
        icon: 'universal-access-alt',
        category: 'lifeline-donation',
 
        attributes: {
        	icon: {
        		type: 'object'
        	},
        	bg_color: {
        		type: 'string'
        	},
        	image: {
        		type: 'object'
        	}
        },
 
        edit: function( props ) {

        	const {
        		attributes: {
        			icon,
        			bg_color,
        			image
        		}
        	} = props;
        	
            return [
                el( Fragment, {},
					el( InspectorControls, {},
						el( PanelBody, { title: 'Form Settings', initialOpen: true },
		 
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
									}
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
							),
							el(PanelRow, {},
								el('p', {},
									el('img', {
										src: (props.attributes.image ) ? props.attributes.image.url : '',
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
												props.setAttributes({image: {id: media.id, url: media.url}})
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
							)
							
						)
					)
				),
				el('section', {className: 'wpcm-wrapper'},
					el('div', 
						{
							className: 'wpcm-donation-style2', 
							style: {
								backgroundColor: (bg_color) ? bg_color : ''
							}
						},
						el('div', {className: 'wpcm-row urgent-popup-list'},
							el('div', {className: 'wpcm-col-lg-7'},
								el('div', {className: 'donation-style2-content'},
									el(InnerBlocks, {}),
									(icon) ? el('div', {className: 'wpcm-icon-box'},
										el('span', {},
											el('img', {
												src: icon.url
											})
										)
									) : ''
								)
							),
							el('div', {className: 'wpcm-col-lg-5'},
								el('div', 
									{
										className: 'donation-style2-img'
									},
									el('figure', {},
										(image) ? el('img', {
											src: image.url,
											maxWidth: '100%'
										}) : ''
									)
									
								)
							)
						)
					)
				)
                
                
            ];
        },
 
        save: function( props ) {

        	const {
        		attributes: {
        			icon,
        			bg_color,
        			image
        		}
        	} = props;

        	return el('section', {className: 'wpcm-wrapper'},
					el('div', 
						{
							className: 'wpcm-donation-style2', 
							style: {
								backgroundColor: (bg_color) ? bg_color : ''
							}
						},
						el('div', {className: 'wpcm-row urgent-popup-list'},
							el('div', {className: 'wpcm-col-lg-7'},
								el('div', {className: 'donation-style2-content'},
									el(InnerBlocks.Content),
									(icon) ? el('div', {className: 'wpcm-icon-box'},
										el('span', {},
											el('img', {
												src: icon.url
											})
										)
									) : ''
								)
							),
							el('div', {className: 'wpcm-col-lg-5'},
								el('div', 
									{
										className: 'donation-style2-img'
									},
									el('figure', {},
										(image) ? el('img', {
											src: image.url,
											maxWidth: '100%'
										}) : ''
									)
									
								)
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
    window.wp.components,
    window.wp.data
) );