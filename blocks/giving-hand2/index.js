( function( wp ) {
	/**
	 * Registers a new block provided a unique name and an object defining its behavior.
	 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/#registering-a-block
	 */
	var registerBlockType = wp.blocks.registerBlockType;
	/**
	 * Returns a new element of given type. Element is an abstraction layer atop React.
	 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/packages/packages-element/
	 */
	var el = wp.element.createElement;
	/**
	 * Retrieves the translation of text.
	 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/packages/packages-i18n/
	 */
	var __ = wp.i18n.__;

	const { RichText, InspectorControls, MediaUpload, MediaUploadCheck, MediaPlaceholder, InnerBlocks, FontSizePicker  } = wp.blockEditor;
	const { Fragment } = wp.element;
	const withSelect = wp.data.withSelect;

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
	} = wp.components;

	/**
	 * Every block starts by registering a new block type definition.
	 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/#registering-a-block
	 */
	registerBlockType( 'lifeline-donation/giving-hand2', {
		/**
		 * This is the display title for your block, which can be translated with `i18n` functions.
		 * The block inserter will show this name.
		 */
		title: __( 'Giving Hand 2', 'lifeline-donation' ),
		description: __( 'Style 2 for giving hand, a differnt layout for your website to attract donors', 'lifeline-donation' ),
 		keywords: [__('Donation', 'lifeline-donation'), __('Lifeline', 'lifeline-donation'), __('Charity', 'lifeline-donation'), __('Non Profit', 'lifeline-donation')],

		/**
		 * Blocks are grouped into categories to help users browse and discover them.
		 * The categories provided by core are `common`, `embed`, `formatting`, `layout` and `widgets`.
		 */
		category: 'lifeline-donation',

		/**
		 * Optional block extended support features.
		 */
		supports: {
			// Removes support for an HTML mode.
			html: false,
		},

		attributes: {
			bg_color: {
				type: 'string'
			},
			bg_image: {
				type: 'object'
			},
			image: {
				type: 'object'
			},
			icon: {
				type: 'string'
			}
		},

		/**
		 * The edit function describes the structure of your block in the context of the editor.
		 * This represents what the editor will render when the block is used.
		 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-edit-save/#edit
		 *
		 * @param {Object} [props] Properties passed from the editor.
		 * @return {Element}       Element to render.
		 */
		edit: function( props ) {
			const {
        		attributes: {
        			icon,
        			bg_image,
        			bg_color,
        			image,
        		}
        	} = props;
        	
            return [
                el( Fragment, {},
					el( InspectorControls, {},
						el( PanelBody, { title: 'Block Settings', initialOpen: true },
		 
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
										src: (props.attributes.bg_image ) ? props.attributes.bg_image.url : '',
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
												props.setAttributes({bg_image: {id: media.id, url: media.url}})
											},
											value: '',
											render: ({open}) => {
												return el(Button,
													{
														onClick: open,
														className: 'button'
													},
													__('Upload Background Image', 'lifeline-donation')
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
				el('section', {className: 'wpcm-wrapper urgent-popup-list'},
					el('div', {className: 'wpcm-row'},
						el('div', {className: 'wpcm-col-lg-12'},
							el('div', 
								{
									className: 'wpcm-campaign-style2',
									style: {
										backgroundColor: (bg_color) ? bg_color : '',
										backgroundImage: (image) ? 'url('+image.url+')' : ''
									}
								},
								el('div', 
									{
										className: 'strt-campaign-desc',
										style: {
											backgroundImage: (bg_image) ? 'url('+bg_image.url+')' : ''
										}
									},
									el(InnerBlocks, {})
								)
							)
						)
					)
				)
                
                
            ];
		},

		/**
		 * The save function defines the way in which the different attributes should be combined
		 * into the final markup, which is then serialized by Gutenberg into `post_content`.
		 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-edit-save/#save
		 *
		 * @return {Element}       Element to render.
		 */
		save: function(props) {
			const {
        		attributes: {
        			icon,
        			bg_image,
        			bg_color,
        			image,
        		}
        	} = props;

			return el('section', {className: 'wpcm-wrapper urgent-popup-list'},
					el('div', {className: 'wpcm-row'},
						el('div', {className: 'wpcm-col-lg-12'},
							el('div', 
								{
									className: 'wpcm-campaign-style2',
									style: {
										backgroundColor: (bg_color) ? bg_color : '',
										backgroundImage: (image) ? 'url('+image.url+')' : ''
									}
								},
								el('div', 
									{
										className: 'strt-campaign-desc',
										style: {
											backgroundImage: (bg_image) ? 'url('+bg_image.url+')' : ''
										}
									},
									el(InnerBlocks.Content)
								)
							)
						)
					)
				);
		}
	} );
} )(
	window.wp
);
